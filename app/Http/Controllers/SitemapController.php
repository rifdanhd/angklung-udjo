<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Show;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml dinamis dari database.
     * Di-cache 1 jam supaya tidak query DB di setiap request crawler.
     *
     * Output: XML sitemap valid untuk Google/Bing/Yandex.
     */
    public function index(): Response
    {
        $xml = Cache::remember('sitemap.xml', 3600, function () {
            return $this->buildXml();
        });

        return response($xml, 200, [
            'Content-Type'  => 'application/xml; charset=utf-8',
            'X-Robots-Tag'  => 'noindex',
        ]);
    }

    /**
     * Bangun string XML sitemap.
     */
    private function buildXml(): string
    {
        $urls = collect();

        // ── Static Pages (HIGH priority) ────────────────────────────
        $staticPages = [
            ['url' => route('home'),                       'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => route('about'),                      'priority' => '0.8', 'changefreq' => 'monthly'],
            ['url' => route('booking.ticket.index'),       'priority' => '0.9', 'changefreq' => 'weekly'],
            ['url' => route('contact'),                    'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('shows.index'),                'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('products.index'),             'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('articles.index'),             'priority' => '0.8', 'changefreq' => 'weekly'],
            ['url' => route('gallery.index'),              'priority' => '0.7', 'changefreq' => 'monthly'],
            ['url' => route('partnership.index'),          'priority' => '0.6', 'changefreq' => 'monthly'],
            ['url' => route('privacy-policy'),             'priority' => '0.3', 'changefreq' => 'yearly'],
            ['url' => route('heritage.angklung'),          'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $urls->push([
                'loc'        => $page['url'],
                'lastmod'    => now()->toAtomString(),
                'changefreq' => $page['changefreq'],
                'priority'   => $page['priority'],
            ]);
        }

        // ── Articles (dinamis) ───────────────────────────────────────
        try {
            Article::query()
                ->select(['slug', 'updated_at'])
                ->latest('updated_at')
                ->limit(500)
                ->get()
                ->each(function ($article) use ($urls) {
                    $urls->push([
                        'loc'        => route('articles.show', $article->slug),
                        'lastmod'    => optional($article->updated_at)->toAtomString() ?? now()->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority'   => '0.7',
                    ]);
                });
        } catch (\Throwable $e) {
            // skip kalau model/tabel belum ada
        }

        // ── Products (dinamis) ───────────────────────────────────────
        try {
            Product::query()
                ->select(['slug', 'updated_at'])
                ->latest('updated_at')
                ->limit(500)
                ->get()
                ->each(function ($product) use ($urls) {
                    $urls->push([
                        'loc'        => route('products.show', $product->slug),
                        'lastmod'    => optional($product->updated_at)->toAtomString() ?? now()->toAtomString(),
                        'changefreq' => 'monthly',
                        'priority'   => '0.6',
                    ]);
                });
        } catch (\Throwable $e) {
            // skip
        }

        // ── Shows / Pertunjukan (dinamis) ────────────────────────────
        try {
            Show::query()
                ->select(['id', 'updated_at'])
                ->latest('updated_at')
                ->limit(200)
                ->get()
                ->each(function ($show) use ($urls) {
                    $urls->push([
                        'loc'        => route('shows.show', $show->id),
                        'lastmod'    => optional($show->updated_at)->toAtomString() ?? now()->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority'   => '0.7',
                    ]);
                });
        } catch (\Throwable $e) {
            // skip
        }

        // ── Build XML ────────────────────────────────────────────────
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
        $xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url['loc'], ENT_QUOTES, 'UTF-8') . "</loc>\n";
            $xml .= "    <lastmod>{$url['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$url['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$url['priority']}</priority>\n";

            // hreflang (untuk halaman bilingual)
            $xml .= '    <xhtml:link rel="alternate" hreflang="id" href="' . htmlspecialchars($url['loc'], ENT_QUOTES, 'UTF-8') . '"/>' . "\n";
            $xml .= '    <xhtml:link rel="alternate" hreflang="en" href="' . htmlspecialchars($url['loc'], ENT_QUOTES, 'UTF-8') . '"/>' . "\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }

    /**
     * Force refresh sitemap cache (bisa dipanggil setelah publish artikel/produk baru).
     * Akses: /sitemap.xml/refresh (proteksi via auth admin kalau perlu)
     */
    public function refresh(): Response
    {
        Cache::forget('sitemap.xml');
        return $this->index();
    }
}
