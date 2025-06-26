<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Gifts - Bake My Day</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <script>
        // --- Konfigurasi Palet Warna Gelap ---
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-primary': 'rgb(0, 0, 0)',
                        'dark-secondary': 'rgb(10, 10, 10)',
                        'dark-border': 'rgb(40, 40, 40)',
                        'text-base': 'rgb(245, 245, 245)',
                        'text-accent': 'rgb(254, 198, 228)',
                        'text-muted': '#b0b0b0',
                        'text-white': '#ffffff',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dark-primary text-base font-medium">

    @include('layouts.navigation')

    <div class="bg-dark-secondary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                <div class="w-full md:w-1/2 text-center md:text-left">
                    <h1 class="text-4xl lg:text-5xl font-medium text-text-accent mb-4">Celebrate with a Slice of Joy</h1>
                    <p class="text-lg text-white mb-8">
                        Every birthday deserves something mega. Surprise them (or yourself) with an iconic Bake My Day dessert delivery. We ship our award-winning treats nationwide, straight to your door!
                    </p>
                    <a href="#product-grid" class="inline-block bg-text-accent text-dark-primary font-medium py-3 px-8 rounded-lg hover:bg-opacity-90 transition-colors duration-300">
                        Explore Cakes
                    </a>
                </div>
                <div class="w-full md:w-1/2">
                    <img src="{{ asset('images/birthday.jpg') }}" alt="Birthday Celebration" 
                         class="rounded-lg shadow-2xl w-full object-cover aspect-square border-4 border-dark-border">
                </div>
            </div>
        </div>
    </div>

    <div id="product-grid" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 pb-4 border-b border-dark-border">
            <h2 class="text-3xl font-medium text-text-base mb-4 sm:mb-0">Our Birthday Selection</h2>
            <div class="flex items-center">
                <label for="sortSelect" class="text-muted mr-3">Sort by:</label>
                <select id="sortSelect" class="bg-dark-secondary border border-dark-border text-text-base rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-text-accent">
                    <option value="featured">Featured</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                </select>
            </div>
        </div>

        @if(isset($birthdayCakes) && count($birthdayCakes) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($birthdayCakes as $cake)
            <div class="bg-dark-secondary rounded-lg overflow-hidden border border-dark-border flex flex-col group cake-item transition-all duration-300 hover:border-text-accent hover:shadow-2xl hover:shadow-text-accent/10" 
                 data-price="{{ $cake->price }}">
                
                <div class="relative">
                    @php
                        $images = json_decode($cake->images);
                        $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                    @endphp
                    <img src="{{ $firstImage ? asset('storage/'.$firstImage) : asset('images/birthday.jpg') }}" alt="{{ $cake->name }}" 
                         class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-105">
                    
                    @if($cake->stok < 5 && $cake->stok > 0)
                        <div class="absolute top-3 left-3 bg-yellow-600 text-white text-xs font-medium px-2.5 py-1 rounded-full">LIMITED</div>
                    @elseif($cake->stok >= 5)
                        <div class="absolute top-3 left-3 bg-green-600 text-white text-xs font-medium px-2.5 py-1 rounded-full">AVAILABLE</div>
                    @endif
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    {{-- Kustomisasi kue dihapus, kembali ke data dinamis --}}
                    <h3 class="text-xl font-medium text-text-base mb-2 group-hover:text-text-accent transition-colors">{{ $cake->name }}</h3>
                    <p class="text-muted text-sm mb-4 flex-grow">{{ Str::limit($cake->description, 100) }}</p>
                    <p class="text-muted text-sm mb-4">Flavor: {{ $cake->flavor ?? 'Assorted' }}</p>
                    
                    <div class="flex justify-between items-center mt-auto pt-4 border-t border-dark-border">
                        <span class="text-2xl font-medium text-text-accent">Rp {{ number_format($cake->price, 0, ',', '.') }}</span>
                        <span class="text-sm text-muted">Stock: {{ $cake->stok }}</span>
                    </div>
                </div>

                <div class="p-6 pt-0">
                     @if($cake->available && $cake->stok > 0)
                    <form action="{{ route('carts.store') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $cake->id }}">
                        <button type="submit" class="w-full bg-text-accent text-dark-primary font-medium py-3 px-4 rounded-lg transition-all duration-300 hover:bg-opacity-90">
                            Add to Cart
                        </button>
                    </form>
                    @else
                    <button disabled class="w-full border-2 border-gray-600 text-gray-600 font-medium py-3 px-4 rounded-lg cursor-not-allowed">
                        Out of Stock
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-20 bg-dark-secondary rounded-lg">
            <p class="text-2xl text-muted">No Birthday Cakes Available</p>
            <p class="text-base text-muted mt-2">Please check back later for our new creations.</p>
        </div>
        @endif
    </div>

    {{-- SEMUA BAGIAN DI BAWAH INI (SHIPPING BANNER & FOOTER) TELAH DIHAPUS --}}

    <script>
        // --- Skrip untuk sort/filter produk ---
        document.addEventListener('DOMContentLoaded', function() {
            const sortSelect = document.getElementById('sortSelect');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    sortCakes(this.value);
                });
            }

            function sortCakes(sortType) {
                const cakeContainer = document.querySelector('.grid');
                if (!cakeContainer) return;
                const cakes = Array.from(cakeContainer.querySelectorAll('.cake-item'));
                
                cakes.sort(function(a, b) {
                    if (sortType === 'featured') return 0;
                    const priceA = parseFloat(a.getAttribute('data-price'));
                    const priceB = parseFloat(b.getAttribute('data-price'));
                    if (sortType === 'price-asc') return priceA - priceB;
                    if (sortType === 'price-desc') return priceB - a;
                    return 0;
                });
                
                cakeContainer.innerHTML = '';
                cakes.forEach(function(cake) {
                    cakeContainer.appendChild(cake);
                });
            }
        });
    </script>
</body>
</html>