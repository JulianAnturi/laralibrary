<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                "id" => 14,
                "name" => "Willian Ruiz",
                "email" => "wilian_ruiz@docente.ibero.edu.co",
                "password" => bcrypt('12345678'),
                "role" => 0
            ]
        );
    }
}
