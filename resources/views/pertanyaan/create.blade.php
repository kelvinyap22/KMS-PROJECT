<html>
    <head>
        <title>Tambah Pertanyaan</title>
    </head>
    <body>
        <h2>Tambah Pertanyaan Baru</h2>

        {{-- Menampilkan error validasi jika ada --}}
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p style="color: red;">{{ $error }}</p>
            @endforeach
        @endif

        <form method="POST" action="{{ url('/simpan-pertanyaan') }}">
            @csrf

            <label>Kategori</label>
            <br>
            <select name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
            <br><br>

            <label>Pertanyaan</label>
            <br>
            <textarea name="pertanyaan" rows="4" cols="50" required></textarea>
            <br><br>

            <label>Jawaban</label>
            <br>
            <textarea name="jawaban" rows="4" cols="50" required></textarea>
            <br><br>

            <label>Status</label>
            <br>
            <select name="status">
                <option value="draft">Draft</option>
                <option value="pending">Pending</option>
                <option value="published">Published</option>
                <option value="rejected">Rejected</option>
            </select>
            <br><br>

            <button type="submit">Simpan</button>

        </form>

        <br>
        <a href="/daftar-pertanyaan">Kembali</a>

    </body>
</html>