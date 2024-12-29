<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Church;
use App\Models\Preaching;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        //Church::factory(15)->create();
        Preaching::factory(100)->create();
        */
        Role::insert(
            [
                ['name' => RoleType::ADMIN],
                ['name' => RoleType::CONSUMER],
                ['name' => RoleType::CREATOR],
            ]
        );
    }
}
