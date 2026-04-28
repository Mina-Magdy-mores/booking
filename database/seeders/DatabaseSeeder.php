<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'role' => 'user',
        ]);
        User::factory(10)->create();
        Category::factory(5)->create();
        Event::factory(20)->create();
        Booking::factory(50)->create();
        }
}
