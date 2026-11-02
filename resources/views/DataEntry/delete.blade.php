
<form action="{{ route('dataentry.destroy', $pertanyaan->id) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')">

    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-sm btn-danger">
        <i class="bi bi-trash"></i> Hapus
    </button>

</form>
