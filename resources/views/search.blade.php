@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Search Results for "{{ $query }}"</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($menus->count() > 0)
            @foreach($menus as $menu)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gray-200 overflow-hidden">
                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h2 class="font-bold text-xl mb-2">{{ $menu->name }}</h2>
                        <p class="text-gray-700 text-sm mb-2">{{ Str::limit($menu->description, 100) }}</p>
                        <p class="text-orange-500 font-bold">Rp. {{ number_format($menu->price, 0, ',', '.') }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <a href="{{ route('menus.show', $menu->id) }}" class="text-blue-500 hover:underline">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-full text-center py-8">
                <p class="text-gray-500 text-lg">No results found for "{{ $query }}"</p>
                <p class="mt-2">Try different keywords or check our popular categories below.</p>
            </div>
        @endif
    </div>
    
    <div class="mt-12">
        <h2 class="text-xl font-bold mb-6">Popular Items</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($bestSellers as $bestSeller)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-40 bg-gray-200 overflow-hidden">
                        <img src="{{ asset('storage/' . $bestSeller->image) }}" alt="{{ $bestSeller->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-1">{{ $bestSeller->name }}</h3>
                        <p class="text-orange-500 font-bold">Rp. {{ number_format($bestSeller->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection