
<html>
    <head>
        <title>Ubah Pertanyaan</title>
    </head>
    <body>

        <h1>Ubah Pertanyaan</h1>

        {{-- Pesan Error jika ada --}}
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

                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}"
                        {{ old('kategori_id', $pertanyaan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>

            <br><br>

            {{-- Pertanyaan --}}
            <label for="pertanyaan">Pertanyaan:</label>
            <textarea name="pertanyaan" id="pertanyaan">{{ old('pertanyaan', $pertanyaan->pertanyaan) }}</textarea>

            <br><br>

            {{-- Jawaban --}}
            <label for="jawaban">Jawaban:</label>
            <textarea name="jawaban" id="jawaban">{{ old('jawaban', $pertanyaan->jawaban) }}</textarea>

            <br><br>

            {{-- Status --}}
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="">Pilih Status</option>

                <option value="draft"
                    {{ old('status', $pertanyaan->status) == 'draft' ? 'selected' : '' }}>
                    Draft
                </option>

                <option value="pending"
                    {{ old('status', $pertanyaan->status) == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="published"
                    {{ old('status', $pertanyaan->status) == 'published' ? 'selected' : '' }}>
                    Published
                </option>

                <option value="rejected"
                    {{ old('status', $pertanyaan->status) == 'rejected' ? 'selected' : '' }}>
                    Rejected
                </option>
            </select>

            <br><br>

            <button type="submit">Simpan Perubahan</button>
        </form>

    </body>
</html>
