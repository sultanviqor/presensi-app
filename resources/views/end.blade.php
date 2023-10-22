<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

    <title>Document</title>
</head>
<body>
    <h1>Absen</h1>
    <table class="myTable" class="display">
        <thead>
            <tr>
                <th>tanggal</th>
                <th>jam masuk</th>
                <th>jam pulang</th>
                <th>jumlah jam kerja</th>
                <th>jenis absen</th>
                <th>koordinat</th>
                <th>peta lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absen as $a)
            <tr>
                <td>{{ $a->tanggal }}</td>
                <td>{{ $a->jam_masuk }}</td>
                <td>{{ $a->jam_pulang }}</td>
                <td>{{ $a->jam_kerja }}</td>
                <td>{{ $a->jenis_absen }}</td>
                <td>{{ $a->koordinat }}</td>
                <td><a href="peta-lokasi/{{$a->id}}"><button {{ $a->lokasi == null ? 'disabled' : '' }}>peta</button></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h1>Izin</h1>
    <table class="myTable" class="display">
        <thead>
            <tr>
                <th>tanggal awal</th>
                <th>tanggal akhir</th>
                <th>keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($izin as $i)
            <tr>
                <td>{{ $i->tanggal_awal }}</td>
                <td>{{ $i->tanggal_akhir }}</td>
                <td>{{ $i->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="/logout" method="post">
        @csrf
        <button>logout</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        let table = new DataTable('.myTable')
    </script>
</body>
</html>