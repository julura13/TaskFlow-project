<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Single password for all seeded users (easy to remember for demos).
     */
    private const DEMO_PASSWORD = 'password';

    public function run(): void
    {
        $password = Hash::make(self::DEMO_PASSWORD);

        User::create([
            'name' => 'Juan Rautenbach',
            'email' => 'juan@julura.co.za',
            'password' => Hash::make('1zeoa11!'),
        ]);

        User::factory()->count(8)->create([
            'password' => $password,
        ]);

        User::firstOrCreate(
            ['email' => 'demo@taskflow.test'],
            [
                'name' => 'Demo User',
                'password' => $password,
            ]
        );
    }
}
