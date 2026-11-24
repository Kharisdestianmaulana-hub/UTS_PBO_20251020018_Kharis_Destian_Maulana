@extends('layouts.app')

@section('title', $judul ?? 'Daftar Inventaris - DFC Cirebon')

@section('content')
    <div class="judul-halaman">
        <h2>Daftar Inventaris Gudang &amp; Outlet</h2>
        <a href="{{ route('inventaris.create') }}" class="tombol tombol-utama">+ Tambah Inventaris</a>
    </div>

    @if (session('sukses'))
        <div class="peringatan peringatan-sukses">
            {{ session('sukses') }}
        </div>
    @endif

    @if (session('gagal'))
        <div class="peringatan peringatan-gagal">
            {{ session('gagal') }}
        </div>
    @endif

    @if (count($inventaris) > 0)
        <div class="tabel-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Inventaris</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventaris as $item)
                        <tr>
                            <td><strong>{{ $item['kode'] }}</strong></td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['kategori'] }}</td>
                            <td>{{ $item['lokasi'] }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>
                                @if ($item['kondisi'] === 'Baik')
                                    <span class="lencana lencana-baik">{{ $item['kondisi'] }}</span>
                                @elseif ($item['kondisi'] === 'Rusak')
                                    <span class="lencana lencana-rusak">{{ $item['kondisi'] }}</span>
                                @else
                                    <span class="lencana lencana-menipis">{{ $item['kondisi'] }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="aksi-grup">
                                    <a href="{{ route('inventaris.show', $item['kode']) }}" class="tombol tombol-info tombol-kecil">
                                        Detail
                                    </a>
                                    <a href="{{ route('inventaris.edit', $item['kode']) }}" class="tombol tombol-peringatan tombol-kecil">
                                        Edit
                                    </a>
                                    <form action="{{ route('inventaris.destroy', $item['kode']) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus inventaris {{ $item['nama'] }} ({{ $item['kode'] }})?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tombol tombol-bahaya tombol-kecil">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="peringatan peringatan-info">
            Belum ada data inventaris yang tersimpan di session. Silakan klik tombol <strong>+ Tambah Inventaris</strong> untuk menambahkan data baru.
        </div>
    @endif
@endsection
