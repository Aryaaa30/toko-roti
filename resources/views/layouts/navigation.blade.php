<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<nav x-data="{ open: false, showSearch: false }" class="bg-white text-black pb-4" style="height: 150px;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center h-20">
            <div class="flex items-center space-x-4">
                <button @click="open = true" class="text-2xl focus:outline-none">☰</button>
            </div>
            <div class="flex-1 flex justify-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-black">🥖 Roti</a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button @click="showSearch = !showSearch" class="focus:outline-none hidden md:inline">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/>
                        </svg>
                    </button>

                    <!-- Search Input with Pop-up -->
                    <div x-show="showSearch"
                         x-transition
                         class="fixed right-0 top-0 w-80 h-screen bg-white shadow-lg p-4 z-50 overflow-y-auto">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-semibold">Search</h2>
                            <button @click="showSearch = false" class="text-xl focus:outline-none">✖</button>
                        </div>
                        <form action="{{ route('search') }}" method="GET" class="mt-4">
                            <input type="text" name="query" placeholder="What are you looking for?"
                                class="w-full p-2 border rounded focus:outline-none focus:ring" required>
                            <button type="submit" class="mt-2 bg-black text-white px-4 py-2 rounded">Search</button>
                        </form>

                        <h3 class="mt-4 font-semibold">Trending Searches</h3>
                        <div class="flex flex-wrap">
                            @php
                                $trendingCategories = ['Roti Manis', 'Roti Tawar', 'Kue', 'Donat', 'Pastry'];
                            @endphp
                           @foreach($trendingCategories as $item)
                                <a href="{{ route('search', ['query' => $item]) }}"
                                class="bg-gray-200 hover:bg-orange-500 hover:text-white rounded-full px-3 py-1 text-sm m-1 transition">
                                    {{ $item }}
                                </a>
                            @endforeach
                        </div>

                        <h3 class="mt-4 font-semibold">Shop by Category</h3>
                        <ul>
                            <li><a href="{{ route('birthday') }}" class="block hover:text-orange-500">Birthday Gifts</a></li>
                        </ul>
                        <!-- HASIL PENCARIAN -->
                        <div class="mt-6">
                            @if(isset($menus) && $menus->count())
                                <h2 class="text-xl font-semibold mb-4">Results for "{{ request('query') }}"</h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($menus as $menu)
                                        <a href="{{ route('menus.show', $menu->id) }}"
                                           class="border rounded-lg overflow-hidden shadow hover:shadow-md transition bg-white">
                                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}"
                                                 class="w-full h-40 object-cover">
                                            <div class="p-4">
                                                <h3 class="text-lg font-semibold text-black">{{ $menu->nama }}</h3>
                                                <p class="text-sm text-gray-600">{{ Str::limit($menu->deskripsi, 60) }}</p>
                                                <p class="mt-2 font-bold text-orange-500">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @elseif(isset($menus))
                                <p class="text-gray-600 mt-4">No results found for "{{ request('query') }}".</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cart -->
                <a href="{{ route('cart') }}" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.2 6m14.4-6l-1.2 6M6 19a2 2 0 100 4 2 2 0 000-4zm12 0a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs rounded-full px-1">2</span>
                </a>

                <!-- Auth -->
               @auth
                <div x-data="{ showDropdown: false }"
                    @mouseenter="showDropdown = true"
                    @mouseleave="showDropdown = false"
                    class="relative">

                    <!-- Profile Image (Clickable to Profile) -->
                    <a href="{{ route('account.page')  }}">
                       <img class="h-8 w-8 rounded-full object-cover"
                        src="{{ Auth::user()->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                        alt="{{ Auth::user()->name }}" />
                    </a>

                    <!-- Dropdown Menu (Appears on Hover) -->
                    <div x-show="showDropdown"
                        x-transition
                        class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-2 z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <!-- Inisial GS dalam lingkaran -->
                <div class="relative">
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500 text-white font-semibold text-xs hover:bg-orange-600 transition">
                        GS
                    </a>
                </div>
                @endauth
            </div>
        </div>

        <div class="w-screen border-t border-gray-300 my-6 mx-0"></div>

        <div class="hidden md:flex justify-center space-x-6">
            <a href="{{ url('/menus') }}" class="text-black hover:text-orange-500 font-medium transition">Bakeries</a>
            <a href="{{ route('birthday') }}" class="text-black hover:text-orange-500 font-medium transition">Birthday</a>
            <a href="{{ route('about') }}" class="text-black hover:text-orange-500 font-medium transition">About Us</a>
        </div>
    </div>

    <!-- MOBILE SIDE DRAWER -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-0 z-50 flex">
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="open = false"></div>

        <div class="relative bg-white w-72 max-w-full h-screen overflow-y-auto shadow-lg p-6">
            <button @click="open = false" class="absolute top-4 right-4 text-2xl font-bold text-gray-700">×</button>
            <nav class="mt-10 space-y-4 font-semibold text-black">
                <a href="{{ url('/') }}" class="block hover:text-orange-500">Dashboard</a>
                <a href="{{ url('/menus') }}" class="text-black hover:text-orange-500 font-medium transition">Bakeries</a>
                <a href="{{ route('birthday') }}" class="block hover:text-orange-500">Birthday</a>
                <a href="{{ route('about') }}" class="block hover:text-orange-500">About Us</a>
                <hr class="border-t my-4">
                <a href="#contact-us" class="block text-pink-600 hover:underline">Contact Us</a>
            </nav>
        </div>
    </div>
</nav>
