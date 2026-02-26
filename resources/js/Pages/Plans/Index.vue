<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    plans: Array,
});
</script>

<template>
    <Head title="Planes y Precios" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('dashboard')" class="p-2 bg-white rounded-xl shadow-sm hover:shadow-md transition text-gray-400 hover:text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase tracking-tight">Potencia tu Negocio</h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block border border-indigo-100">
                        Planes de Crecimiento
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black text-gray-900 mb-6 tracking-tighter leading-tight">
                        Impulsa tu visibilidad en <span class="text-indigo-600">Cuauhtémoc</span>
                    </h1>
                    <p class="text-lg text-gray-500 max-w-2xl mx-auto font-medium leading-relaxed">
                        Elige el plan que mejor se adapte a tu veterinaria. Destaca entre la competencia y llega a más dueños de mascotas.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-end">
                    <div v-for="plan in plans" :key="plan.id" 
                         class="group relative bg-white rounded-[3rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 flex flex-col h-full transform hover:-translate-y-4"
                         :class="{ 
                            'border-indigo-600 ring-4 ring-indigo-600/10 scale-105 z-10 md:mb-0': plan.slug === 'premium',
                            'border-amber-200 ring-4 ring-amber-100/30': plan.slug === 'elite',
                            'md:mb-4': plan.slug !== 'premium'
                         }">
                        
                        <!-- Premium/Elite Badges & Glow -->
                        <div v-if="plan.slug === 'premium'" class="absolute inset-0 bg-gradient-to-b from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div v-if="plan.slug === 'elite'" class="absolute -inset-0.5 bg-gradient-to-r from-amber-400 to-yellow-300 blur opacity-10 group-hover:opacity-30 transition duration-500"></div>

                        <div v-if="plan.slug === 'premium'" class="absolute top-8 right-8">
                            <span class="bg-indigo-600 text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl shadow-indigo-200">
                                Más Popular
                            </span>
                        </div>
                        <div v-if="plan.slug === 'elite'" class="absolute top-8 right-8">
                            <span class="bg-gradient-to-r from-amber-400 to-yellow-500 text-white px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-xl shadow-amber-200">
                                Recomendado Elite
                            </span>
                        </div>

                        <div class="p-10 pt-16 flex-grow relative z-10">
                            <h3 class="text-3xl font-black text-gray-900 mb-6 tracking-tighter">{{ plan.name }}</h3>
                            
                            <div class="flex items-baseline mb-10 pb-10 border-b border-gray-50">
                                <span class="text-5xl font-black text-gray-900 tracking-tighter">${{ plan.price }}</span>
                                <span class="text-gray-400 font-black uppercase text-xs tracking-widest ml-2">/ Mes</span>
                            </div>

                            <ul class="space-y-6">
                                <li v-for="feature in plan.features" :key="feature" class="flex items-start text-gray-600">
                                    <div class="p-1 bg-green-50 rounded-full mr-4 mt-0.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold leading-tight">{{ feature }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="p-10 pt-0 relative z-10">
                            <Link :href="route('subscriptions.create', { plan: plan.slug })" 
                                  class="w-full flex items-center justify-center py-5 rounded-[1.5rem] font-black text-xs uppercase tracking-widest transition-all duration-300 shadow-xl transform active:scale-95"
                                  :class="{
                                      'bg-indigo-600 text-white hover:bg-indigo-700 shadow-indigo-100': plan.slug === 'premium',
                                      'bg-gray-900 text-white hover:bg-indigo-600 shadow-gray-200': plan.slug === 'elite',
                                      'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-100': plan.slug === 'basico'
                                  }">
                                {{ plan.price === 0 ? 'Comenzar Gratis' : 'Elegir éste plan' }}
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Enterprise Section -->
                <div class="mt-24 relative rounded-[4rem] overflow-hidden bg-gray-900 p-12 md:p-20 text-white shadow-2xl">
                    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-indigo-500/10 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px] -translate-x-1/2 translate-y-1/2"></div>
                    
                    <div class="relative z-10 flex flex-wrap justify-between items-center gap-12">
                        <div class="max-w-xl">
                            <span class="text-indigo-400 font-black uppercase text-[10px] tracking-[0.3em] mb-4 block">Soluciones Avanzadas</span>
                            <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tighter leading-tight">¿Tienes varios establecimientos?</h2>
                            <p class="text-gray-400 text-lg font-medium leading-relaxed">
                                Contamos con soluciones personalizadas y planes corporativos para cadenas de veterinarias y franquicias en todo el estado de Chihuahua.
                            </p>
                        </div>
                        <div class="shrink-0">
                            <button class="px-12 py-6 bg-white text-gray-900 rounded-[2rem] font-black text-sm uppercase tracking-widest hover:bg-indigo-50 transition-all shadow-xl hover:shadow-indigo-500/20 transform hover:-translate-y-1">
                                Contactar un Asesor
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-20 text-center text-gray-400 text-xs font-bold uppercase tracking-widest">
                    Seguridad garantizada por cifrado SSL de 256 bits
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
