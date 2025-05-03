<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Person;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(BookSeeder::class);
        Person::factory(20)->create();
        Book::factory(120)->create();
    }
}
