<!-- Search Results Section -->
<div class="search-results">
    @if(isset($query) && !empty($query))
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Treats</h3>
            @if($menus->count() > 0)
                @foreach($menus as $menu)
                    <div class="flex items-center mb-4 pb-4 border-b">
                        <div class="w-20 h-20 bg-gray-100 rounded overflow-hidden mr-4">
                            @if($menu->images)
                                @php
                                    $images = json_decode($menu->images);
                                    $imagePath = is_array($images) && !empty($images) ? $images[0] : null;
                                @endphp
                                @if($imagePath)
                                    <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                                @elseif($menu->image)
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://via.placeholder.com/80?text=No+Image" alt="No image" class="w-full h-full object-cover">
                                @endif
                            @elseif($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://via.placeholder.com/80?text=No+Image" alt="No image" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <h4 class="font-semibold">{{ $menu->name }}</h4>
                            <p class="text-sm text-gray-600">from Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                            
                            @if(isset($menu->available))
                                <span class="inline-block px-2 py-1 text-xs {{ $menu->available ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }} rounded-md mb-1">
                                    {{ $menu->available ? 'Tersedia' : 'Tidak Tersedia' }}
                                </span>
                            @endif
                            
                            @php
                                $avgRating = $menu->reviews->count() > 0 ? round($menu->reviews->avg('rating'), 1) : '0.0';
                            @endphp
                            <div class="flex items-center mt-1">
                                <span class="text-yellow-500 mr-1">★</span>
                                <span class="text-xs">{{ $avgRating }}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $menu->reviews->count() }} tersedia</span>
                            </div>
                            
                            @if($menu->kategori)
                                <div class="text-xs text-gray-500 mt-1">{{ $menu->kategori }}</div>
                            @endif
                            
                            <div class="mt-2">
                                <span class="inline-block px-3 py-1 mr-2 text-xs bg-gray-200 rounded-full">6 INCH</span>
                                <span class="inline-block px-3 py-1 text-xs bg-gray-200 rounded-full">10 INCH</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500">No results found for "{{ $query }}"</p>
            @endif
        </div>
    @endif

    @if(isset($bestSellers) && $bestSellers->count() > 0)
        <div>
            <h3 class="text-lg font-semibold mb-4">Best Sellers</h3>
            @foreach($bestSellers->take(2) as $bestSeller)
                <div class="flex items-center mb-4 pb-4 border-b">
                    <div class="w-20 h-20 bg-gray-100 rounded overflow-hidden mr-4">
                        @if($bestSeller->images)
                            @php
                                $images = json_decode($bestSeller->images);
                                $imagePath = is_array($images) && !empty($images) ? $images[0] : null;
                            @endphp
                            @if($imagePath)
                                <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $bestSeller->name }}" class="w-full h-full object-cover">
                            @elseif($bestSeller->image)
                                <img src="{{ asset('storage/' . $bestSeller->image) }}" alt="{{ $bestSeller->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://via.placeholder.com/80?text=No+Image" alt="No image" class="w-full h-full object-cover">
                            @endif
                        @elseif($bestSeller->image)
                            <img src="{{ asset('storage/' . $bestSeller->image) }}" alt="{{ $bestSeller->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://via.placeholder.com/80?text=No+Image" alt="No image" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div>
                        <h4 class="font-semibold">{{ $bestSeller->name }}</h4>
                        <p class="text-sm text-gray-600">from Rp{{ number_format($bestSeller->price, 0, ',', '.') }}</p>
                        
                        @php
                            $avgRating = $bestSeller->reviews->count() > 0 ? round($bestSeller->reviews->avg('rating'), 1) : '0.0';
                        @endphp
                        <div class="flex items-center mt-1">
                            <span class="text-yellow-500 mr-1">★</span>
                            <span class="text-xs">{{ $avgRating }}</span>
                            <span class="text-xs text-gray-500 ml-2">{{ $bestSeller->reviews->count() }} tersedia</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>