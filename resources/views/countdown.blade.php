<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>Berhasil Absen</div>
    <div>Silahkan Absen Pulang Pukul {{ $data['expectedJamPulang'] }}</div>
    <div>Sisa Waktu Kerja anda</div>
    <div id="countdown"></div>
    <form action="/absen-pulang" method="post">
        @csrf
        <input type="time" name="jam_pulang" id="" value="{{ date('H:i:s') }}" required hidden>
        <input type="text" name="lokasi" id="" required hidden>
        <button id="btn" disabled>absen pulang</button>
    </form>

    <script>
        // countdown
        let timer
        const absen = @json($data['absen']);
        const expectedTime = @json($data['expectedJamPulang']);
        const countdownElement = document.getElementById("countdown")
        const btn = document.getElementById('btn')
        // const currentDate = new Date()
        // const setCurrentDate = new Date(currentDate.getFullYear(),
        //                                 currentDate.getMonth(),
        //                                 currentDate.getDate(),
        //                                 10,0,0)

        const updateCountdown = () => {
            const now = new Date()
            const expectedDate = new Date(now.toDateString() + " " + expectedTime)
            const timeRemaining = expectedDate - now

            if (timeRemaining <= 0) {
                clearInterval(timer)
                countdownElement.innerHTML = "Selesai!"
                if (absen.jam_pulang !== null) {
                    btn.disabled = true
                }else{
                    btn.disabled = false
                }
            } else {
                const hours = Math.floor(timeRemaining / (1000 * 60 * 60))
                const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60))
                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000)

                countdownElement.innerHTML = `${hours}:${minutes}:${seconds}`
            }
        };

        updateCountdown()

        timer = setInterval(updateCountdown, 1000)

        // lokasi
        let locate = document.getElementsByName('lokasi')[0]

        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCB, errorCB)
        }

        function successCB(position){
            locate.value = position.coords.latitude + "," + position.coords.longitude
        }

        function errorCB(){}
    </script>
</body>
</html>