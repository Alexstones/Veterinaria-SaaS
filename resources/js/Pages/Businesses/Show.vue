<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    business: Object,
    auth: Object,
});

const Layout = props.auth?.user ? AuthenticatedLayout : GuestLayout;
</script>

<template>
    <Head :title="business.name" />

<template>
    <Head :title="business.name" />

    <component :is="Layout">
        <template v-if="props.auth?.user" #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('businesses.index')" class="p-2 bg-white rounded-xl shadow-sm hover:shadow-md transition text-gray-400 hover:text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase tracking-tight">{{ business.name }}</h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
                    
                    <!-- Left Column: Branding & Stats -->
                    <div class="space-y-8">
                        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 flex flex-col items-center">
                            <div class="w-full aspect-square bg-white rounded-[2rem] shadow-inner flex items-center justify-center p-8 overflow-hidden border border-gray-50 mb-8">
                                <img v-if="business.logo" :src="business.logo" class="max-w-full max-h-full object-contain">
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-indigo-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>

                            <div v-if="business.subscriptions?.[0]?.plan" class="mb-8">
                                <span :class="{
                                    'bg-amber-400 text-white shadow-amber-200': business.subscriptions[0].plan.name === 'Elite',
                                    'bg-indigo-600 text-white shadow-indigo-200': business.subscriptions[0].plan.name === 'Premium'
                                }" class="px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-xl flex items-center">
                                    Socio {{ business.subscriptions[0].plan.name }}
                                </span>
                            </div>

                            <div class="w-full space-y-6 pt-4 border-t border-gray-50">
                                <div class="flex items-center">
                                    <div class="bg-indigo-50 p-3 rounded-2xl mr-4 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Categoría</p>
                                        <p class="font-black text-gray-900 leading-none">{{ business.category }}</p>
                                    </div>
                                </div>
                                <div v-if="business.email" class="flex items-center">
                                    <div class="bg-indigo-50 p-3 rounded-2xl mr-4 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">E-mail</p>
                                        <p class="font-black text-gray-900 leading-none truncate">{{ business.email }}</p>
                                    </div>
                                </div>
                                <div v-if="business.website" class="flex items-center">
                                    <div class="bg-indigo-50 p-3 rounded-2xl mr-4 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Sitio Web</p>
                                        <a :href="business.website" target="_blank" class="font-black text-indigo-600 hover:text-indigo-700 leading-none">Visitar portal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Content & Location -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-[3rem] p-10 md:p-14 shadow-sm border border-gray-100 relative overflow-hidden">
                            <!-- Premium Background Detail -->
                            <div v-if="business.subscriptions?.[0]?.plan?.name === 'Elite'" class="absolute right-0 top-0 w-32 h-32 bg-amber-500/5 blur-3xl rounded-full translate-x-1/2 -translate-y-1/2"></div>
                            
                            <div class="flex justify-between items-start mb-10 relative z-10">
                                <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter leading-tight">{{ business.name }}</h1>
                                <button class="p-4 bg-gray-50 rounded-2xl text-gray-400 hover:text-rose-500 hover:bg-rose-50 transition shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="prose prose-indigo max-w-none mb-14 relative z-10">
                                <h3 class="text-xl font-black text-gray-900 mb-6 uppercase tracking-tight">Sobre Nosotros</h3>
                                <p class="text-gray-600 text-lg leading-relaxed font-medium whitespace-pre-wrap">{{ business.description }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                                <div class="bg-gray-50 rounded-[2rem] p-8 border border-gray-100 flex flex-col h-full">
                                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Ubicación física</h4>
                                    <div class="flex items-start">
                                        <div class="p-3 bg-white rounded-xl mr-4 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-gray-900 font-bold leading-relaxed">{{ business.address }}</p>
                                    </div>
                                    <div class="mt-6 flex-grow bg-indigo-100/30 rounded-2xl border border-indigo-100/50 flex flex-col items-center justify-center p-6 text-center space-y-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Mapa Interactivo próximamente</p>
                                    </div>
                                </div>

                                <div class="bg-gray-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-indigo-100 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-xs font-black text-white/40 uppercase tracking-[0.2em] mb-8">Contacto Inmediato</h3>
                                        <p class="text-white/60 text-xs font-medium mb-8 leading-relaxed">Ponte en contacto para agendar una cita o preguntar sobre sus servicios.</p>
                                    </div>
                                    <div class="space-y-4">
                                        <a v-if="business.phone" :href="`tel:${business.phone}`" class="flex items-center justify-center w-full py-5 bg-white text-gray-900 rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-gray-100 transition transform active:scale-95">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            Llamar directo
                                        </a>
                                        <button class="flex items-center justify-center w-full py-5 bg-indigo-600 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition transform active:scale-95 shadow-xl shadow-indigo-900/40">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                            </svg>
                                            Enviar Mensaje
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    business: Object,
    auth: Object,
});

const Layout = props.auth?.user ? AuthenticatedLayout : GuestLayout;
</script>
</template>
