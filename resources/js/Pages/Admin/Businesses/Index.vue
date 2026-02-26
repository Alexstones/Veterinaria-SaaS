<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';

const props = defineProps({
    businesses: Object,
});

const approve = (id) => {
    router.post(route('admin.businesses.approve', id));
};

const reject = (id) => {
    router.post(route('admin.businesses.reject', id));
};
</script>

<template>
    <Head title="Moderación de Negocios" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">Auditoría de Negocios</h2>
                <span class="bg-amber-100 text-amber-700 px-4 py-1 rounded-full text-xs font-black uppercase tracking-widest">
                    {{ businesses.total }} registros
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
                                    <th class="px-6 py-4">Negocio</th>
                                    <th class="px-6 py-4">Usuario Responsable</th>
                                    <th class="px-6 py-4">Suscripción</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Acciones de Control</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="biz in businesses.data" :key="biz.id" class="hover:bg-amber-50/20 transition">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="font-bold text-gray-900 text-sm">{{ biz.name }}</p>
                                            <p class="text-[10px] text-indigo-500 uppercase font-black tracking-tighter">{{ biz.category }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-700">{{ biz.user.name }}</span>
                                            <span class="text-[10px] text-gray-400 font-medium">{{ biz.user.email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-indigo-50 text-indigo-600 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest">
                                            Premium (Simulado)
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span :class="{
                                            'bg-green-100 text-green-700': biz.status === 'active',
                                            'bg-amber-100 text-amber-700': biz.status === 'pending',
                                            'bg-red-100 text-red-700': biz.status === 'rejected'
                                        }" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm border border-white/50">
                                            {{ biz.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button v-if="biz.status !== 'active'" @click="approve(biz.id)" class="text-[10px] font-black uppercase px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                                            Aprobar Registro
                                        </button>
                                        <button v-if="biz.status !== 'rejected'" @click="reject(biz.id)" class="text-[10px] font-black uppercase px-4 py-2 bg-white text-red-600 border border-red-200 rounded-xl hover:bg-red-50 transition">
                                            Rechazar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
