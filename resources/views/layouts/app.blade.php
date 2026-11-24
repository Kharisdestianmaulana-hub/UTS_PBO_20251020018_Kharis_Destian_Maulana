<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Inventaris - DFC Cirebon')</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #1f2937;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: #b91c1c;
            color: #ffffff;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header-inner {
            max-width: 1040px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .brand h1 {
            font-size: 1.25rem;
            font-weight: 700;
        }
        .brand p {
            font-size: 0.85rem;
            color: #fee2e2;
        }
        nav {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        nav a {
            color: #ffffff;
            text-decoration: none;
            padding: 0.45rem 0.9rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            background-color: rgba(255, 255, 255, 0.15);
            transition: background-color 0.2s;
        }
        nav a:hover,
        nav a.aktif {
            background-color: rgba(255, 255, 255, 0.28);
        }
        main {
            flex: 1;
            max-width: 1040px;
            width: 100%;
            margin: 1.5rem auto;
            padding: 0 1.5rem;
        }
        .kartu {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }
        .judul-halaman {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
        }
        .judul-halaman h2 {
            font-size: 1.3rem;
            color: #111827;
        }
        .tombol {
            display: inline-block;
            padding: 0.5rem 0.95rem;
            border-radius: 6px;
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .tombol:hover {
            opacity: 0.9;
        }
        .tombol-utama {
            background-color: #b91c1c;
            color: #ffffff;
        }
        .tombol-sekunder {
            background-color: #6b7280;
            color: #ffffff;
        }
        .tombol-info {
            background-color: #0284c7;
            color: #ffffff;
        }
        .tombol-peringatan {
            background-color: #d97706;
            color: #ffffff;
        }
        .tombol-bahaya {
            background-color: #dc2626;
            color: #ffffff;
        }
        .tombol-kecil {
            padding: 0.35rem 0.65rem;
            font-size: 0.8rem;
        }
        .peringatan {
            padding: 0.85rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.92rem;
        }
        .peringatan-sukses {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .peringatan-gagal {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .peringatan-info {
            background-color: #e0f2fe;
            color: #075985;
            border: 1px solid #bae6fd;
        }
        .tabel-wrapper {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.5rem;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.9rem;
        }
        th {
            background-color: #f9fafb;
            color: #374151;
            font-weight: 600;
        }
        tr:hover td {
            background-color: #f9fafb;
        }
        .aksi-grup {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            align-items: center;
        }
        .aksi-grup form {
            display: inline;
        }
        .lencana {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .lencana-baik {
            background-color: #dcfce7;
            color: #166534;
        }
        .lencana-menipis {
            background-color: #fef3c7;
            color: #92400e;
        }
        .lencana-rusak {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .form-grup {
            margin-bottom: 1rem;
        }
        .form-grup label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.35rem;
            font-size: 0.9rem;
        }
        .form-grup input,
        .form-grup select,
        .form-grup textarea {
            width: 100%;
            padding: 0.55rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.92rem;
            font-family: inherit;
        }
        .form-grup input[readonly] {
            background-color: #f3f4f6;
            color: #6b7280;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
        }
        .daftar-detail {
            width: 100%;
            border-collapse: collapse;
        }
        .daftar-detail th {
            width: 200px;
            background-color: #f9fafb;
        }
        footer {
            background-color: #1f2937;
            color: #d1d5db;
            text-align: center;
            padding: 1rem;
            font-size: 0.85rem;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-inner">
            <div class="brand">
                <h1>DFC Cirebon - Manajemen Inventaris</h1>
                <p>Adaptasi Studi Kasus Capstone Project (Berbasis Session File)</p>
            </div>
            <nav>
                <a href="{{ route('inventaris.index') }}" class="{{ request()->routeIs('inventaris.index') ? 'aktif' : '' }}">
                    Daftar Inventaris
                </a>
                <a href="{{ route('inventaris.create') }}" class="{{ request()->routeIs('inventaris.create') ? 'aktif' : '' }}">
                    + Tambah Inventaris
                </a>
            </nav>
        </div>
    </header>

    <main>
        <div class="kartu">
            @yield('content')
        </div>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} DFC Cirebon &mdash; UTS Pemrograman Berorientasi Objek (Laravel 13)</p>
    </footer>
</body>
</html>
