<html>
    <head></head>
    <body>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p style="color: red;">{{ $error }}</p>
            @endforeach
        @endif
        <form method="POST" action="/simpan-kategori">
            @csrf
            <table>
                <tr>
                    <td>Nama</td>
                    <td> <input type="text" name="nama"></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>
                        <textarea name="deskripsi"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colespan="2">
                        <input type="submit" value="Simpan">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>