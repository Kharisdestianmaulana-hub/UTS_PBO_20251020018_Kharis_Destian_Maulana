@extends('layouts.app')

@section('title', $judul ?? 'Edit Inventaris - DFC Cirebon')

@section('content')
    <div class="judul-halaman">
        <h2>Edit Data Inventaris ({{ $item['kode'] }})</h2>
        <a href="{{ route('inventaris.index') }}" class="tombol tombol-sekunder">Kembali ke Daftar</a>
    </div>

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

    <form action="{{ route('inventaris.update', $item['kode']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-grup">
                <label for="kode">Kode Inventaris</label>
                <input type="text"
                       id="kode"
                       name="kode"
                       value="{{ $item['kode'] }}"
                       readonly>
            </div>

            <div class="form-grup">
                <label for="nama">Nama Inventaris</label>
                <input type="text"
                       id="nama"
                       name="nama"
                       value="{{ old('nama', $item['nama']) }}"
                       required>
            </div>

            <div class="form-grup">
                <label for="kategori">Kategori</label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($daftarKategori as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori', $item['kategori']) === $kategori ? 'selected' : '' }}>
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
                        <option value="{{ $lokasi }}" {{ old('lokasi', $item['lokasi']) === $lokasi ? 'selected' : '' }}>
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
                       value="{{ old('jumlah', $item['jumlah']) }}"
                       required>
            </div>

            <div class="form-grup">
                <label for="kondisi">Kondisi</label>
                <select id="kondisi" name="kondisi" required>
                    <option value="">-- Pilih Kondisi --</option>
                    @foreach ($daftarKondisi as $kondisi)
                        <option value="{{ $kondisi }}" {{ old('kondisi', $item['kondisi']) === $kondisi ? 'selected' : '' }}>
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
                      rows="3">{{ old('keterangan', $item['keterangan'] ?? '') }}</textarea>
        </div>

        <div class="aksi-grup">
            <button type="submit" class="tombol tombol-peringatan">Perbarui Inventaris</button>
            <a href="{{ route('inventaris.show', $item['kode']) }}" class="tombol tombol-info">Lihat Detail</a>
            <a href="{{ route('inventaris.index') }}" class="tombol tombol-sekunder">Batal</a>
        </div>
    </form>
@endsection
