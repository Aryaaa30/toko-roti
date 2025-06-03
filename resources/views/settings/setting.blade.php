
<div class="container">
    <h1>Daftar Pengaturan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('settings.create') }}" class="btn btn-primary mb-3">Tambah Pengaturan Baru</a>

    @if($settings->count() > 0)
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($settings as $setting)
                <tr>
                    <td>{{ $setting->key }}</td>
                    <td>{{ $setting->value }}</td>
                    <td>
                        <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>

                        <form action="{{ route('settings.destroy', $setting->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus pengaturan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mb-1">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada pengaturan.</p>
    @endif
</div>

