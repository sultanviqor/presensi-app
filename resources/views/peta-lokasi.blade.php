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
    <div id="map"></div>

    <a href="/end"><button>kembali</button></a>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
    
    <script>

        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCB, errorCB)
        }

        function successCB(position){
            let map = L.map('map').setView([{{ $lat }}, {{ $long }}], 17);
            let marker = L.marker([{{ $lat }}, {{ $long }}]).addTo(map);
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