<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\Tenant::where('slug', 'cuauhtemoc')->first();
        $user = \App\Models\User::first() ?? \App\Models\User::factory()->create(['tenant_id' => $tenant->id]);

        \App\Models\Pet::updateOrCreate(
        ['description' => 'Perrito labrador color miel, muy juguetón y amigable.'],
        [
            'tenant_id' => $tenant->id,
            'user_id' => $user->id,
            'type' => 'adopcion',
            'species' => 'Perro Labrador',
            'sex' => 'Macho',
            'size' => 'Grande',
            'age' => '3 meses',
            'location' => 'Col. Centro',
            'contact_info' => ['phone' => '6251234567', 'whatsapp' => '6251234567'],
            'status' => 'active'
        ]
        );

        \App\Models\Pet::updateOrCreate(
        ['description' => 'Gatito extraviado en la zona de la Ciudadela, tiene un collar azul.'],
        [
            'tenant_id' => $tenant->id,
            'user_id' => $user->id,
            'type' => 'perdido',
            'species' => 'Gato Siamés',
            'sex' => 'Hembra',
            'size' => 'Pequeño',
            'age' => '2 años',
            'location' => 'Fracc. La Ciudadela',
            'contact_info' => ['phone' => '6259876543', 'whatsapp' => '6259876543'],
            'status' => 'active'
        ]
        );
    }
}
