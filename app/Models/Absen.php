<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Absen extends Model
{
    use HasFactory;
    protected $table = "absen";
    // protected $fillable = [
    //     'id_pegawai',
    //     'nip',
    //     'nama',
    //     'tanggal',
    //     'jam_masuk',
    //     'jam_pulang',
    //     'jam_kerja',
    //     'jenis_absen',
    //     'lokasi',
    // ];
    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
