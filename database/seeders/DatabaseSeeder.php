<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecutar los seeders de la aplicación.
     */
    public function run(): void
    {
        $this->call([
            ProcessSeeder::class,
        ]);
    }
}