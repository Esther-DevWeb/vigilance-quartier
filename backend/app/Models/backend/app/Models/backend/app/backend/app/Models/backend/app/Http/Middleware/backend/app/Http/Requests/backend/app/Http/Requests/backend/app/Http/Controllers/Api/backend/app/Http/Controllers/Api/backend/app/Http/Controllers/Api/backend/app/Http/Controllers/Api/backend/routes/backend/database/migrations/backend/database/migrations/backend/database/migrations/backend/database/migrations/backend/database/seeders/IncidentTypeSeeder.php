<?php

namespace Database\Seeders;

use App\Models\IncidentType;
use Illuminate\Database\Seeder;

class IncidentTypeSeeder extends Seeder
{
    public function run()
    {
        foreach (['Vol', 'Agression', 'Éclairage public', 'Inondation', 'Animal errant'] as $name) {
            IncidentType::create(['name' => $name]);
        }
    }
}
