<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller Inventaris.
 * Mengelola CRUD data inventaris barang DFC Cirebon berbasis Session (tanpa database).
 */
class InventarisController extends Controller
{
    private const SESSION_KEY = 'inventaris_dfc';

    /**
     * Menampilkan daftar seluruh data inventaris dari session.
     */
    public function index(Request $request): View
    {
        $daftarInventaris = $this->ambilSemuaInventaris($request);

        return view('inventaris.index', [
            'judul' => 'Daftar Inventaris - DFC Cirebon',
            'inventaris' => $daftarInventaris,
        ]);
    }

    /**
     * Menampilkan form tambah data inventaris baru.
     */
    public function create(): View
    {
        return view('inventaris.create', [
            'judul' => 'Tambah Inventaris - DFC Cirebon',
            'daftarKategori' => $this->opsiKategori(),
            'daftarLokasi' => $this->opsiLokasi(),
            'daftarKondisi' => $this->opsiKondisi(),
        ]);
    }

    /**
     * Memvalidasi input form, membentuk data inventaris, dan menyimpannya ke session.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validasiInput($request, wajibKode: true);
        $kode = strtoupper(trim($data['kode']));

        $daftarInventaris = $this->ambilSemuaInventaris($request);

        if (isset($daftarInventaris[$kode])) {
            return back()
                ->withInput()
                ->with('gagal', "Kode inventaris '{$kode}' sudah terdaftar. Gunakan kode lain.");
        }

        $waktuSekarang = now()->format('d/m/Y H:i');

        $daftarInventaris[$kode] = [
            'kode' => $kode,
            'nama' => trim($data['nama']),
            'kategori' => $data['kategori'],
            'lokasi' => $data['lokasi'],
            'jumlah' => (int) $data['jumlah'],
            'kondisi' => $data['kondisi'],
            'keterangan' => trim((string) ($data['keterangan'] ?? '')),
            'dibuat_pada' => $waktuSekarang,
            'diperbarui_pada' => $waktuSekarang,
        ];

        $this->simpanSemuaInventaris($request, $daftarInventaris);

        return redirect()
            ->route('inventaris.index')
            ->with('sukses', "Data inventaris '{$daftarInventaris[$kode]['nama']}' ({$kode}) berhasil ditambahkan.");
    }

    /**
     * Menampilkan detail satu item inventaris berdasarkan parameter $kode.
     */
    public function show(Request $request, string $kode): View|RedirectResponse
    {
        $item = $this->cariInventaris($request, $kode);

        if ($item === null) {
            return redirect()
                ->route('inventaris.index')
                ->with('gagal', "Data inventaris dengan kode '{$kode}' tidak ditemukan.");
        }

        return view('inventaris.show', [
            'judul' => "Detail Inventaris {$item['kode']} - DFC Cirebon",
            'item' => $item,
        ]);
    }

    /**
     * Menampilkan form edit dengan data lama berdasarkan parameter $kode.
     */
    public function edit(Request $request, string $kode): View|RedirectResponse
    {
        $item = $this->cariInventaris($request, $kode);

        if ($item === null) {
            return redirect()
                ->route('inventaris.index')
                ->with('gagal', "Data inventaris dengan kode '{$kode}' tidak ditemukan.");
        }

        return view('inventaris.edit', [
            'judul' => "Edit Inventaris {$item['kode']} - DFC Cirebon",
            'item' => $item,
            'daftarKategori' => $this->opsiKategori(),
            'daftarLokasi' => $this->opsiLokasi(),
            'daftarKondisi' => $this->opsiKondisi(),
        ]);
    }

    /**
     * Memperbarui data inventaris pada session berdasarkan parameter $kode.
     */
    public function update(Request $request, string $kode): RedirectResponse
    {
        $kodeNormal = strtoupper(trim($kode));
        $daftarInventaris = $this->ambilSemuaInventaris($request);

        if (! isset($daftarInventaris[$kodeNormal])) {
            return redirect()
                ->route('inventaris.index')
                ->with('gagal', "Data inventaris dengan kode '{$kode}' tidak ditemukan.");
        }

        $data = $this->validasiInput($request, wajibKode: false);
        $dataLama = $daftarInventaris[$kodeNormal];

        $daftarInventaris[$kodeNormal] = [
            'kode' => $kodeNormal,
            'nama' => trim($data['nama']),
            'kategori' => $data['kategori'],
            'lokasi' => $data['lokasi'],
            'jumlah' => (int) $data['jumlah'],
            'kondisi' => $data['kondisi'],
            'keterangan' => trim((string) ($data['keterangan'] ?? '')),
            'dibuat_pada' => $dataLama['dibuat_pada'] ?? now()->format('d/m/Y H:i'),
            'diperbarui_pada' => now()->format('d/m/Y H:i'),
        ];

        $this->simpanSemuaInventaris($request, $daftarInventaris);

        return redirect()
            ->route('inventaris.index')
            ->with('sukses', "Data inventaris '{$daftarInventaris[$kodeNormal]['nama']}' ({$kodeNormal}) berhasil diperbarui.");
    }

    /**
     * Menghapus data inventaris dari session berdasarkan parameter $kode.
     */
    public function destroy(Request $request, string $kode): RedirectResponse
    {
        $kodeNormal = strtoupper(trim($kode));
        $daftarInventaris = $this->ambilSemuaInventaris($request);

        if (! isset($daftarInventaris[$kodeNormal])) {
            return redirect()
                ->route('inventaris.index')
                ->with('gagal', "Data inventaris dengan kode '{$kode}' tidak ditemukan.");
        }

        $namaBarang = $daftarInventaris[$kodeNormal]['nama'];
        unset($daftarInventaris[$kodeNormal]);

        $this->simpanSemuaInventaris($request, $daftarInventaris);

        return redirect()
            ->route('inventaris.index')
            ->with('sukses', "Data inventaris '{$namaBarang}' ({$kodeNormal}) berhasil dihapus.");
    }

    /**
     * Mengambil seluruh data inventaris dari session.
     *
     * @return array<string, array<string, mixed>>
     */
    private function ambilSemuaInventaris(Request $request): array
    {
        $data = $request->session()->get(self::SESSION_KEY, []);

        return is_array($data) ? $data : [];
    }

    /**
     * Menyimpan seluruh data inventaris ke dalam session.
     *
     * @param  array<string, array<string, mixed>>  $daftarInventaris
     */
    private function simpanSemuaInventaris(Request $request, array $daftarInventaris): void
    {
        $request->session()->put(self::SESSION_KEY, $daftarInventaris);
    }

    /**
     * Mencari satu item inventaris berdasarkan kode.
     *
     * @return array<string, mixed>|null
     */
    private function cariInventaris(Request $request, string $kode): ?array
    {
        $kodeNormal = strtoupper(trim($kode));
        $daftarInventaris = $this->ambilSemuaInventaris($request);

        return $daftarInventaris[$kodeNormal] ?? null;
    }

    /**
     * Memvalidasi input form tambah maupun edit inventaris.
     *
     * @return array<string, mixed>
     */
    private function validasiInput(Request $request, bool $wajibKode): array
    {
        $aturan = [
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:50'],
            'lokasi' => ['required', 'string', 'max:80'],
            'jumlah' => ['required', 'integer', 'min:0', 'max:100000'],
            'kondisi' => ['required', 'string', 'max:40'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ];

        if ($wajibKode) {
            $aturan['kode'] = ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9_-]+$/'];
        }

        return $request->validate($aturan, [
            'kode.required' => 'Kode inventaris wajib diisi.',
            'kode.regex' => 'Kode inventaris hanya boleh berisi huruf, angka, tanda hubung (-), atau garis bawah (_).',
            'nama.required' => 'Nama barang wajib diisi.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'lokasi.required' => 'Lokasi penyimpanan wajib dipilih.',
            'jumlah.required' => 'Jumlah stok wajib diisi.',
            'jumlah.integer' => 'Jumlah stok harus berupa angka bulat.',
            'jumlah.min' => 'Jumlah stok minimal 0.',
            'kondisi.required' => 'Kondisi barang wajib dipilih.',
        ]);
    }

    /**
     * Daftar pilihan kategori inventaris restoran DFC Cirebon.
     *
     * @return array<int, string>
     */
    private function opsiKategori(): array
    {
        return [
            'Bahan Baku',
            'Bumbu & Tepung',
            'Kemasan',
            'Minuman',
            'Peralatan Dapur',
            'Perlengkapan Outlet',
        ];
    }

    /**
     * Daftar pilihan lokasi penyimpanan DFC Cirebon.
     *
     * @return array<int, string>
     */
    private function opsiLokasi(): array
    {
        return [
            'Gudang Pusat',
            'Outlet Kesambi',
            'Outlet Perjuangan',
            'Outlet Sumber',
            'Dapur Utama',
        ];
    }

    /**
     * Daftar pilihan kondisi barang inventaris.
     *
     * @return array<int, string>
     */
    private function opsiKondisi(): array
    {
        return [
            'Baik',
            'Stok Menipis',
            'Perlu Perawatan',
            'Rusak',
        ];
    }
}
