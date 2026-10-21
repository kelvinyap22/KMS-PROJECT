<html>
    <head>
        <title>Daftar Pertanyaan</title>
    </head>
    <body>

        <h1>Daftar Pertanyaan</h1>

        {{-- Pesan Sukses jika ada --}}
        @if(session('success'))
            <p style="color: green;">
                {{ session('success') }}
            </p>
        @endif

        <a href="/tambah-pertanyaan">
            Tambah Pertanyaan
        </a>

        <br><br>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Kategori</th>
                <th>Pertanyaan</th>
                <th>Jawaban</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            @foreach($pertanyaans as $pertanyaan)
            <tr>
                <td>{{ $pertanyaan->id }}</td>
                <td>{{ $pertanyaan->nama_kategori }}</td>
                <td>{{ $pertanyaan->pertanyaan }}</td>
                <td>{{ $pertanyaan->jawaban }}</td>
                <td>{{ $pertanyaan->status }}</td>
                <td>
                    <a href="/ubah-pertanyaan/{{ $pertanyaan->id }}">
                        Edit
                    </a>

                    <form action="/hapus-pertanyaan/{{ $pertanyaan->id }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach

        </table>

    </body>
</html>