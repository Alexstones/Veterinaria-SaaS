<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({ subscriptions: Object });

const statusColor = (status) => {
    const map = { active: 'bg-green-100 text-green-700', expired: 'bg-gray-100 text-gray-500', cancelled: 'bg-red-100 text-red-600' };
    return map[status] || 'bg-gray-100 text-gray-500';
};
</script>

<template>
    <Head title="Suscripciones" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Suscripciones y Pagos</h2>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-black text-gray-900">Todas las suscripciones — {{ subscriptions.total }} total</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-6 py-4">Negocio</th>
                                    <th class="px-6 py-4">Plan</th>
                                    <th class="px-6 py-4">Estado</th>
                                    <th class="px-6 py-4">Inicio</th>
                                    <th class="px-6 py-4">Vence</th>
                                    <th class="px-6 py-4">Monto</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="sub in subscriptions.data" :key="sub.id" class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ sub.business?.name || '—' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-[10px] font-black uppercase">{{ sub.plan?.name || '—' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase" :class="statusColor(sub.status)">{{ sub.status }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ new Date(sub.starts_at).toLocaleDateString() }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ new Date(sub.ends_at).toLocaleDateString() }}</td>
                                    <td class="px-6 py-4 font-black text-gray-900">${{ sub.plan?.price || 0 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="subscriptions.last_page > 1" class="p-6 flex gap-2">
                        <Link v-for="link in subscriptions.links" :key="link.label" :href="link.url || '#'"
                              class="px-4 py-2 rounded-xl text-sm font-bold transition"
                              :class="link.active ? 'bg-indigo-600 text-white' : 'bg-gray-50 text-gray-600 border border-gray-100'"
                              v-html="link.label" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
