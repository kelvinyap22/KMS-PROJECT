
<html>
    <head>
        <title>Tambah Pertanyaan</title>
    </head>
    <body>

        <h1>Tambah Pertanyaan Baru</h1>

        {{-- Pesan Error Validasi Laravel --}}
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p style="color: red;">{{ $error }}</p>
            @endforeach
        @endif

        <form method="POST" action="{{ url('/simpan-pertanyaan') }}">
            @csrf

            <label for="kategori_id">Kategori:</label>
            <br>
            <select name="kategori_id" id="kategori_id">
                <option value="">Pilih Kategori</option>

                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>

            <br><br>

            <label for="pertanyaan">Pertanyaan:</label>
            <br>
            <textarea name="pertanyaan" id="pertanyaan"
                rows="4" cols="50">{{ old('pertanyaan') }}</textarea>

            <br><br>

            <label for="jawaban">Jawaban:</label>
            <br>
            <textarea name="jawaban" id="jawaban"
                rows="4" cols="50">{{ old('jawaban') }}</textarea>

            <br><br>

            <button type="submit">Simpan Draft</button>
        </form>

        <br>
        <a href="/daftar-pertanyaan">Kembali</a>

    </body>
</html>
