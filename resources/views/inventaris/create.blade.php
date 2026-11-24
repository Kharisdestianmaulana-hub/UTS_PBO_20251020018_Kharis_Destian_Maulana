@extends('layouts.app')

@section('title', $judul ?? 'Tambah Inventaris - DFC Cirebon')

@section('content')
    <div class="judul-halaman">
        <h2>Tambah Data Inventaris</h2>
        <a href="{{ route('inventaris.index') }}" class="tombol tombol-sekunder">Kembali ke Daftar</a>
    </div>

    @if (session('gagal'))
        <div class="peringatan peringatan-gagal">
            {{ session('gagal') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="peringatan peringatan-gagal">
            <strong>Terjadi kesalahan input:</strong>
            <ul style="margin-left: 1.25rem; margin-top: 0.35rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inventaris.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <div class="form-grup">
                <label for="kode">Kode Inventaris</label>
                <input type="text"
                       id="kode"
                       name="kode"
                       value="{{ old('kode') }}"
                       placeholder="Contoh: INV-001"
                       required>
            </div>

            <div class="form-grup">
                <label for="nama">Nama Inventaris</label>
                <input type="text"
                       id="nama"
                       name="nama"
                       value="{{ old('nama') }}"
                       placeholder="Contoh: Tepung Bumbu DFC 1 Kg"
                       required>
            </div>

            <div class="form-grup">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($daftarKategori as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori') === $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-grup">
                <label for="lokasi">Lokasi Penyimpanan</label>
                <select id="lokasi" name="lokasi" required>
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach ($daftarLokasi as $lokasi)
                        <option value="{{ $lokasi }}" {{ old('lokasi') === $lokasi ? 'selected' : '' }}>
                            {{ $lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-grup">
                <label for="jumlah">Jumlah Stok</label>
                <input type="number"
                       id="jumlah"
                       name="jumlah"
                       min="0"
                       value="{{ old('jumlah', 0) }}"
                       required>
            </div>

            <div class="form-grup">
                <label for="kondisi">Kondisi</label>
                <select id="kondisi" name="kondisi" required>
                    <option value="">-- Pilih Kondisi --</option>
                    @foreach ($daftarKondisi as $kondisi)
                        <option value="{{ $kondisi }}" {{ old('kondisi') === $kondisi ? 'selected' : '' }}>
                            {{ $kondisi }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-grup">
            <label for="keterangan">Keterangan Tambahan (Opsional)</label>
            <textarea id="keterangan"
                      name="keterangan"
                      rows="3"
                      placeholder="Catatan kondisi atau satuan barang...">{{ old('keterangan') }}</textarea>
        </div>

        <div class="aksi-grup">
            <button type="submit" class="tombol tombol-utama">Simpan Inventaris</button>
            <a href="{{ route('inventaris.index') }}" class="tombol tombol-sekunder">Batal</a>
        </div>
    </form>
@endsection
