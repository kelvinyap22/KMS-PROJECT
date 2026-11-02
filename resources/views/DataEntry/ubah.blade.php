
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="mb-4">
        <a href="{{ route('dataentry.index') }}"
           class="text-decoration-none text-secondary">
            ← Kembali ke Daftar Pertanyaan
        </a>

        <h3 class="fw-bold mt-3">Ubah Pertanyaan</h3>
        <p class="text-muted">
            Perbarui informasi pertanyaan dan jawabannya.
        </p>
    </div>

    <!-- Form -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="mb-4">
                <h5 class="fw-bold">Form Pengetahuan</h5>
                <p class="text-muted small">
                    Edit informasi pengetahuan yang sudah tersimpan.
                </p>
            </div>

            <form action="{{ route('dataentry.update', $pertanyaan->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <!-- Kategori -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Kategori
                    </label>

                    <select name="kategori_id"
                            class="form-select @error('kategori_id') is-invalid @enderror"
                            required>

                        <option value="">Pilih kategori</option>

                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_id', $pertanyaan->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach

                    </select>

                    @error('kategori_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pertanyaan -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Pertanyaan
                    </label>

                    <input type="text"
                           name="pertanyaan"
                           class="form-control @error('pertanyaan') is-invalid @enderror"
                           value="{{ old('pertanyaan', $pertanyaan->pertanyaan) }}"
                           placeholder="Masukkan pertanyaan..."
                           required>

                    @error('pertanyaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jawaban -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Jawaban
                    </label>

                    <textarea name="jawaban"
                              rows="6"
                              class="form-control @error('jawaban') is-invalid @enderror"
                              placeholder="Tuliskan jawaban..."
                              required>{{ old('jawaban', $pertanyaan->jawaban) }}</textarea>

                    @error('jawaban')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Informasi -->
                <div class="alert alert-light border rounded-3">
                    <strong class="small">Status Saat Ini</strong>
                    <p class="mb-0 small text-muted">
                        {{ ucfirst($pertanyaan->status) }}
                    </p>
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a href="{{ route('dataentry.index') }}"
                       class="btn btn-light border px-4">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-primary px-4">
                        Simpan Perubahan
                    </button>

                </div>

            </form>
        </div>
    </div>

</div>
@endsection
