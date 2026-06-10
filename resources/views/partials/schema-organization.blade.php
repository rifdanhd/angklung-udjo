{{--
  ┌──────────────────────────────────────────────────────────────────┐
  │  Schema.org JSON-LD — Saung Angklung Udjo                         │
  │                                                                    │
  │  Dipasang di SEMUA halaman (di layout)                            │
  │  Membantu Google paham bahwa SAU adalah:                          │
  │  - Organization (institusi budaya)                                │
  │  - TouristAttraction (destinasi wisata)                           │
  │  - LocalBusiness (bisnis lokal dgn jam buka & alamat)            │
  └──────────────────────────────────────────────────────────────────┘
--}}

{{-- Organization Schema --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "@id": "{{ url('/') }}#organization",
    "name": "Saung Angklung Udjo",
    "alternateName": ["SAU", "Saung Mang Udjo"],
    "url": "{{ url('/') }}",
    "logo": {
        "@type": "ImageObject",
        "url": "{{ asset('images/UdjoFullColor.png') }}",
        "width": 512,
        "height": 512
    },
    "image": "{{ asset('images/UdjoFullColor.png') }}",
    "description": "Saung Angklung Udjo adalah pusat seni dan budaya tradisional Sunda yang didirikan tahun 1966 oleh Udjo Ngalagena. Angklung yang ditampilkan di sini telah diakui UNESCO sebagai Warisan Budaya Tak Benda Dunia.",
    "foundingDate": "1966",
    "founder": {
        "@type": "Person",
        "name": "Udjo Ngalagena"
    },
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jl. Padasuka No. 118",
        "addressLocality": "Bandung",
        "addressRegion": "Jawa Barat",
        "postalCode": "40192",
        "addressCountry": "ID"
    },
    "contactPoint": [
        {
            "@type": "ContactPoint",
            "telephone": "+62-821-8282-1200",
            "contactType": "Reservations",
            "areaServed": "ID",
            "availableLanguage": ["Indonesian", "English"]
        },
        {
            "@type": "ContactPoint",
            "telephone": "+62-821-8282-1200",
            "contactType": "Customer Service",
            "areaServed": "ID",
            "availableLanguage": ["Indonesian", "English"]
        }
    ],
    "sameAs": [
        "https://www.instagram.com/angklungudjo",
        "https://www.facebook.com/saungangklungudjo",
        "https://www.youtube.com/@saungangklungudjo",
        "https://www.tiktok.com/@saungangklungudjo"
    ]
}
</script>

{{-- Tourist Attraction Schema --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "TouristAttraction",
    "@id": "{{ url('/') }}#attraction",
    "name": "Saung Angklung Udjo",
    "description": "Pusat seni budaya UNESCO di Bandung yang menampilkan pertunjukan angklung interaktif, wayang golek, tari tradisional Sunda, dan workshop pembuatan angklung.",
    "url": "{{ url('/') }}",
    "image": [
        "{{ asset('images/UdjoFullColor.png') }}"
    ],
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jl. Padasuka No. 118",
        "addressLocality": "Bandung",
        "addressRegion": "Jawa Barat",
        "postalCode": "40192",
        "addressCountry": "ID"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": -6.9027,
        "longitude": 107.6532
    },
    "telephone": "+62-821-8282-1200",
    "openingHoursSpecification": [
        {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
            "opens": "08:00",
            "closes": "17:00"
        },
        {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Saturday", "Sunday"],
            "opens": "08:00",
            "closes": "17:30"
        }
    ],
    "isAccessibleForFree": false,
    "publicAccess": true,
    "tourBookingPage": "{{ route('tickets.buy') }}",
    "amenityFeature": [
        { "@type": "LocationFeatureSpecification", "name": "Parkir", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Toilet", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Kafe & Restoran", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Toko Souvenir", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Workshop Angklung", "value": true },
        { "@type": "LocationFeatureSpecification", "name": "Pertunjukan Harian", "value": true }
    ]
}
</script>

{{-- LocalBusiness Schema (untuk Google Maps & local search) --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "PerformingArtsTheater",
    "@id": "{{ url('/') }}#localbusiness",
    "name": "Saung Angklung Udjo",
    "image": "{{ asset('images/UdjoFullColor.png') }}",
    "url": "{{ url('/') }}",
    "telephone": "+62-821-8282-1200",
    "priceRange": "Rp 60.000 - Rp 120.000",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Jl. Padasuka No. 118",
        "addressLocality": "Bandung",
        "addressRegion": "Jawa Barat",
        "postalCode": "40192",
        "addressCountry": "ID"
    },
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": -6.9027,
        "longitude": 107.6532
    },
    "openingHoursSpecification": [
        {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
            "opens": "08:00",
            "closes": "17:00"
        },
        {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Saturday", "Sunday"],
            "opens": "08:00",
            "closes": "17:30"
        }
    ],
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.7",
        "reviewCount": "16933",
        "bestRating": "5",
        "worstRating": "1"
    }
}
</script>

{{-- WebSite Schema (untuk Sitelinks searchbox di Google) --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "@id": "{{ url('/') }}#website",
    "url": "{{ url('/') }}",
    "name": "Saung Angklung Udjo",
    "description": "Wisata Budaya UNESCO di Bandung",
    "publisher": {
        "@id": "{{ url('/') }}#organization"
    },
    "inLanguage": ["id-ID", "en-US"]
}
</script>
