<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center w-full">
                <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase tracking-tight">Panel de Control</h2>
                <div class="flex space-x-2">
                    <span class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                        Usuario Activo
                    </span>
                </div>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
                
                <!-- Welcome Section -->
                <div class="bg-white rounded-[3rem] p-10 md:p-14 shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-64 h-64 bg-indigo-50/50 blur-[100px] translate-x-1/2 -translate-y-1/2"></div>
                    
                    <div class="relative z-10 flex flex-wrap justify-between items-center gap-8">
                        <div>
                            <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter mb-4">¡Hola, {{ $page.props.auth.user.name }}!</h1>
                            <p class="text-gray-500 text-lg font-medium">Bienvenido de nuevo a tu centro de gestión de mascotas en Cuauhtémoc.</p>
                        </div>
                        <div class="flex gap-4">
                            <Link :href="route('pets.create')" class="px-8 py-5 bg-indigo-600 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 transform active:scale-95">
                                Publicar Mascota
                            </Link>
                            <Link :href="route('businesses.create')" class="px-8 py-5 bg-gray-900 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-gray-800 transition shadow-xl shadow-gray-200 transform active:scale-95">
                                Registrar Negocio
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Stats / Quick Actions Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- My Listings Card -->
                    <Link :href="route('my-pets.index')" class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:shadow-xl transition duration-500 group block">
                        <div class="bg-indigo-50 w-16 h-16 rounded-2xl flex items-center justify-center text-indigo-500 mb-8 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 mb-2">Mis Mascotas</h3>
                        <p class="text-gray-500 text-sm font-medium mb-8">Administra tus publicaciones de adopción y reportes de extravío.</p>
                        <span class="text-xs font-black text-indigo-600 uppercase tracking-widest group-hover:underline">
                            Ver publicaciones →
                        </span>
                    </Link>

                    <!-- My Businesses Card -->
                    <Link :href="route('businesses.index')" class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:shadow-xl transition duration-500 group block">
                        <div class="bg-amber-50 w-16 h-16 rounded-2xl flex items-center justify-center text-amber-500 mb-8 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 mb-2">Mis Negocios</h3>
                        <p class="text-gray-500 text-sm font-medium mb-8">Gestiona tus establecimientos, servicios y suscripciones activas.</p>
                        <span class="text-xs font-black text-amber-600 uppercase tracking-widest group-hover:underline">
                            Gestionar negocios →
                        </span>
                    </Link>

                    <!-- Subscriptions Card -->
                    <Link :href="route('plans.index')" class="bg-indigo-900 rounded-[2.5rem] p-10 shadow-2xl shadow-indigo-100 text-white transform hover:scale-[1.02] transition duration-500 block group">
                        <div class="bg-white/10 w-16 h-16 rounded-2xl flex items-center justify-center text-white mb-8 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-black text-white mb-2">Visibilidad Premium</h3>
                        <p class="text-indigo-200 text-sm font-medium mb-8">Aumenta tus clientes activando un plan destacado para tus servicios.</p>
                        <span class="px-6 py-3 bg-white text-indigo-900 rounded-xl text-[10px] font-black uppercase tracking-widest group-hover:bg-indigo-50 transition shadow-lg inline-block">
                            Ver Planes →
                        </span>
                    </Link>
                </div>

                <!-- Recent Activity Feed (Empty State) -->
                <div class="bg-gray-100/50 rounded-[3rem] p-12 text-center border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 font-black uppercase text-[10px] tracking-widest">No hay actividad reciente para mostrar</p>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
