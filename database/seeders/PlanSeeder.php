<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Básico',
                'slug' => 'basic',
                'price' => 0.00,
                'billing_period' => 'monthly',
                'features' => [
                    'Presencia en el directorio',
                    'Información básica de contacto',
                    'Categorización estándar',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Premium (Destacado)',
                'slug' => 'premium',
                'price' => 299.00,
                'billing_period' => 'monthly',
                'features' => [
                    'Presencia prioritaria en búsquedas',
                    'Logo personalizado',
                    'Galería de hasta 5 imágenes',
                    'Enlaces a redes sociales',
                    'Soporte por WhatsApp',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Elite (Máxima Visibilidad)',
                'slug' => 'elite',
                'price' => 599.00,
                'billing_period' => 'monthly',
                'features' => [
                    'Primer lugar en resultados de búsqueda',
                    'Etiqueta de Recomendado SI',
                    'Banner promocional en el inicio',
                    'Analíticas de visitas',
                    'Gestión de citas básica',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            \App\Models\Plan::updateOrCreate(
            ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
