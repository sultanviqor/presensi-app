<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Perizinan extends Model
{
    use HasFactory;
    protected $table = "perizinan";
    // protected $fillable = [
    //     'id_pegawai',
    //     'nip',
    //     'nama',
    //     'golongan',
    //     'jabatan',
    //     'tanggal_awal',
    //     'tanggal_akhir',
    //     'durasi',
    //     'keterangan',
    // ];
    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
