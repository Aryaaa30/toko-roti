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

    <!-- Featured Products -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Featured Birthday Treats</h2>
            <div class="flex items-center">
                <span class="text-gray-500 mr-2">Filter:</span>
                <select class="border border-gray-300 rounded-md py-1 px-3 focus:outline-none focus:ring-2 focus:ring-pink-primary">
                    <option>Featured</option>
                    <option>Best Selling</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                </select>
            </div>
        </div>

        <!-- First Row of Products -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Product 1 -->
            <div class="bg-[#FFF6EA] rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img src="{{ asset('images/birthday.jpg') }}" alt="Birthday Truffle Gift Pack" 
                         class="w-full h-64 object-cover">
                    <div class="absolute top-3 left-3 bg-black text-white text-xs px-2 py-1 rounded">BEST SELLER</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">BIRTHDAY TRUFFLE GIFT PACK</h3>
                    <p class="text-gray-600 mb-4">We rolled all the childhood flavor of our signature cake into these rainbow-flecked, vanilla happy bites...</p>
                    <div class="flex justify-center">
                        <button class="w-full bg-black hover:bg-pink-primary text-white font-semibold py-3 px-4 rounded transition duration-200">
                            Add to Cart - $43
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="bg-[#FFF6EA] rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img src="{{ asset('images/birthday.jpg') }}" alt="The Big B'Day Gift" 
                         class="w-full h-64 object-cover">
                    <div class="absolute top-3 left-3 bg-black text-white text-xs px-2 py-1 rounded">BUNDLE & SAVE</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">THE BIG B'DAY GIFT</h3>
                    <p class="text-gray-600 mb-4">A birthday flavored no-brainer that brings together all the heavy hitters for an all-out celebration. This...</p>
                    <div class="flex justify-center">
                        <button class="w-full bg-black hover:bg-pink-primary text-white font-semibold py-3 px-4 rounded transition duration-200">
                            Add to Cart - $93
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="bg-[#FFF6EA] rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img src="{{ asset('images/birthday.jpg') }}" alt="Birthday Bites & Pie" 
                         class="w-full h-64 object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">BIRTHDAY BITES & PIE</h3>
                    <p class="text-gray-600 mb-4">Say happy birthday with the Birthday Sampler Box! Indulge in a variety of Bake My Day's...</p>
                    <div class="flex justify-center">
                        <button class="w-full bg-black hover:bg-pink-primary text-white font-semibold py-3 px-4 rounded transition duration-200">
                            Add to Cart - $63
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row of Products -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Product 4 -->
            <div class="bg-[#FFF6EA] rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img src="{{ asset('images/birthday.jpg') }}" alt="Birthday Cake" 
                         class="w-full h-64 object-cover">
                    <div class="absolute top-3 left-3 bg-pink-primary text-white text-xs px-2 py-1 rounded">BEST SELLER</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">BIRTHDAY CAKE</h3>
                    <p class="text-gray-600 mb-4">You've never tried a birthday cake like this. Our bestselling Birthday Cake, inspired by the...</p>
                    <div class="flex justify-center">
                        <button class="w-full bg-black hover:bg-pink-primary text-white font-semibold py-3 px-4 rounded transition duration-200">
                            Add to Cart - $62
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 5 -->
            <div class="bg-[#FFF6EA] rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img src="{{ asset('images/birthday.jpg') }}" alt="Strawberry Shortcake" 
                         class="w-full h-64 object-cover">
                    <div class="absolute top-3 left-3 bg-pink-primary text-white text-xs px-2 py-1 rounded">LIMITED TIME</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">STRAWBERRY SHORTCAKE CAKE</h3>
                    <p class="text-gray-600 mb-4">Strawberry Shortcake but on a whole new level: vanilla cake layered with silky sweet cream...</p>
                    <div class="flex justify-center">
                        <button class="w-full bg-black hover:bg-pink-primary text-white font-semibold py-3 px-4 rounded transition duration-200">
                            Add to Cart - $95
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 6 -->
            <div class="bg-[#FFF6EA] rounded-lg overflow-hidden shadow-md">
                <div class="relative">
                    <img src="{{ asset('images/birthday.jpg') }}" alt="Gluten-Free Birthday Cake" 
                         class="w-full h-64 object-cover">
                    <div class="absolute top-3 left-3 bg-pink-primary text-white text-xs px-2 py-1 rounded">GLUTEN-FREE</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">GLUTEN-FREE BIRTHDAY CAKE</h3>
                    <p class="text-gray-600 mb-4">Three tiers of rainbow-flecked, gluten-free vanilla B'Day cake layered with...</p>
                    <div class="flex justify-center">
                        <button class="w-full bg-black hover:bg-pink-primary text-white font-semibold py-3 px-4 rounded transition duration-200">
                            Add to Cart - $78
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
</body>
</html>