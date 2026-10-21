<h1>Daftar Kategori</h1>

@if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

<a href="/tambah-kategori">
    Tambah Kategori
</a>

<table border="1">

    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>

    @foreach($kategoris as $kategori)

    <tr>
        <td>{{ $kategori->id }}</td>
        <td>{{ $kategori->nama }}</td>
        <td>{{ $kategori->deskripsi }}</td>
        <td>
            <a href="/ubah-kategori/{{ $kategori->id }}">
                Edit
            </a>

            <form action="/hapus-kategori/{{ $kategori->id }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                    Hapus
                </button>
            </form>
    </tr>

    @endforeach

</table>