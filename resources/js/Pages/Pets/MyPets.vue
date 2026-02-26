<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    pets: Object,
});

const statusLabel = (status) => {
    const map = {
        pending: 'Pendiente',
        active: 'Aprobada',
        rejected: 'Rechazada',
        closed: 'Cerrada',
    };
    return map[status] || status;
};

const statusColor = (status) => {
    const map = {
        pending: 'bg-amber-100 text-amber-700',
        active: 'bg-green-100 text-green-700',
        rejected: 'bg-red-100 text-red-700',
        closed: 'bg-gray-100 text-gray-600',
    };
    return map[status] || 'bg-gray-100 text-gray-600';
};

const typeLabel = (type) => {
    const map = { adopcion: 'Adopción', perdido: 'Perdido', encontrado: 'Encontrado' };
    return map[type] || type;
};

const closeForm = useForm({});
const reopenForm = useForm({});

const closePet = (id) => {
    closeForm.post(route('my-pets.close', id));
};
const reopenPet = (id) => {
    reopenForm.post(route('my-pets.reopen', id));
};
</script>

<template>
    <Head title="Mis Publicaciones" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Mis Publicaciones</h2>
                <Link :href="route('pets.create')" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg">
                    + Nueva Publicación
                </Link>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

                <div v-if="pets.data.length === 0" class="bg-white rounded-[3rem] p-20 text-center shadow-sm border border-gray-100">
                    <div class="text-6xl mb-6">🐾</div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4">Todavía no tienes publicaciones</h3>
                    <p class="text-gray-500 mb-8 font-medium">Publica tu primera mascota en adopción o reporta un perdido.</p>
                    <Link :href="route('pets.create')" class="px-10 py-5 bg-indigo-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-100">
                        Crear Primera Publicación
                    </Link>
                </div>

                <div v-else class="space-y-4">
                    <div v-for="pet in pets.data" :key="pet.id"
                         class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-md transition">
                        
                        <!-- Image -->
                        <div class="w-20 h-20 rounded-2xl overflow-hidden shrink-0 bg-indigo-50 flex items-center justify-center">
                            <img v-if="pet.image_url" :src="pet.image_url" class="w-full h-full object-cover" />
                            <span v-else class="text-3xl">🐾</span>
                        </div>

                        <!-- Info -->
                        <div class="flex-grow min-w-0">
                            <div class="flex items-center gap-3 mb-1 flex-wrap">
                                <h3 class="font-black text-gray-900 text-lg leading-tight">
                                    {{ pet.name || 'Sin nombre' }} – {{ pet.species }}
                                </h3>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider" :class="statusColor(pet.status)">
                                    {{ statusLabel(pet.status) }}
                                </span>
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                                    {{ typeLabel(pet.type) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 font-medium truncate">{{ pet.description }}</p>
                            <p class="text-xs text-gray-400 mt-1 font-bold uppercase tracking-widest">{{ pet.location }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 shrink-0">
                            <Link :href="route('pets.show', pet.id)" class="text-xs font-black text-indigo-600 hover:underline uppercase tracking-widest">
                                Ver
                            </Link>
                            <button v-if="pet.status === 'active' || pet.status === 'pending'"
                                    @click="closePet(pet.id)"
                                    class="text-xs font-black text-rose-600 hover:underline uppercase tracking-widest">
                                Cerrar
                            </button>
                            <button v-if="pet.status === 'closed' || pet.status === 'rejected'"
                                    @click="reopenPet(pet.id)"
                                    class="text-xs font-black text-green-600 hover:underline uppercase tracking-widest">
                                Reactivar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div v-if="pets.last_page > 1" class="mt-8 flex justify-center gap-2">
                    <Link v-for="link in pets.links" :key="link.label"
                          :href="link.url || '#'"
                          class="px-4 py-2 rounded-xl text-sm font-bold transition"
                          :class="link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-100'"
                          v-html="link.label" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
