<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Google\Analytics\Data\V1beta\Client\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\FilterExpression;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\OrderBy;
use Google\Analytics\Data\V1beta\OrderBy\MetricOrderBy;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\RunRealtimeReportRequest;
use Illuminate\Support\Facades\Cache;

class AnalyticsController extends Controller
{
    /**
     * Buat client GA4 sekali pakai (DRY helper)
     */
  private function makeClient(): BetaAnalyticsDataClient
{
    return new BetaAnalyticsDataClient([
        'credentials' => base_path(config('services.google_analytics.credentials_path'))
    ]);
}

  private function propertyId(): string
{
    return 'properties/' . config('services.google_analytics.property_id');
}
    // =========================================================================
    //  MAIN DASHBOARD
    // =========================================================================
    public function index()
    {
        $error = null;

        // ── 1. Traffic harian 30 hari ────────────────────────────────────────
        $data = Cache::remember('ga_report_30days', 600, function () {
            $rows = [];
            try {
                $client  = $this->makeClient();
                $request = (new RunReportRequest())
                    ->setProperty($this->propertyId())
                    ->setDateRanges([new DateRange(['start_date' => '30daysAgo', 'end_date' => 'today'])])
                    ->setDimensions([new Dimension(['name' => 'date'])])
                    ->setMetrics([
                        new Metric(['name' => 'sessions']),
                        new Metric(['name' => 'activeUsers']),
                        new Metric(['name' => 'screenPageViews']),
                    ])
                    ->setOrderBys([
                        (new OrderBy())->setDimension(
                            new OrderBy\DimensionOrderBy(['dimension_name' => 'date'])
                        )
                    ]);

                $response = $client->runReport($request);

                foreach ($response->getRows() as $row) {
                    $date   = $row->getDimensionValues()[0]->getValue();
                    $rows[] = [
                        'date'      => substr($date, 0, 4) . '-' . substr($date, 4, 2) . '-' . substr($date, 6, 2),
                        'sessions'  => (int) $row->getMetricValues()[0]->getValue(),
                        'users'     => (int) $row->getMetricValues()[1]->getValue(),
                        'pageviews' => (int) $row->getMetricValues()[2]->getValue(),
                    ];
                }
            } catch (\Exception $e) {
                session()->flash('ga_error', $e->getMessage());
            }
            return $rows;
        });

        // ── 2. Breakdown per negara ───────────────────────────────────────────
        $countries = Cache::remember('ga_countries_30days', 600, function () {
            $rows = [];
            try {
                $client  = $this->makeClient();
                $request = (new RunReportRequest())
                    ->setProperty($this->propertyId())
                    ->setDateRanges([new DateRange(['start_date' => '30daysAgo', 'end_date' => 'today'])])
                    ->setDimensions([
                        new Dimension(['name' => 'country']),
                        new Dimension(['name' => 'countryId']),  // kode ISO: ID, US, MY ...
                    ])
                    ->setMetrics([
                        new Metric(['name' => 'sessions']),
                        new Metric(['name' => 'activeUsers']),
                        new Metric(['name' => 'screenPageViews']),
                    ])
                    ->setOrderBys([
                        (new OrderBy())
                            ->setMetric(new MetricOrderBy(['metric_name' => 'sessions']))
                            ->setDesc(true)
                    ])
                    ->setLimit(20);

                $response = $client->runReport($request);

                foreach ($response->getRows() as $row) {
                    $rows[] = [
                        'country'   => $row->getDimensionValues()[0]->getValue(),
                        'code'      => strtoupper($row->getDimensionValues()[1]->getValue()),
                        'sessions'  => (int) $row->getMetricValues()[0]->getValue(),
                        'users'     => (int) $row->getMetricValues()[1]->getValue(),
                        'pageviews' => (int) $row->getMetricValues()[2]->getValue(),
                    ];
                }
            } catch (\Exception $e) {
                // negara tetap kosong — tidak crash dashboard utama
            }
            return $rows;
        });

        // ── 3. Top halaman (page breakdown) ─────────────────────────────────
        $topPages = Cache::remember('ga_toppages_30days', 600, function () {
            $rows = [];
            try {
                $client  = $this->makeClient();
                $request = (new RunReportRequest())
                    ->setProperty($this->propertyId())
                    ->setDateRanges([new DateRange(['start_date' => '30daysAgo', 'end_date' => 'today'])])
                    ->setDimensions([
                        new Dimension(['name' => 'pageTitle']),
                        new Dimension(['name' => 'pagePath']),
                    ])
                    ->setMetrics([
                        new Metric(['name' => 'screenPageViews']),
                        new Metric(['name' => 'activeUsers']),
                        new Metric(['name' => 'averageSessionDuration']),
                    ])
                    ->setOrderBys([
                        (new OrderBy())
                            ->setMetric(new MetricOrderBy(['metric_name' => 'screenPageViews']))
                            ->setDesc(true)
                    ])
                    ->setLimit(15);

                $response = $client->runReport($request);

                foreach ($response->getRows() as $row) {
                    $rows[] = [
                        'title'    => $row->getDimensionValues()[0]->getValue(),
                        'path'     => $row->getDimensionValues()[1]->getValue(),
                        'views'    => (int) $row->getMetricValues()[0]->getValue(),
                        'users'    => (int) $row->getMetricValues()[1]->getValue(),
                        'avg_time' => round((float) $row->getMetricValues()[2]->getValue()),
                    ];
                }
            } catch (\Exception $e) {
                // biarkan kosong
            }
            return $rows;
        });

        // ── 4. Button clicks & event tracking ────────────────────────────────
        //
        // GA4 mencatat event custom "button_click" yang dipasang via gtag()
        // di website publik. Parameter yang diambil:
        //   - eventName       : nama event (button_click, link_click, dsb.)
        //   - customEvent:button_text : label tombol (Book Now, WhatsApp, dsb.)
        //
        $events = Cache::remember('ga_events_30days', 600, function () {
            $rows = [];
            try {
                $client = $this->makeClient();

                // Filter: hanya ambil event yang mengandung kata 'click'
                $clickFilter = new FilterExpression([
                    'filter' => new Filter([
                        'field_name'    => 'eventName',
                        'string_filter' => new StringFilter([
                            'match_type' => MatchType::CONTAINS,
                            'value'      => 'click',
                            'case_sensitive' => false,
                        ]),
                    ]),
                ]);

                $request = (new RunReportRequest())
                    ->setProperty($this->propertyId())
                    ->setDateRanges([new DateRange(['start_date' => '30daysAgo', 'end_date' => 'today'])])
                    ->setDimensions([
                        new Dimension(['name' => 'eventName']),
                        // customEvent: hanya tersedia jika sudah ada di custom dimensions GA4
                        // Kalau belum, hapus baris ini — pakai eventName saja
                        new Dimension(['name' => 'customEvent:button_text']),
                    ])
                    ->setMetrics([
                        new Metric(['name' => 'eventCount']),
                        new Metric(['name' => 'totalUsers']),
                    ])
                    ->setDimensionFilter($clickFilter)
                    ->setOrderBys([
                        (new OrderBy())
                            ->setMetric(new MetricOrderBy(['metric_name' => 'eventCount']))
                            ->setDesc(true)
                    ])
                    ->setLimit(20);

                $response = $client->runReport($request);

                foreach ($response->getRows() as $row) {
                    $btnText = $row->getDimensionValues()[1]->getValue();
                    $rows[] = [
                        'event_name'  => $row->getDimensionValues()[0]->getValue(),
                        'button_text' => ($btnText && $btnText !== '(not set)') ? $btnText : null,
                        'count'       => (int) $row->getMetricValues()[0]->getValue(),
                        'users'       => (int) $row->getMetricValues()[1]->getValue(),
                    ];
                }
            } catch (\Exception $e) {
                // Jika custom dimension belum dibuat di GA4, coba tanpa button_text
                try {
                    $client  = $this->makeClient();
                    $request = (new RunReportRequest())
                        ->setProperty($this->propertyId())
                        ->setDateRanges([new DateRange(['start_date' => '30daysAgo', 'end_date' => 'today'])])
                        ->setDimensions([new Dimension(['name' => 'eventName'])])
                        ->setMetrics([
                            new Metric(['name' => 'eventCount']),
                            new Metric(['name' => 'totalUsers']),
                        ])
                        ->setOrderBys([
                            (new OrderBy())
                                ->setMetric(new MetricOrderBy(['metric_name' => 'eventCount']))
                                ->setDesc(true)
                        ])
                        ->setLimit(20);

                    $response = $client->runReport($request);

                    foreach ($response->getRows() as $row) {
                        $rows[] = [
                            'event_name'  => $row->getDimensionValues()[0]->getValue(),
                            'button_text' => null,
                            'count'       => (int) $row->getMetricValues()[0]->getValue(),
                            'users'       => (int) $row->getMetricValues()[1]->getValue(),
                        ];
                    }
                } catch (\Exception $e2) {
                    // biarkan kosong
                }
            }
            return $rows;
        });

        // ── 5. Breakdown per Device Category ──────────────────────────────────
        $devices = Cache::remember('ga_devices_30days', 600, function () {
            $rows = [];
            try {
                $client  = $this->makeClient();
                $request = (new RunReportRequest())
                    ->setProperty($this->propertyId())
                    ->setDateRanges([new DateRange(['start_date' => '30daysAgo', 'end_date' => 'today'])])
                    ->setDimensions([new Dimension(['name' => 'deviceCategory'])])
                    ->setMetrics([new Metric(['name' => 'sessions'])])
                    ->setOrderBys([
                        (new OrderBy())
                            ->setMetric(new MetricOrderBy(['metric_name' => 'sessions']))
                            ->setDesc(true)
                    ]);

                $response = $client->runReport($request);

                foreach ($response->getRows() as $row) {
                    $rows[] = [
                        'device'   => $row->getDimensionValues()[0]->getValue(),
                        'sessions' => (int) $row->getMetricValues()[0]->getValue(),
                    ];
                }
            } catch (\Exception $e) {
                // biarkan kosong
            }
            return $rows;
        });

        // ── 6. Breakdown per Traffic Source ──────────────────────────────────
        $sources = Cache::remember('ga_sources_30days', 600, function () {
            $rows = [];
            try {
                $client  = $this->makeClient();
                $request = (new RunReportRequest())
                    ->setProperty($this->propertyId())
                    ->setDateRanges([new DateRange(['start_date' => '30daysAgo', 'end_date' => 'today'])])
                    ->setDimensions([new Dimension(['name' => 'sessionSourceMedium'])])
                    ->setMetrics([new Metric(['name' => 'sessions'])])
                    ->setOrderBys([
                        (new OrderBy())
                            ->setMetric(new MetricOrderBy(['metric_name' => 'sessions']))
                            ->setDesc(true)
                    ])
                    ->setLimit(10);

                $response = $client->runReport($request);

                foreach ($response->getRows() as $row) {
                    $rows[] = [
                        'source'   => $row->getDimensionValues()[0]->getValue(),
                        'sessions' => (int) $row->getMetricValues()[0]->getValue(),
                    ];
                }
            } catch (\Exception $e) {
                // biarkan kosong
            }
            return $rows;
        });

        // Ambil error dari session jika ada
        if (session()->has('ga_error')) {
            $error = session()->get('ga_error');
        }

        return view('admin.analytics', compact('data', 'countries', 'topPages', 'events', 'devices', 'sources', 'error'));
    }

    // =========================================================================
    //  REALTIME (dipanggil via AJAX setiap 60 detik)
    // =========================================================================
    public function realtime()
    {
        $result = Cache::remember('ga_realtime', 60, function () {
            try {
                $client = $this->makeClient();

                $request = (new RunRealtimeReportRequest())
                    ->setProperty($this->propertyId())
                    ->setMetrics([new Metric(['name' => 'activeUsers'])])
                    ->setDimensions([
                        new Dimension(['name' => 'unifiedScreenName']),
                        new Dimension(['name' => 'city']),
                        new Dimension(['name' => 'countryId']),
                    ]);

                $response = $client->runRealtimeReport($request);

                $pages       = [];
                $totalActive = 0;

                foreach ($response->getRows() as $row) {
                    $users        = (int) $row->getMetricValues()[0]->getValue();
                    $totalActive += $users;
                    $pages[]      = [
                        'page'    => $row->getDimensionValues()[0]->getValue(),
                        'city'    => $row->getDimensionValues()[1]->getValue(),
                        'country' => $row->getDimensionValues()[2]->getValue(),
                        'users'   => $users,
                    ];
                }

                // Urutkan halaman dari yang paling banyak pengunjung
                usort($pages, fn($a, $b) => $b['users'] - $a['users']);

                return [
                    'active_users' => $totalActive,
                    'pages'        => $pages,
                ];

            } catch (\Exception $e) {
                return ['error' => $e->getMessage()];
            }
        });

        return response()->json($result);
    }

    // =========================================================================
    //  CLEAR CACHE (opsional — bisa dipanggil via route /admin/analytics/clear-cache)
    // =========================================================================
    public function clearCache()
    {
        Cache::forget('ga_report_30days');
        Cache::forget('ga_countries_30days');
        Cache::forget('ga_toppages_30days');
        Cache::forget('ga_events_30days');
        Cache::forget('ga_devices_30days');
        Cache::forget('ga_sources_30days');
        Cache::forget('ga_realtime');

        return back()->with('success', 'Cache analytics berhasil dibersihkan.');
    }
}