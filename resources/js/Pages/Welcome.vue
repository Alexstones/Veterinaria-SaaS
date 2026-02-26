<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    latestPets: {
        type: Array,
        default: () => [],
    },
    featuredBusinesses: {
        type: Array,
        default: () => [],
    },
});

const getPetTypeConfig = (type) => {
    switch (type) {
        case 'adopcion': return { label: 'Adopción', color: 'bg-rose-500/90' };
        case 'perdido': return { label: 'Perdido', color: 'bg-amber-500/90' };
        case 'encontrado': return { label: 'Encontrado', color: 'bg-teal-500/90' };
        default: return { label: type, color: 'bg-gray-500/90' };
    }
};

const getStatusColor = (status) => {
    return status === 'active' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700';
};
</script>

<template>
    <Head title="SaaS Mascotas - Cuauhtémoc, Chih." />

    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <span class="text-3xl">🐾</span>
                    <span class="font-black text-2xl tracking-tighter text-indigo-900 uppercase">Pet<span class="text-rose-500">SaaS</span></span>
                </div>
                
                <div class="hidden md:flex space-x-8 items-center">
                    <Link :href="route('pets.index')" class="text-sm font-black text-gray-500 hover:text-indigo-600 uppercase tracking-widest transition">Mascotas</Link>
                    <Link :href="route('businesses.index')" class="text-sm font-black text-gray-500 hover:text-indigo-600 uppercase tracking-widest transition">Directorio</Link>
                    <Link :href="route('plans.index')" class="text-sm font-black text-gray-500 hover:text-indigo-600 uppercase tracking-widest transition">Planes</Link>
                    
                    <div class="h-6 w-px bg-gray-200"></div>

                    <div v-if="$page.props.auth.user">
                        <Link :href="route('dashboard')" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/30">
                            Mi Panel
                        </Link>
                    </div>
                    <template v-else>
                        <Link :href="route('login')" class="text-sm font-black text-gray-500 hover:text-indigo-600 uppercase tracking-widest transition">Ingresar</Link>
                        <Link v-if="canRegister" :href="route('register')" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/30">
                            Regístrate
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen bg-gray-50/50">
        
        <!-- Hero Section -->
        <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="absolute inset-0 bg-indigo-50/50 -skew-y-3 origin-top-left"></div>
            <div class="absolute top-1/4 right-0 w-96 h-96 bg-rose-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-1/3 left-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-5xl md:text-7xl font-black text-gray-900 tracking-tighter mb-6 leading-tight">
                    El hub central para<br /> <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-rose-500">amantes de mascotas</span>
                </h1>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto font-medium mb-10">
                    Adopta, reporta mascotas perdidas y encuentra los mejores servicios en Cuauhtémoc, TODO en un solo lugar.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <Link :href="route('pets.index', { type: 'adopcion' })" class="px-8 py-5 bg-rose-500 text-white rounded-[2rem] font-black text-sm uppercase tracking-widest hover:bg-rose-600 transition shadow-xl shadow-rose-500/30 hover:-translate-y-1">
                        🐶 Busco Adoptar
                    </Link>
                    <Link :href="route('businesses.index')" class="px-8 py-5 bg-white text-indigo-900 rounded-[2rem] font-black text-sm uppercase tracking-widest hover:bg-gray-50 border-2 border-transparent transition shadow-xl shadow-gray-200/50 hover:border-indigo-100 hover:-translate-y-1">
                        🏪 Directorio Local
                    </Link>
                </div>
            </div>
        </div>

        <!-- Latest Pets Section -->
        <div class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 border-b border-gray-100 pb-16">
                    <h2 class="text-sm font-black text-indigo-600 tracking-[0.3em] uppercase mb-4 title-decoration">Últimas Publicaciones</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter mb-6">Mascotas buscando ayuda</h3>
                    <p class="text-gray-500 max-w-2xl mx-auto text-lg font-medium">Revisa las últimas mascotas publicadas por nuestra comunidad para adopción o reportadas como perdidas.</p>
                </div>

                <div v-if="latestPets.length === 0" class="text-center py-12">
                    <p class="text-gray-400 font-medium">Todavía no hay mascotas publicadas.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <Link v-for="pet in latestPets" :key="pet.id" :href="route('pets.show', pet.id)" class="group bg-white rounded-[2rem] overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl transition duration-500 flex flex-col hover:-translate-y-2 relative">
                        <!-- Image -->
                        <div class="aspect-[4/3] bg-indigo-50 relative overflow-hidden">
                            <img v-if="pet.image_url" :src="pet.image_url" alt="" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            <div v-else class="w-full h-full flex justify-center items-center">
                                <span class="text-6xl text-indigo-200 group-hover:scale-125 transition duration-700">🐾</span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex gap-2">
                                <span :class="getPetTypeConfig(pet.type).color" class="backdrop-blur-md text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">
                                    {{ getPetTypeConfig(pet.type).label }}
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h2 class="text-2xl font-black text-gray-900 leading-tight group-hover:text-indigo-600 transition">{{ pet.name || 'Sin nombre' }}</h2>
                                    <p class="text-sm font-bold text-gray-500 uppercase tracking-widest mt-1">{{ pet.species }}</p>
                                </div>
                                <div class="bg-gray-50 p-2 rounded-xl text-center min-w-[60px]">
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Publicado</p>
                                    <p class="text-sm font-black text-gray-700 mt-0.5">{{ new Date(pet.created_at).toLocaleDateString(undefined, { day: 'numeric', month: 'short' }) }}</p>
                                </div>
                            </div>

                            <p class="text-gray-500 text-sm font-medium line-clamp-2 mb-6">{{ pet.description }}</p>

                            <div class="mt-auto pt-6 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <span class="text-xs font-black uppercase tracking-widest">{{ pet.location || 'No especificada' }}</span>
                                </div>
                                <span class="bg-indigo-50 text-indigo-600 p-2 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>

                <div class="mt-16 text-center">
                    <Link :href="route('pets.index')" class="inline-flex items-center px-8 py-4 bg-indigo-50 text-indigo-600 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-100 hover:text-indigo-700 transition">
                        Ver todas las mascotas
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Featured Businesses Section -->
        <div class="py-24 bg-gray-900 border-t border-gray-800 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-rose-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
                    <div class="max-w-2xl text-left">
                        <h2 class="text-sm font-black text-rose-500 tracking-[0.3em] uppercase mb-4">Negocios Locales</h2>
                        <h3 class="text-4xl md:text-5xl font-black text-white tracking-tighter">Directorio Premium</h3>
                        <p class="text-gray-400 mt-4 text-lg font-medium">Encuentra los mejores productos y servicios de marcas confiables que apoyan a nuestra comunidad.</p>
                    </div>
                    <div class="mt-8 md:mt-0 flex-shrink-0">
                        <Link :href="route('businesses.index')" class="inline-flex items-center px-8 py-5 bg-white text-gray-900 rounded-[2rem] font-black text-sm uppercase tracking-widest hover:bg-gray-100 transition shadow-xl hover:-translate-y-1">
                            Ver Directorio
                        </Link>
                    </div>
                </div>

                <div v-if="featuredBusinesses.length === 0" class="text-center py-12">
                    <p class="text-gray-500 font-medium">Aún no hay negocios destacados.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <Link v-for="business in featuredBusinesses" :key="business.id" :href="route('businesses.show', business.id)" class="group relative bg-gray-800 rounded-[2rem] p-8 hover:bg-gray-800/80 transition shadow-2xl overflow-hidden border border-gray-700/50 flex flex-col items-center text-center">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-rose-500/10 opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        
                        <!-- Logo -->
                        <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-700 shadow-xl border-4 border-gray-800 mb-6 group-hover:scale-105 transition duration-500 relative z-10">
                            <img v-if="business.logo_url" :src="business.logo_url" alt="" class="w-full h-full object-cover">
                            <div v-else class="w-full h-full flex items-center justify-center">
                                <span class="text-4xl text-gray-500">🏢</span>
                            </div>
                        </div>
                        
                        <div class="relative z-10">
                            <span v-if="business.plan?.name === 'Premium' || business.plan?.name === 'Elite'" class="inline-flex items-center px-3 py-1 bg-rose-500/20 text-rose-400 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 border border-rose-500/20">
                                🌟 Destacado
                            </span>
                            <h3 class="text-xl font-black text-white mb-2">{{ business.name }}</h3>
                            <span class="inline-block px-3 py-1 bg-gray-900 text-gray-300 rounded-xl text-[10px] font-black uppercase tracking-widest mb-4">{{ business.category }}</span>
                            <p class="text-gray-400 text-sm font-medium line-clamp-3 mb-6">{{ business.description }}</p>
                        </div>

                        <div class="mt-auto w-full pt-6 border-t border-gray-700 relative z-10">
                            <span class="text-xs font-black text-indigo-400 group-hover:text-indigo-300 uppercase tracking-widest flex items-center justify-center transition">
                                Visitar Negocio <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </div>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🐾</span>
                    <span class="font-black text-xl tracking-tighter text-gray-900 uppercase">Pet<span class="text-rose-500">SaaS</span></span>
                </div>
                <div class="text-sm text-gray-500 font-medium">
                    &copy; {{ new Date().getFullYear() }} PetSaaS. Cuauhtémoc, Chihuahua.
                </div>
                <div class="flex gap-4">
                    <Link :href="route('businesses.index')" class="text-xs font-bold text-gray-400 hover:text-indigo-600 uppercase tracking-widest transition">Directorio</Link>
                    <Link :href="route('pets.index')" class="text-xs font-bold text-gray-400 hover:text-rose-500 uppercase tracking-widest transition">Mascotas</Link>
                </div>
            </div>
        </footer>

    </main>
</template>

<style scoped>
/* Animations from plan selection UI */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
</style>
