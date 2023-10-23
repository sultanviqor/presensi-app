<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        #map { height: 300px; }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>

    <title>Document</title>
</head>
<body>
    <form action="/absen-masuk" method="post">
    @csrf
        <label for="">NIP</label>
        <input type="text" value="{{ $user->nip }}" required>
        <label for="">Gol</label>
        <input type="text" value="{{ $user->golongan }}">
        <label for="">Jabatan</label>
        <input type="text" value="{{ $user->jabatan }}">
        <label for="">Tanggal</label>
        <input type="date" name="tanggal" id="" value="{{ date('Y-m-d') }}" required>
        <label for="">Jam Masuk</label>
        <input type="time" name="jam_masuk" id="" value="{{ date('H:i:s') }}" required>
        <input type="text" name="jenis_absen" id="" value="{{ 'Masuk' }}"  required hidden>
        <label for="">Lokasi</label>
        <input type="text" name="lokasi" id="" required>
        <div id="map"></div>
        <button id="btn-absen" disabled>absen</button>
    </form>
    <form action="/logout" method="post">
        @csrf
        <button>logout</button>
    </form>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

    <script>
        let locate = document.getElementsByName('lokasi')[0]
        let btn = document.getElementById('btn-absen')

        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCB, errorCB)
        }

        function successCB(position){
            locate.value = position.coords.latitude + "," + position.coords.longitude
            btn.disabled = false
            let map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
            let marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            let circle = L.circle([-5.362532166666666,105.28479583333332], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 30
            }).addTo(map);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
        }

        function errorCB(){}
    </script>
</body>
</html>