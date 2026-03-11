<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678')
        ]);

        $sections = [
            'Deportes',
            'Política',
            'Social',
            'Internacional',
            'Cultura',
            'Salud',
        ];

        foreach ($sections as $name) {
            Section::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        $statuses = [
            'Borrador',
            'Publicado',
            'Archivado',
        ];

        foreach ($statuses as $name) {
            Status::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
