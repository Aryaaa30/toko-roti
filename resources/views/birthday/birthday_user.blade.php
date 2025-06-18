<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Gifts - Bake My Day</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pink-primary': '#FF6295',
                        'pink-light': '#FFD0E9',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    @include('layouts.navigation')

    <!-- Hero Section -->
    <div class="bg-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center">
                <div class="w-full md:w-1/2 mb-8 md:mb-0">
                    <img src="{{ asset('images/birthday.jpg') }}" alt="Birthday Celebration" 
                         class="rounded-lg shadow-lg w-full object-cover">
                </div>
                <div class="w-full md:w-1/2 md:pl-12">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Birthday Gifts</h1>
                    <p class="text-lg text-gray-600 mb-6">
                        We believe in dessert for every occasion, but birthdays call for something mega. Celebrate yourself
                        or surprise someone else with an iconic Bake My Day dessert delivery (so much tastier than sending a birthday
                        text!) We ship our award-winning desserts nationwide straight to your door!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Birthday Cakes from Database -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Our Birthday Cakes</h2>
            <div class="flex items-center">
                <span class="text-gray-500 mr-2">Filter:</span>
                <select id="sortSelect" class="border border-gray-300 rounded-md py-1 px-3 focus:outline-none focus:ring-2 focus:ring-pink-primary">
                    <option value="featured">Featured</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                </select>
            </div>
        </div>

        @if(isset($birthdayCakes) && count($birthdayCakes) > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($birthdayCakes as $cake)
            <div class="bg-[#FFF6EA] rounded-lg overflow-hidden shadow-md cake-item" 
                 data-price="{{ $cake->price }}">
                <div class="relative">
                    @if($cake->images)
                        @php
                            $images = json_decode($cake->images);
                            $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                        @endphp
                        @if($firstImage)
                            <img src="{{ asset('storage/'.$firstImage) }}" alt="{{ $cake->name }}" 
                                 class="w-full h-64 object-cover">
                        @else
                            <img src="{{ asset('images/birthday.jpg') }}" alt="{{ $cake->name }}" 
                                 class="w-full h-64 object-cover">
                        @endif
                    @else
                        <img src="{{ asset('images/birthday.jpg') }}" alt="{{ $cake->name }}" 
                             class="w-full h-64 object-cover">
                    @endif
                    
                    @if($cake->stok < 5 && $cake->stok > 0)
                        <div class="absolute top-3 left-3 bg-yellow-500 text-white text-xs px-2 py-1 rounded">LIMITED STOCK</div>
                    @elseif($cake->stok >= 5)
                        <div class="absolute top-3 left-3 bg-pink-primary text-white text-xs px-2 py-1 rounded">AVAILABLE</div>
                    @else
                        <div class="absolute top-3 left-3 bg-gray-500 text-white text-xs px-2 py-1 rounded">OUT OF STOCK</div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">{{ $cake->name }}</h3>
                    <p class="text-gray-600 mb-2">{{ Str::limit($cake->description, 100) }}</p>
                    <p class="text-gray-600 mb-4"><strong>Rasa:</strong> {{ $cake->flavor ?? 'Assorted' }}</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xl font-bold text-pink-primary">Rp {{ number_format($cake->price, 0, ',', '.') }}</span>
                        <span class="text-sm text-gray-500">Stock: {{ $cake->stok }}</span>
                    </div>
                    <div class="flex justify-center">
                        @if($cake->available && $cake->stok > 0)
                        <form action="{{ route('carts.store') }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $cake->id }}">
                            <button type="submit" class="w-full bg-black hover:bg-pink-primary text-white font-semibold py-3 px-4 rounded transition duration-200">
                                Add to Cart
                            </button>
                        </form>
                        @else
                        <button disabled class="w-full bg-gray-400 text-white font-semibold py-3 px-4 rounded cursor-not-allowed">
                            Out of Stock
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-xl text-gray-500">No birthday cakes available at the moment.</p>
        </div>
        @endif
    </div>

    <!-- Shipping Banner -->
    <div class="bg-black text-white py-4 text-center mt-12">
        <p class="text-lg font-medium">FREE STANDARD SHIPPING ON $100+ ORDERS</p>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">About Us</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-pink-primary transition-colors">Our Story</a></li>
                        <li><a href="#" class="hover:text-pink-primary transition-colors">Locations</a></li>
                        <li><a href="#" class="hover:text-pink-primary transition-colors">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-pink-primary transition-colors">FAQs</a></li>
                        <li><a href="#" class="hover:text-pink-primary transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-pink-primary transition-colors">Shipping Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Shop</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-pink-primary transition-colors">All Products</a></li>
                        <li><a href="#" class="hover:text-pink-primary transition-colors">Bestsellers</a></li>
                        <li><a href="#" class="hover:text-pink-primary transition-colors">Gift Cards</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Stay Connected</h3>
                    <p class="mb-4">Subscribe to our newsletter for special offers and updates</p>
                    <form class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 w-full rounded-l-md focus:outline-none text-black">
                        <button class="bg-pink-primary hover:bg-opacity-90 px-4 py-2 rounded-r-md transition-colors">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 Bake My Day. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortSelect = document.getElementById('sortSelect');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    sortCakes(this.value);
                });
            }

            function sortCakes(sortType) {
                const cakeContainer = document.querySelector('.grid');
                const cakes = Array.from(document.querySelectorAll('.cake-item'));
                
                cakes.sort(function(a, b) {
                    const priceA = parseFloat(a.getAttribute('data-price'));
                    const priceB = parseFloat(b.getAttribute('data-price'));
                    
                    if (sortType === 'price-asc') {
                        return priceA - priceB;
                    } else if (sortType === 'price-desc') {
                        return priceB - priceA;
                    }
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