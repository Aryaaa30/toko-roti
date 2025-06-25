@extends('layouts.app')

@section('content')
    <h1>Kategori: {{ $kategori }}</h1>

    @if($menus->isEmpty())
        <p>Tidak ada menu untuk kategori ini.</p>
    @else
        <ul>
            @foreach($menus as $menu)
                <li>
                    <h3>{{ $menu->name }}</h3>
                    <p>{{ $menu->description }}</p>
                    <p>Harga: {{ $menu->price }}</p>
                    <p>Stok: {{ $menu->stok }}</p>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
