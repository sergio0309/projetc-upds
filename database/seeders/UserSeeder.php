<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'ci' => '12781469',
            'complement_ci' => '',
            'nit' => '',
            'first_name' => strtoupper('Sergio Daniel'),
            'last_name' => strtoupper('Rodriguez Aramayo'),
            'gender' => strtoupper('Masculino'),
            'date_birth' => '2000-09-03',
            'phone' => '73868164',
            'email' => 'JPM.12781469@outlook.com',
            'email_verified_at' => now(),  // Cambié esto a la fecha actual
            'password' => Hash::make('12345678'),
            'status' => 1,
            'image' => '',
            'address' => strtoupper('Calle Ficticia 123, Ciudad Real'),
            'emergency_contact' => strtoupper('Ronald Rodrigo Rodriguez Aramayo'),
            'emergency_number' => '73333374'
        ]);
    }
}
