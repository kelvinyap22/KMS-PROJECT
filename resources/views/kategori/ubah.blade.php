<html>
    <head></head>
    <body>

    @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p style="color: red;">{{ $error }}</p>
            @endforeach
        @endif
        <form method="POST" action="/update-kategori/{{ $kategori->id }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $kategori->id }}">
            <table>
                <tr>
                    <td>Nama</td>
                    <td> <input type="text" name="nama" value="{{ $kategori->nama }}"></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>
                        <textarea name="deskripsi">{{ $kategori->deskripsi }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Simpan">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>