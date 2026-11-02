
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="mb-4">
        <a href="{{ route('dataentry.index') }}"
           class="text-decoration-none text-secondary">
            ← Kembali ke Daftar Pertanyaan
        </a>

        <h3 class="fw-bold mt-3">Tambah Pertanyaan</h3>
        <p class="text-muted">
            Tambahkan pengetahuan baru ke dalam sistem KMS.
        </p>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="mb-4">
                <h5 class="fw-bold">Form Pengetahuan</h5>
                <p class="text-muted small">
                    Lengkapi informasi pertanyaan dan jawabannya.
                </p>
            </div>

            <form action="{{ route('dataentry.store') }}"
                  method="POST">
                @csrf

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
                                {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
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
                           placeholder="Masukkan pertanyaan..."
                           value="{{ old('pertanyaan') }}"
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
                              placeholder="Tuliskan jawaban atau pengetahuan..."
                              required>{{ old('jawaban') }}</textarea>

                    @error('jawaban')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Info Status -->
                <div class="alert alert-light border rounded-3">
                    <div class="d-flex align-items-start">
                        <span class="me-2">ℹ️</span>
                        <div>
                            <strong class="small">Status Draft</strong>
                            <p class="small text-muted mb-0">
                                Pertanyaan akan disimpan sebagai draft.
                                Anda dapat mengirimkannya ke Validator
                                setelah selesai.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dataentry.index') }}"
                       class="btn btn-light border px-4">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-primary px-4">
                        Simpan Draft
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
