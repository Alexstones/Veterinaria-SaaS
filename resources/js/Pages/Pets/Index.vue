<template>
    <Head title="Mascotas" />

    <component :is="$page.props.auth.user ? AuthenticatedLayout : GuestLayout">
        <template #header v-if="$page.props.auth.user">
            <div class="flex justify-between items-center">
                <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase tracking-tight">Comunidad de Mascotas</h2>
                <Link :href="route('pets.create')" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-100 transform active:scale-95">
                    Publicar Mascota
                </Link>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <!-- Hero section for guests -->
                <div v-if="!$page.props.auth.user" class="mb-12 text-center">
                    <h1 class="text-4xl md:text-6xl font-black text-gray-900 mb-4 tracking-tighter">Mascotas en <span class="text-indigo-600">Cuauhtémoc</span></h1>
                    <p class="text-gray-500 text-lg max-w-2xl mx-auto font-medium">Ayúdanos a encontrarles un hogar o a regresar a casa. La plataforma más segura para nuestros amigos peludos.</p>
                </div>

                <!-- Filters -->
                <div class="mb-10 flex flex-wrap gap-3 justify-center md:justify-start">
                    <Link :href="route('pets.index')" :class="!$page.props.filters?.type ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-sm transition">Todos</Link>
                    <Link :href="route('pets.index', { type: 'adopcion' })" :class="$page.props.filters?.type === 'adopcion' ? 'bg-rose-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-sm transition">Adopción</Link>
                    <Link :href="route('pets.index', { type: 'perdido' })" :class="$page.props.filters?.type === 'perdido' ? 'bg-amber-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-sm transition">Perdidos</Link>
                    <Link :href="route('pets.index', { type: 'encontrado' })" :class="$page.props.filters?.type === 'encontrado' ? 'bg-teal-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-100'" class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-sm transition">Encontrados</Link>
                </div>

                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    <div v-for="pet in pets.data" :key="pet.id" class="group bg-white rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 flex flex-col h-full transform hover:-translate-y-2">
                        <!-- Image Container -->
                        <div class="relative h-64 overflow-hidden">
                            <img v-if="pet.image_url" :src="pet.image_url" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            <div v-else class="w-full h-full bg-indigo-50 flex items-center justify-center text-indigo-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <!-- Badges -->
                            <div class="absolute top-4 left-4">
                                <span :class="{
                                    'bg-rose-500/90': pet.type === 'adopcion',
                                    'bg-amber-500/90': pet.type === 'perdido',
                                    'bg-teal-500/90': pet.type === 'encontrado'
                                }" class="backdrop-blur-md text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg">
                                    {{ pet.type }}
                                </span>
                            </div>
                            <div v-if="pet.is_featured" class="absolute top-4 right-4">
                                <span class="bg-indigo-600 text-white p-2 rounded-full shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-black text-gray-900 group-hover:text-indigo-600 transition">{{ pet.species }}</h3>
                                <div class="flex items-center text-[10px] font-black uppercase tracking-widest text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ new Date(pet.created_at).toLocaleDateString(undefined, { day: 'numeric', month: 'short' }) }}
                                </div>
                            </div>

                            <p class="text-gray-500 text-sm font-medium line-clamp-2 mb-6 leading-relaxed">
                                {{ pet.description }}
                            </p>

                            <div class="mt-auto space-y-4">
                                <div class="flex items-center text-xs font-bold text-gray-700 bg-gray-50 p-3 rounded-2xl border border-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate">{{ pet.location }}</span>
                                </div>

                                <Link :href="route('pets.show', pet.id)" class="block w-full text-center py-4 bg-gray-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition shadow-lg shadow-gray-200 hover:shadow-indigo-200 group-hover:shadow-indigo-100">
                                    Ver Detalles
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div v-if="pets.data.length === 0" class="text-center py-20 bg-white rounded-[3rem] shadow-sm border border-gray-100">
                    <div class="p-10 bg-indigo-50 rounded-full inline-block mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 12h.01M12 12c2.21 0 4 1.79 4 4v2H8v-2c0-2.21 1.79-4 4-4z" />
                        </svg>
                    </div>
                    <p class="text-gray-400 text-xl font-bold tracking-tight">No hay mascotas registradas aquí todavía.</p>
                    <p class="text-gray-400 text-sm mt-2">¡Sé el primero en publicar una!</p>
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
    pets: Object,
    filters: Object,
});
</script>
