
<div class="container">
    <h1>Daftar Review</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($reviews->count() > 0)
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Produk</th>
                    @if(auth()->user()->is_admin)
                        <th>Nama Pengulas</th>
                    @endif
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr>
                    <td>{{ $review->menu->name ?? '-' }}</td>
                    @if(auth()->user()->is_admin)
                        <td>{{ $review->user->name ?? '-' }}</td>
                    @endif
                    <td>
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <span class="text-warning">&#9733;</span>
                            @else
                                <span class="text-secondary">&#9733;</span>
                            @endif
                        @endfor
                    </td>
                    <td>{{ $review->comment ?? '-' }}</td>
                    <td>{{ $review->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-primary btn-sm mb-1">Detail</a>

                        @if(auth()->user()->is_admin || $review->user_id == auth()->id())
                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>

                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus review ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mb-1">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada review.</p>
        <a href="{{ route('menus.index') }}" class="btn btn-primary">Lihat Produk</a>
    @endif
</div>

