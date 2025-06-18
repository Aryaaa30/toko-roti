<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Navbar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pink-primary': 'rgb(254, 198, 228) ',
                        'pink-light': 'rgb(254, 198, 228) ',
                    }
                }
            }
        }
    </script>
</head>
<body class="">

<nav x-data="{ 
        showSearch: false, 
        searchQuery: '', 
        searchResults: [], 
        searchLoading: false,
        bestSellers: {{ json_encode($bestSellers ?? []) }},
        cartCount: {{ $cartCount ?? 0 }}, 
        showProfile: false,
        
        async search() {
            if (this.searchQuery.length < 2) {
                this.searchResults = [];
                return;
            }
            
            this.searchLoading = true;
            try {
                const response = await fetch(`{{ route('search.api') }}?query=${encodeURIComponent(this.searchQuery)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                this.searchResults = data.results;
            } catch (error) {
                console.error('Search error:', error);
                this.searchResults = [];
            } finally {
                this.searchLoading = false;
            }
        },
        
        submitSearch() {
            if (this.searchQuery.length > 0) {
                window.location.href = `{{ route('search') }}?query=${encodeURIComponent(this.searchQuery)}`;
            }
        }
    }"
    @keydown.escape="showSearch = false"
    class="bg-black text-white shadow-lg fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="text-xl font-medium text-pink-primary transition-colors duration-200">
                    Bake My Day
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="/bakeries" class="text-white hover:text-pink-primary font-medium transition-colors duration-200">Bakeries</a>
                @if(auth()->check() && auth()->user()->is_admin)
                    <a href="{{ route('birthday.admin') }}" class="text-white hover:text-pink-primary font-medium transition-colors duration-200">Birthday</a>
                @else
                    <a href="{{ route('birthday.user') }}" class="text-white hover:text-pink-primary font-medium transition-colors duration-200">Birthday</a>
                @endif
                <a href="/about" class="text-white hover:text-pink-primary font-medium transition-colors duration-200">About Us</a>
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-4">
                
                <!-- Search Button -->
                <button @click="showSearch = !showSearch" 
                        class="p-2 hover:bg-pink-primary rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                    </svg>
                </button>

                <!-- Cart -->
                <a href="/cart" class="relative p-2 hover:bg-pink-primary rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6m14.4-6l-1.2 6M6 19a2 2 0 100 4 2 2 0 000-4zm12 0a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    <span x-show="cartCount > 0" 
                          x-text="cartCount"
                          class="absolute -top-1 -right-1 bg-pink-primary text-white text-xs rounded-full px-1.5 py-0.5 min-w-[18px] h-[18px] flex items-center justify-center font-semibold">
                    </span>
                </a>

                <!-- Profile -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="w-8 h-8 bg-pink-primary rounded-full flex items-center justify-center text-white font-semibold text-sm hover:bg-opacity-80 transition-all duration-200">
                        U
                    </button>
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"  
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 border">
                        <a href="{{ route('account.page') }}" class="block px-4 py-2 text-sm text-black hover:bg-pink-light transition-colors">Profile</a>
                        <a href="/orders" class="block px-4 py-2 text-sm text-black hover:bg-pink-light transition-colors">Orders</a>
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-black hover:bg-pink-light transition-colors">Logout</button>
                        </form>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 hover:bg-pink-primary rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
            </div>

    <!-- Search Overlay -->
    <div x-show="showSearch"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-40"
         @click="showSearch = false">
    </div>

    <!-- Search Panel -->
    <div x-show="showSearch"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform translate-x-full"
         x-transition:enter-end="transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="transform translate-x-0"
         x-transition:leave-end="transform translate-x-full"
         @keydown.enter="submitSearch()"
         class="fixed right-0 top-0 w-96 h-full bg-white shadow-2xl z-50 overflow-y-auto">
        <!-- Search Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-black">Search</h2>
            <button @click="showSearch = false" 
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-500 hover:text-black transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                </button>
            </div>

        <!-- Search Input -->
        <div class="p-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
                <input type="text"
                       x-model="searchQuery"
                       @input="search()"
                       placeholder="What are you looking for?"
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-pink-primary focus:border-transparent outline-none transition-all text-black placeholder-gray-500">
                <button x-show="searchQuery.length > 0" 
                        @click="searchQuery = ''; searchResults = []"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
        </div>
                            </div>

        <!-- Trending Searches -->
        <div class="px-6 mb-6" x-show="!searchQuery">
            <h3 class="font-semibold text-black mb-4">Trending</h3>
            <div class="flex flex-wrap gap-2">
                <button @click="searchQuery = 'Roti Manis'; search()" 
                        class="px-4 py-2 bg-black text-white rounded-full text-sm hover:bg-pink-primary transition-colors">
                    Roti Manis
                    </button>
                <button @click="searchQuery = 'Roti Tawar'; search()"
                        class="px-4 py-2 bg-black text-white rounded-full text-sm hover:bg-pink-primary transition-colors">
                    Roti Tawar  
                </button>
                <button @click="searchQuery = 'Kue'; search()" 
                        class="px-4 py-2 bg-black text-white rounded-full text-sm hover:bg-pink-primary transition-colors">
                    Kue
                </button>
                <button @click="searchQuery = 'Donat'; search()" 
                        class="px-4 py-2 bg-black text-white rounded-full text-sm hover:bg-pink-primary transition-colors">
                    Donat
                </button>
                <button @click="searchQuery = 'Pastry'; search()" 
                        class="px-4 py-2 bg-black text-white rounded-full text-sm hover:bg-pink-primary transition-colors">
                    Pastry
                </button>
        </div>
    </div>

        <!-- Best Sellers -->
        <div class="px-6" x-show="!searchQuery">
            <h3 class="font-semibold text-black mb-4">Best Sellers</h3>
            <div class="space-y-4">
                @foreach($bestSellers ?? [] as $bestSeller)
                    <a href="{{ route('menus.show', $bestSeller->id) }}" class="flex items-center p-3 rounded-lg hover:bg-pink-light transition-colors cursor-pointer">
                        <div class="w-16 h-16 bg-gray-200 rounded-lg mr-4 flex-shrink-0 overflow-hidden">
                            @php
                                $image = null;
                                if ($bestSeller->images) {
                                    $images = json_decode($bestSeller->images);
                                    if (is_array($images) && count($images) > 0) {
                                        $image = $images[0];
                                    }
                                } elseif ($bestSeller->image) {
                                    $image = $bestSeller->image;
                                }
                            @endphp
                            @if($image)
                                <img src="{{ asset('storage/'.$image) }}" alt="{{ $bestSeller->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <h4 class="font-medium text-black">{{ $bestSeller->name }}</h4>
                            <p class="text-sm text-gray-600">Rp {{ number_format($bestSeller->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Search Results -->
        <div class="px-6" x-show="searchQuery">
            <!-- Loading indicator -->
            <div x-show="searchLoading" class="flex justify-center py-4">
                <svg class="animate-spin h-6 w-6 text-pink-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            
            <div x-show="!searchLoading">
                <div class="text-sm text-gray-500 mb-4">
                    Searching for "<span x-text="searchQuery" class="font-medium"></span>"
                </div>
                
                <div x-show="searchResults.length === 0 && searchQuery.length >= 2" class="py-4 text-center text-gray-500">
                    No results found for "<span x-text="searchQuery" class="font-medium"></span>"
                </div>
                
                <!-- Search results list -->
                <div class="space-y-4">
                    <template x-for="result in searchResults" :key="result.id">
                        <a :href="result.url" class="flex items-center p-3 rounded-lg hover:bg-pink-light transition-colors cursor-pointer">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg mr-4 flex-shrink-0 overflow-hidden">
                                <img x-show="result.image" :src="result.image" :alt="result.name" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-medium text-black" x-text="result.name"></h4>
                                <p class="text-sm text-gray-600" x-text="result.formatted_price"></p>
                                <p class="text-xs text-gray-500" x-text="result.category"></p>
                            </div>
                        </a>
                    </template>
                </div>
                
                <!-- Show all results button -->
                <div x-show="searchResults.length > 0" class="mt-4 text-center">
                    <button @click="submitSearch()" class="px-4 py-2 bg-pink-primary text-white rounded-lg text-sm hover:bg-opacity-90 transition-colors">
                        View all results
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Spacer for fixed navbar -->
<div class="h-16"></div>

</body>
</html>