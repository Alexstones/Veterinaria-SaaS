<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    pets: Object,
});

const approve = (id) => {
    router.post(route('admin.pets.approve', id));
};

const reject = (id) => {
    router.post(route('admin.pets.reject', id));
};
</script>

<template>
    <Head title="Moderación de Mascotas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">Moderación de Mascotas</h2>
                <span class="bg-indigo-100 text-indigo-700 px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest">
                    {{ pets.total }} total
                </span>
            </div>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Mascota</th>
                                    <th class="px-6 py-4">Usuario</th>
                                    <th class="px-6 py-4">Ubicación</th>
                                    <th class="px-6 py-4 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="pet in pets.data" :key="pet.id" class="hover:bg-indigo-50/20 transition">
                                    <td class="px-6 py-4">
                                        <span :class="{
                                            'bg-green-100 text-green-700': pet.status === 'active',
                                            'bg-amber-100 text-amber-700': pet.status === 'pending',
                                            'bg-red-100 text-red-700': pet.status === 'rejected'
                                        }" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter">
                                            {{ pet.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-indigo-100 rounded-xl mr-3"></div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-sm">{{ pet.name || 'Sin Nombre' }}</p>
                                                <p class="text-[10px] text-gray-400 uppercase font-black">{{ pet.species }} - {{ pet.type }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-gray-700">{{ pet.user.name }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-xs text-gray-500">{{ pet.location }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button v-if="pet.status !== 'active'" @click="approve(pet.id)" class="text-[10px] font-black uppercase px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-lg shadow-green-100">
                                            Aprobar
                                        </button>
                                        <button v-if="pet.status !== 'rejected'" @click="reject(pet.id)" class="text-[10px] font-black uppercase px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-lg shadow-red-100">
                                            Rechazar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination could go here -->
            </div>
        </div>
    </AuthenticatedLayout>
</template>
