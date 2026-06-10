{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name . ' - Produk')

@section('content')

<!-- Product Detail Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">

        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-amber-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-amber-600">Produk</a>
            <span class="mx-2">/</span>
            <span class="text-amber-600">{{ $product->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12">

            <!-- Product Images -->
            <div>
                <!-- Main Image -->
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-4">
                    @if($product->images && count($product->images) > 0)
                        <img id="main-image"
                             src="{{ asset('storage/' . $product->images[0]) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 flex items-center justify-center bg-gray-200">
                            <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Images -->
                @if($product->images && count($product->images) > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                    <div class="cursor-pointer hover:opacity-75 transition"
                         onclick="changeImage('{{ asset('storage/' . $image) }}')">
                        <img src="{{ asset('storage/' . $image) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-24 object-cover rounded-lg shadow">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <!-- Category Badge -->
                <span class="inline-block px-4 py-2 rounded-full text-sm font-medium bg-amber-100 text-amber-800 mb-4">
                    {{ ucfirst($product->category) }}
                </span>

                <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>

                <!-- Price -->
                <div class="mb-6">
                    <p class="text-5xl font-bold text-amber-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Stock Status -->
                <div class="mb-6">
                    @if($product->isInStock())
                        <div class="flex items-center gap-2 text-green-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">Stok Tersedia ({{ $product->stock }})</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-red-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">Stok Habis</span>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Deskripsi Produk</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                </div>

                <!-- Contact Buttons -->
                <div class="space-y-4">
                    <a href="https://wa.me/6222727171?text=Halo, saya tertarik dengan {{ $product->name }}"
                       target="_blank"
                       class="w-full bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg font-semibold transition flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Pesan via WhatsApp
                    </a>

                    <a href="{{ route('contact') }}"
                       class="w-full bg-amber-600 hover:bg-amber-700 text-white px-8 py-4 rounded-lg font-semibold transition flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>

                <!-- Share -->
                <div class="mt-8 pt-8 border-t">
                    <p class="text-sm text-gray-600 mb-3">Bagikan produk ini:</p>
                    <div class="flex gap-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                           target="_blank"
                           class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $product->name }}"
                           target="_blank"
                           class="w-10 h-10 bg-sky-500 hover:bg-sky-600 text-white rounded-full flex items-center justify-center transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="https://wa.me/?text={{ $product->name }} - {{ url()->current() }}"
                           target="_blank"
                           class="w-10 h-10 bg-green-600 hover:bg-green-700 text-white rounded-full flex items-center justify-center transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-20">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Produk Terkait</h2>

            <div class="grid md:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related) }}"
                   class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition group">
                    <div class="relative h-48 bg-gray-200 overflow-hidden">
                        @if($related->images && count($related->images) > 0)
                            <img src="{{ asset('storage/' . $related->images[0]) }}"
                                 alt="{{ $related->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-800 mb-2 line-clamp-2">{{ $related->name }}</h3>
                        <p class="text-xl font-bold text-amber-600">
                            Rp {{ number_format($related->price, 0, ',', '.') }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</section>

@endsection

@push('scripts')

    <script>
    function changeImage(src) {
        document.getElementById('main-image').src = src;
    }
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ $product->name }}",
  "description": "{{ Str::limit(strip_tags($product->description), 200) }}",
  "image": [
    @if($product->images && count($product->images) > 0)
      @foreach($product->images as $image)
        "{{ asset('storage/' . $image) }}"{{ !$loop->last ? ',' : '' }}
      @endforeach
    @endif
  ],
  "category": "{{ ucfirst($product->category) }}",
  "brand": {
    "@type": "Brand",
    "name": "Angklung Udjo"
  },
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "price": "{{ $product->price }}",
    "priceCurrency": "IDR",
    "availability": "https://schema.org/{{ $product->isInStock() ? 'InStock' : 'OutOfStock' }}",
    "seller": {
      "@type": "Organization",
      "name": "Angklung Udjo"
    },
    "hasMerchantReturnPolicy": {
      "@type": "MerchantReturnPolicy",
      "applicableCountry": "ID",
      "returnPolicyCategory": "https://schema.org/MerchantReturnNotSupported"
    },
    "shippingDetails": {
      "@type": "OfferShippingDetails",
      "shippingRate": {
        "@type": "MonetaryAmount",
        "value": "0",
        "currency": "IDR"
      },
      "shippingDestination": {
        "@type": "DefinedRegion",
        "addressCountry": "ID"
      },
      "deliveryTime": {
        "@type": "ShippingDeliveryTime",
        "handlingTime": {
          "@type": "QuantitativeValue",
          "minValue": 1,
          "maxValue": 3,
          "unitCode": "DAY"
        },
        "transitTime": {
          "@type": "QuantitativeValue",
          "minValue": 2,
          "maxValue": 7,
          "unitCode": "DAY"
        }
      }
    }
  }
}

</script>
@endpush
