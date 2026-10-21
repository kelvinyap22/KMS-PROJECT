
<html>
    <head>
        <title>Tambah Pertanyaan</title>
    </head>
    <body>

        <h1>Tambah Pertanyaan Baru</h1>

        {{-- Pesan Error Validasi Laravel --}}
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p style="color: red;">
                    {{ $error }}
                </p>
            @endforeach
        @endif

        <form method="POST" action="{{ url('/simpan-pertanyaan') }}">
            @csrf

            {{-- Kategori --}}
            <label for="kategori_id">Kategori:</label>
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

            {{-- Pertanyaan --}}
            <label for="pertanyaan">Pertanyaan:</label>
            <br>
            <textarea name="pertanyaan" id="pertanyaan" rows="4" cols="50">{{ old('pertanyaan') }}</textarea>

            <br><br>

            {{-- Jawaban --}}
            <label for="jawaban">Jawaban:</label>
            <br>
            <textarea name="jawaban" id="jawaban" rows="4" cols="50">{{ old('jawaban') }}</textarea>

            <br><br>

            {{-- Status --}}
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="">Pilih Status</option>

                <option value="draft"
                    {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>
                    Draft
                </option>

                <option value="pending"
                    {{ old('status') == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="published"
                    {{ old('status') == 'published' ? 'selected' : '' }}>
                    Published
                </option>

                <option value="rejected"
                    {{ old('status') == 'rejected' ? 'selected' : '' }}>
                    Rejected
                </option>
            </select>

            <br><br>

            <button type="submit">Simpan</button>
        </form>

        <br>
        <a href="/daftar-pertanyaan">Kembali</a>

    </body>
</html>
