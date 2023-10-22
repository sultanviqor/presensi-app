<?php

namespace App\Console\Commands;

use App\Models\Absen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:add-data-command';
    protected $signature = 'data:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current date
        $currentDate = Carbon::now();

        // Get a list of users (e.g., from your User model)
        $users = User::all();

        // Iterate through each user and check if data exists for the current date
        foreach ($users as $user) {
            $existingData = Absen::where('user_id', $user->id)
                ->whereDate('tanggal', $currentDate->toDateString())
                ->first();

            if (!$existingData) {
                // Data doesn't exist for this user and date, so create a new record
                Absen::create([
                    'user_id' => $user->id,
                    'tanggal' => $currentDate->toDateString(),
                    'jenis_absen' => 'Tidak Masuk',
                    // Set other fields to null or defaults as needed
                ]);
                $this->info('Data added for ' . $user->name . ' on ' . $currentDate->toDateString());
            } else {
                $this->info('Data already exists for ' . $user->name . ' on ' . $currentDate->toDateString());
            }
        }
    }
}
