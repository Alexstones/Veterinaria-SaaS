<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    businesses: Object,
    filters: Object,
    auth: Object,
});

const category = ref(props.filters.category || '');

watch(category, (value) => {
    router.get(route('businesses.index'), { category: value }, { preserveState: true, replace: true });
});

const Layout = props.auth?.user ? AuthenticatedLayout : GuestLayout;

const categories = [
    'Veterinarias',
    'Estética y Baño',
    'Accesorios y Alimento',
    'Entrenamiento',
    'Pensiones',
    'Adopciones Externas',
];
</script>

<template>
    <Head title="Directorio de Negocios" />

    <component :is="Layout">
        <template v-if="props.auth?.user" #header>
            <div class="flex justify-between items-center">
                <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase tracking-tight">Directorio de Negocios</h2>
                <Link :href="route('businesses.create')" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 transform active:scale-95">
                    Registrar Negocio
                </Link>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Hero / Filter Section -->
                <div v-if="!props.auth?.user" class="mb-16 text-center">
                    <h1 class="text-4xl md:text-6xl font-black text-gray-900 mb-4 tracking-tighter">Todo para tu mascota en <span class="text-indigo-600">Cuauhtémoc</span></h1>
                    <p class="text-gray-500 text-lg max-w-2xl mx-auto font-medium">Desde veterinarias hasta estéticas y alimento. Solo lo mejor para tu mejor amigo.</p>
                </div>

                <div class="mb-12 flex flex-wrap justify-center gap-3">
                    <button 
                        @click="category = ''"
                        :class="category === '' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'"
                        class="px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest shadow-sm transition"
                    >
                        Todos
                    </button>
                    <button 
                        v-for="cat in categories" 
                        :key="cat"
                        @click="category = cat"
                        :class="category === cat ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'"
                        class="px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest shadow-sm transition"
                    >
                        {{ cat }}
                    </button>
                </div>

                <!-- Businesses Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <div v-for="business in businesses.data" :key="business.id" 
                        class="group relative bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 flex flex-col h-full transform hover:-translate-y-2"
                        :class="{ 
                            'border-amber-200 ring-2 ring-amber-100 shadow-amber-50': business.plan_name === 'Elite',
                            'border-indigo-200 ring-2 ring-indigo-50 shadow-indigo-50': business.plan_name === 'Premium'
                        }"
                    >
                        <!-- Elite/Premium Glow Effect -->
                        <div v-if="business.plan_name === 'Elite'" class="absolute -inset-0.5 bg-gradient-to-r from-amber-400 to-yellow-300 rounded-[2.6rem] blur opacity-10 group-hover:opacity-30 transition duration-500"></div>

                        <div class="h-56 bg-white relative overflow-hidden flex items-center justify-center p-8 border-b border-gray-50">
                            <img v-if="business.logo" :src="business.logo" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-700" alt="Logo">
                            <div v-else class="w-full h-full flex items-center justify-center bg-indigo-50 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-indigo-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            
                            <!-- Category Badge -->
                            <div class="absolute top-6 left-6">
                                <span class="bg-gray-900/10 backdrop-blur-md px-4 py-1.5 rounded-full text-[10px] font-black text-gray-600 uppercase tracking-widest border border-white/20">
                                    {{ business.category }}
                                </span>
                            </div>

                            <!-- Plan Badge -->
                            <div v-if="business.plan_name && business.plan_name !== 'Básico'" class="absolute top-6 right-6">
                                <span :class="{
                                    'bg-gradient-to-r from-amber-400 to-yellow-500 text-white shadow-amber-200': business.plan_name === 'Elite',
                                    'bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-indigo-200': business.plan_name === 'Premium'
                                }" class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    {{ business.plan_name }}
                                </span>
                            </div>
                        </div>

                        <div class="p-10 flex flex-col flex-grow relative z-10">
                            <h3 class="text-2xl font-black text-gray-900 mb-4 group-hover:text-indigo-600 transition tracking-tighter">{{ business.name }}</h3>
                            <p class="text-gray-500 text-sm font-medium line-clamp-2 mb-8 leading-relaxed">{{ business.description }}</p>
                            
                            <div class="mt-auto space-y-4">
                                <div class="grid grid-cols-2 gap-3 text-[11px] font-black uppercase tracking-widest">
                                    <div class="flex items-center text-gray-400 bg-gray-50 p-3 rounded-2xl border border-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        <span class="truncate">Ver Mapa</span>
                                    </div>
                                    <div v-if="business.phone" class="flex items-center text-gray-400 bg-gray-50 p-3 rounded-2xl border border-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="truncate">Llamar</span>
                                    </div>
                                </div>

                                <Link :href="route('businesses.show', business.id)" class="w-full text-center py-4 bg-gray-900 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition shadow-lg shadow-gray-200 group-hover:shadow-indigo-100">
                                    Conocer más
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="businesses.data.length === 0" class="text-center py-32 bg-white rounded-[3rem] shadow-sm border border-gray-100">
                    <div class="p-10 bg-indigo-50 rounded-full inline-block mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-xl font-bold tracking-tight">No hay negocios registrados aquí todavía.</p>
                </div>
            </div>
        </div>
    </component>
</template>
