<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({ audits: Object });

const getEventColor = (event) => {
    const map = { created: 'bg-green-100 text-green-700', updated: 'bg-indigo-100 text-indigo-700', deleted: 'bg-red-100 text-red-700', approved: 'bg-teal-100 text-teal-700', rejected: 'bg-rose-100 text-rose-700', blocked: 'bg-gray-100 text-gray-700' };
    return map[event] || 'bg-gray-100 text-gray-700';
};
</script>

<template>
    <Head title="Auditoría" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Registro de Auditoría</h2>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-black text-gray-900">Historial de acciones — {{ audits.total }} eventos</h3>
                    </div>
                    
                    <div v-if="audits.data.length === 0" class="p-16 text-center">
                        <p class="text-gray-500 font-medium">Aún no hay registros de auditoría.</p>
                    </div>
                    
                    <div v-else class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-6 py-4">Fecha</th>
                                    <th class="px-6 py-4">Usuario (Admin)</th>
                                    <th class="px-6 py-4">Evento</th>
                                    <th class="px-6 py-4">Objetivo</th>
                                    <th class="px-6 py-4">IP</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="audit in audits.data" :key="audit.id" class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4 text-xs font-bold text-gray-500">{{ new Date(audit.created_at).toLocaleString() }}</td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900">{{ audit.user?.name || 'Sistema' }}</p>
                                        <p class="text-[10px] text-gray-400">{{ audit.user?.email }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest" :class="getEventColor(audit.event)">{{ audit.event }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-700 text-xs truncate max-w-[200px]" :title="audit.auditable_type">{{ audit.auditable_type.split('\\').pop() }} #{{ audit.auditable_id }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-[10px] text-gray-400">{{ audit.ip_address || '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="audits.last_page > 1" class="p-6 flex gap-2">
                        <Link v-for="link in audits.links" :key="link.label" :href="link.url || '#'"
                              class="px-4 py-2 rounded-xl text-sm font-bold transition"
                              :class="link.active ? 'bg-indigo-600 text-white' : 'bg-gray-50 text-gray-600 border border-gray-100'"
                              v-html="link.label" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
