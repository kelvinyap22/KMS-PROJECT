
<html>
    <head>
        <title>Ubah Pertanyaan</title>
    </head>
    <body>

        <h1>Ubah Pertanyaan</h1>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <p style="color: green;">
                {{ session('success') }}
            </p>
        @endif

        {{-- Pesan error --}}
        @if (session('error'))
            <p style="color: red;">
                {{ session('error') }}
            </p>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <p style="color: red;">
                    {{ $error }}
                </p>
            @endforeach
        @endif

        <form action="/update-pertanyaan/{{ $pertanyaan->id }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Kategori --}}
            <label for="kategori_id">Kategori:</label>
            <select name="kategori_id" id="kategori_id">
                <option value="">Pilih Kategori</option>

                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ old('kategori_id', $pertanyaan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>

            <br><br>

            {{-- Pertanyaan --}}
            <label for="pertanyaan">Pertanyaan:</label>
            <textarea name="pertanyaan" id="pertanyaan" rows="3" cols="30">{{ old('pertanyaan', $pertanyaan->pertanyaan) }}</textarea>

            <br><br>

            {{-- Jawaban --}}
            <label for="jawaban">Jawaban:</label>
            <textarea name="jawaban" id="jawaban" rows="3" cols="30">{{ old('jawaban', $pertanyaan->jawaban) }}</textarea>

            <br><br>

            {{-- Status hanya ditampilkan, tidak bisa diubah --}}
            <label>Status:</label>
            <strong>{{ ucfirst($pertanyaan->status) }}</strong>

            <br><br>

            <button type="submit">Simpan Perubahan</button>
        </form>

        <br>
        <a href="/daftar-pertanyaan">Kembali</a>

    </body>
</html>
