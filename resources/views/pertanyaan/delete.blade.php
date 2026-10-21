<html>
    <head>
        <title>Hapus Pertanyaan</title>
    </head>
    <body>

        <h1>Hapus Pertanyaan</h1>

        <p>Apakah Anda yakin ingin menghapus pertanyaan ini?</p>

        <form action="/hapus-pertanyaan/{{ $pertanyaan->id }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit">Ya, Hapus</button>
            <a href="/daftar-pertanyaan">Batal</a>
        </form>

    </body>
</html>