@extends('layouts.app')

@section('title', $judul ?? 'Detail Inventaris - DFC Cirebon')

@section('content')
    <div class="judul-halaman">
        <h2>Detail Inventaris: {{ $item['nama'] }}</h2>
        <a href="{{ route('inventaris.index') }}" class="tombol tombol-sekunder">Kembali ke Daftar</a>
    </div>

    <table class="daftar-detail">
        <tr>
            <th>Kode Inventaris</th>
            <td><strong>{{ $item['kode'] }}</strong></td>
        </tr>
        <tr>
            <th>Nama Inventaris</th>
            <td>{{ $item['nama'] }}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{{ $item['kategori'] }}</td>
        </tr>
        <tr>
            <th>Lokasi Penyimpanan</th>
            <td>{{ $item['lokasi'] }}</td>
        </tr>
        <tr>
            <th>Jumlah Stok</th>
            <td>{{ $item['jumlah'] }}</td>
        </tr>
        <tr>
            <th>Kondisi</th>
            <td>
                @if ($item['kondisi'] === 'Baik')
                    <span class="lencana lencana-baik">{{ $item['kondisi'] }}</span>
                @elseif ($item['kondisi'] === 'Rusak')
                    <span class="lencana lencana-rusak">{{ $item['kondisi'] }}</span>
                @else
                    <span class="lencana lencana-menipis">{{ $item['kondisi'] }}</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>{{ $item['keterangan'] !== '' ? $item['keterangan'] : '-' }}</td>
        </tr>
        <tr>
            <th>Dibuat Pada</th>
            <td>{{ $item['dibuat_pada'] ?? '-' }}</td>
        </tr>
        <tr>
            <th>Terakhir Diperbarui</th>
            <td>{{ $item['diperbarui_pada'] ?? '-' }}</td>
        </tr>
    </table>

    <div class="aksi-grup" style="margin-top: 1.25rem;">
        <a href="{{ route('inventaris.edit', $item['kode']) }}" class="tombol tombol-peringatan">Edit Inventaris</a>
        <form action="{{ route('inventaris.destroy', $item['kode']) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus inventaris {{ $item['nama'] }} ({{ $item['kode'] }})?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="tombol tombol-bahaya">Hapus Inventaris</button>
        </form>
        <a href="{{ route('inventaris.index') }}" class="tombol tombol-sekunder">Kembali</a>
    </div>
@endsection
