<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserJsonSeeder extends Seeder
{
    public function run()
    {
        $jsonFilePath = storage_path('app/pegawai.json');
        $jsonData = File::get($jsonFilePath);
        $data = json_decode($jsonData, true);

        foreach ($data as $item) {
            User::create($item);
        }
    }
}
