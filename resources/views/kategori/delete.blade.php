<html>
<head>
    <title>Hapus Kategori</title>
</head>

<body>

<h1>Hapus Kategori </h1>

<p>
    Apakah kamu yakin ingin menghapus kategori:
    <strong>{{ $kategori->nama }}</strong>?
</p>

<form action="/hapus-kategori/{{ $kategori ->id }}" method="POST">

    @csrf
    @method('DELETE')

    <button type="submit">Ya, Hapus</button>

</form>

<a href="/daftar-kategori">Batal</a>

</body>
</html>