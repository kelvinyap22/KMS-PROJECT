<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Role;
use App\Models\SaranPertanyaan;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    private function checkSuperAdmin()
    {
        abort_unless(
            auth()->check() && auth()->user()->role_id == 3,
            403,
            'Anda tidak memiliki akses ke halaman Super Admin.'
        );
    }

    public function index(Request $request)
    {
        $this->checkSuperAdmin();

        // Query Pertanyaan: KECUALIKAN status 'draft' & eager load relasi
        $queryPertanyaan = Pertanyaan::with(['kategori', 'creator', 'reviewer'])
            ->where('status', '!=', 'draft');

        if ($request->filled('search')) {
            $queryPertanyaan->where('pertanyaan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $queryPertanyaan->where('kategori_id', $request->kategori);
        }

        if ($request->filled('status') && $request->status !== 'draft') {
            $queryPertanyaan->where('status', $request->status);
        }

        $pertanyaans = $queryPertanyaan->latest()->paginate(10, ['*'], 'faq_page')->withQueryString();

        // Data statistik (tanpa draft)
        $totalPertanyaan = Pertanyaan::where('status', '!=', 'draft')->count();
        $totalPending    = Pertanyaan::where('status', 'pending')->count();
        $totalPublished  = Pertanyaan::where('status', 'published')->count();
        $totalUser       = User::count();

        // Data pendukung
        $kategoris        = Kategori::withCount('pertanyaans')->get();
        $users            = User::with('role')->latest()->paginate(10, ['*'], 'user_page');
        $roles            = Role::all();
        $saranPertanyaans = SaranPertanyaan::with(['mahasiswa', 'petugas'])->latest()->paginate(10, ['*'], 'saran_page');
        $staffUsers       = User::whereIn('role_id', [1, 2, 3])->get();

        return view('SuperAdmin.index', compact(
            'pertanyaans',
            'kategoris',
            'users',
            'roles',
            'saranPertanyaans',
            'staffUsers',
            'totalPertanyaan',
            'totalPending',
            'totalPublished',
            'totalUser'
        ));
    }

    // CRUD USER
    public function storeUser(Request $request)
    {
        $this->checkSuperAdmin();
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
        ]);

        return back()->with('success', 'User staff baru berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $this->checkSuperAdmin();
        $user = User::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'role_id' => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return back()->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroyUser($id)
    {
        $this->checkSuperAdmin();
        if (auth()->id() == $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // CRUD KATEGORI
    public function storeKategori(Request $request)
    {
        $this->checkSuperAdmin();
        $request->validate([
            'nama'      => 'required|string|max:100|unique:kategoris,nama',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        Kategori::create([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, $id)
    {
        $this->checkSuperAdmin();
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama'      => 'required|string|max:100|unique:kategoris,nama,' . $id,
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $kategori->update([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyKategori($id)
    {
        $this->checkSuperAdmin();
        Kategori::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // CRUD PERTANYAAN FAQ
    public function updatePertanyaan(Request $request, $id)
    {
        $this->checkSuperAdmin();
        $pertanyaan = Pertanyaan::findOrFail($id);

        $request->validate([
            'kategori_id'    => 'required|exists:kategoris,id',
            'pertanyaan'     => 'required|string',
            'jawaban'        => 'required|string',
            'status'         => 'required|in:pending,published,rejected',
            'catatan_review' => 'required_if:status,rejected|nullable|string|max:1000',
        ], [
            'catatan_review.required_if' => 'Catatan penolakan wajib diisi jika status diubah menjadi Rejected.',
        ]);

        $dataToUpdate = [
            'kategori_id' => $request->kategori_id,
            'pertanyaan'  => $request->pertanyaan,
            'jawaban'     => $request->jawaban,
            'status'      => $request->status,
        ];

        // Otomatis catat ID Super Admin & Waktu Verifikasi saat Published/Rejected
        if (in_array($request->status, ['published', 'rejected'])) {
            $dataToUpdate['reviewed_by'] = auth()->id();
            $dataToUpdate['reviewed_at'] = now();
        }

        // Kelola Catatan Penolakan
        if ($request->status === 'rejected') {
            $dataToUpdate['catatan_review'] = $request->catatan_review;
        } elseif ($request->status === 'published') {
            $dataToUpdate['catatan_review'] = null; // Reset catatan jika disetujui
        }

        $pertanyaan->update($dataToUpdate);

        return back()->with('success', 'Pertanyaan FAQ berhasil diperbarui.');
    }

    public function destroyPertanyaan($id)
    {
        $this->checkSuperAdmin();
        Pertanyaan::findOrFail($id)->delete();
        return back()->with('success', 'Pertanyaan FAQ berhasil dihapus.');
    }

    // UPDATE SARAN MAHASISWA
    public function updateSaran(Request $request, $id)
    {
        $this->checkSuperAdmin();
        $saran = SaranPertanyaan::findOrFail($id);

        $request->validate([
            'status'         => 'required|in:baru,diproses,selesai,ditolak',
            'ditangani_oleh' => 'nullable|exists:users,id',
        ]);

        $saran->update([
            'status'         => $request->status,
            'ditangani_oleh' => $request->ditangani_oleh,
        ]);

        return back()->with('success', 'Status saran pertanyaan berhasil diperbarui.');
    }
}