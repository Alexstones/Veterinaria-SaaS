<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\Tenant::where('slug', 'cuauhtemoc')->first();
        $user = \App\Models\User::first() ?? \App\Models\User::factory()->create(['tenant_id' => $tenant->id]);

        $samples = [
            [
                'name' => 'Veterinaria San Francisco',
                'category' => 'Veterinarias',
                'description' => 'Servicios médicos veterinarios integrales, cirugía, rayos X y farmacia especializada.',
                'address' => 'Av. 16 de Septiembre #1234, Col. Centro',
                'phone' => '6251002030',
                'email' => 'contacto@vetsanfrancisco.com',
                'status' => 'active',
            ],
            [
                'name' => 'Pet Grooming Cuauhtémoc',
                'category' => 'Estética y Baño',
                'description' => 'Cortes de raza, baños medicados y spa para tus mejores amigos.',
                'address' => 'Calle 5a y Morelos #500',
                'phone' => '6251112233',
                'email' => 'info@petgrooming.mx',
                'status' => 'active',
            ],
            [
                'name' => 'El Granero Canino',
                'category' => 'Accesorios y Alimento',
                'description' => 'Venta de alimento premium por kilo y accesorios de las mejores marcas.',
                'address' => 'Calzada 11 de Julio y Belisario Domínguez',
                'phone' => '6251122334',
                'status' => 'active',
            ],
        ];

        foreach ($samples as $sample) {
            \App\Models\Business::updateOrCreate(
            ['name' => $sample['name']],
                array_merge($sample, [
                'tenant_id' => $tenant->id,
                'user_id' => $user->id,
            ])
            );
        }
    }
}
