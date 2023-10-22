<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Perizinan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        return view('/login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'nip' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/absen-masuk');
        }

        return back()->withErrors([
            'nip' => 'The provided credentials do not match our records.',
        ])->onlyInput('nip');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // public function riwayatAbsen()
    // {
    //     $user = Auth::user();
    //     $absen = $user->absen;

    //     return view('/riwayat-absen', ['absen' => $absen]);
    // }

    public function absenMasukView()
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');

        if (Absen::where('user_id', $user->id)->whereDate('created_at', $today)->exists()) {
            return redirect('/end');
        } else {
            return view('/absen-masuk', ['user' => $user]);
        }
    }

    public function absenMasuk(Request $request)
    {
        $user = Auth::user();

        $data = [
            'user_id' => $user->id,
            'tanggal' => $request->tanggal,
            'jam_masuk' => $request->jam_masuk,
            'jenis_absen' => $request->jenis_absen,
            'lokasi' => $request->lokasi,
        ];

        $lokasiKantor = [-5.362532166666666, 105.28479583333332];
        $lokasiPegawai = explode(',', $request->lokasi);
        $jarak = $this->distance($lokasiKantor[0], $lokasiKantor[1], $lokasiPegawai[0], $lokasiPegawai[1]);
        $radius = round($jarak['meters']);

        if ($radius > 30) {
            return back()->withErrors('diluar radius');
        } else {
            Absen::create($data);

            return redirect('/countdown');
        }
    }

    public function countdown()
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        $absen = Absen::where('user_id', $user->id)->whereDate('created_at', $today)->first();
        $jamMasuk = Carbon::createFromFormat('H:i:s', $absen->jam_masuk);
        $expedtedJamPulang = $jamMasuk->addHours(0)->addMinutes(2)->format('H:i:s');

        $data = [
            'absen' => $absen,
            'expectedJamPulang' => $expedtedJamPulang,
        ];

        return view('countdown', ['data' => $data]);
    }

    public function absenPulang(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        $absen = Absen::where('user_id', $user->id)->whereDate('created_at', $today)->first();
        $jamMasuk = $absen->jam_masuk;
        $jamPulang = $request->jam_pulang;
        $jamKerja = (strtotime($jamPulang) - strtotime($jamMasuk)) / 3600;

        $lokasiKantor = [-5.362532166666666, 105.28479583333332];
        $lokasiPegawai = explode(',', $request->lokasi);
        $jarak = $this->distance($lokasiKantor[0], $lokasiKantor[1], $lokasiPegawai[0], $lokasiPegawai[1]);
        $radius = round($jarak['meters']);

        if ($radius > 30) {
            return back()->withErrors('diluar radius');
        } else {
            Absen::where('user_id', $user->id)->whereDate('created_at', $today)->update(['jam_pulang' => $jamPulang, 'jam_kerja' => $jamKerja]);

            return redirect('/end');
        }
    }

    public function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;

        return compact('meters');
    }

    public function izinView()
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');

        if (Perizinan::where('user_id', $user->id)->whereDate('created_at', $today)->exists()) {
            return redirect('/end');
        } else {
            return view('/izin', ['data' => $user]);
        }
    }

    public function izin(Request $request)
    {
        $user = Auth::user();
        $datesArray = [];

        function getDateArray($request, &$datesArray)
        {
            $currentDate = Carbon::parse($request->tanggal_awal);
            $laterDate = Carbon::parse($request->tanggal_akhir);

            while ($currentDate <= $laterDate) {
                $datesArray[] = $currentDate->toDateString();
                $currentDate->addDay();
            }

            return $datesArray;
        }

        getDateArray($request, $datesArray);

        foreach ($datesArray as $date) {
            Perizinan::create([
                'user_id' => $user->id,
                'tanggal_awal' => $date,
                'tanggal_akhir' => $request->tanggal_akhir,
                'keterangan' => $request->keterangan,
            ]);
        }
        foreach ($datesArray as $date) {
            Absen::create([
                'user_id' => $user->id,
                'tanggal' => $date,
                'jenis_absen' => 'Izin',
            ]);
        }

        return redirect('/end');
    }

    public function tampilPeta(Request $request)
    {
        $id = $request->id;
        $absen = Absen::where('id', $id)->first();
        $lokasi = $absen->lokasi;
        $expld = explode(',', $lokasi);
        $lat = $expld[0];
        $long = $expld[1];

        return view('peta-lokasi', compact(['lat', 'long']));
    }

    public function end()
    {
        $user = Auth::user();
        $absen = $user->absen;
        $izin = $user->izin;

        return view('/end', ['absen' => $absen, 'izin' => $izin]);
    }
}
