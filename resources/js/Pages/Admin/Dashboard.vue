<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    stats: Object,
    recentPets: Array,
    recentBusinesses: Array,
});
</script>

<template>
    <Head title="Panel de Administración" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">Panel de Control: Chihuahua Digital</h2>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 transform transition hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-50 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Global</span>
                        </div>
                        <h3 class="text-gray-500 text-sm font-bold mb-1">Usuarios Totales</h3>
                        <p class="text-3xl font-black text-gray-900">{{ stats.total_users }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 transform transition hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-indigo-50 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-black text-indigo-400 uppercase tracking-widest">Módulo</span>
                        </div>
                        <h3 class="text-gray-500 text-sm font-bold mb-1">Mascotas Listadas</h3>
                        <p class="text-3xl font-black text-gray-900">{{ stats.total_pets }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 transform transition hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-amber-50 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <span v-if="stats.pending_businesses > 0" class="bg-red-100 text-red-600 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-tighter">{{ stats.pending_businesses }} PENDIENTES</span>
                        </div>
                        <h3 class="text-gray-500 text-sm font-bold mb-1">Negocios Registrados</h3>
                        <p class="text-3xl font-black text-gray-900">{{ stats.total_businesses }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 transform transition hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-50 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-black text-green-400 uppercase tracking-widest">Ingresos</span>
                        </div>
                        <h3 class="text-gray-500 text-sm font-bold mb-1">Recaudación Mensual</h3>
                        <p class="text-3xl font-black text-gray-900">${{ stats.monthly_revenue }}</p>
                    </div>
                </div>

                <!-- Tables Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Recent Pets Moderation -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">Últimas Publicaciones</h3>
                            <button class="text-indigo-600 text-xs font-black hover:underline uppercase tracking-widest">Ver Todo</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <tr>
                                        <th class="px-6 py-4">Mascota</th>
                                        <th class="px-6 py-4">Usuario</th>
                                        <th class="px-6 py-4">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr v-for="pet in recentPets" :key="pet.id" class="hover:bg-indigo-50/30 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 bg-indigo-100 rounded-xl mr-3"></div>
                                                <div>
                                                    <p class="font-bold text-gray-900 text-sm">{{ pet.name || 'Sin nombre' }}</p>
                                                    <p class="text-xs text-gray-500 uppercase">{{ pet.type }} / {{ pet.species }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-bold text-gray-700">{{ pet.user.name }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button class="text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Businesses Audit -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-black text-gray-900 uppercase tracking-tight">Negocios Nuevos</h3>
                            <button class="text-indigo-600 text-xs font-black hover:underline uppercase tracking-widest">Auditar</button>
                        </div>
                         <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    <tr>
                                        <th class="px-6 py-4">Negocio</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr v-for="biz in recentBusinesses" :key="biz.id" class="hover:bg-amber-50/30 transition">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900 text-sm">{{ biz.name }}</p>
                                            <p class="text-xs text-gray-500 uppercase tracking-tighter font-bold text-indigo-400">{{ biz.category }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span :class="biz.status === 'active' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'" class="px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                                {{ biz.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button class="text-gray-400 hover:text-gray-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
