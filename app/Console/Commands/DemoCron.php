<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

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
        info("Cron is running" . now());
        $response = Http::get('https://jsonplaceholder.typicode.com/users');
          
        $users = $response->json();
        // Log::info($users);
        if (!empty($users)) {
            foreach ($users as $key => $user) {
                if(!User::where('email', rand() . $user['email'])->exists() ){
                    $user = User::create([
                        'name' => $user['name'],
                        'email' => rand() . $user['email'],
                        'password' => bcrypt('123456789')
                    ]);
                    Log::info('User created: ' . $user->email);
                } else {
                    Log::info('User already exists: ' . $user['email']);
                }   
            }
        }

    }
}
