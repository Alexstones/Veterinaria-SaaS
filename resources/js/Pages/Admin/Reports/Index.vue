<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({ reports: Object });
const form = useForm({});
</script>

<template>
    <Head title="Reportes" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Gestión de Reportes</h2>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div v-if="reports.data.length === 0" class="bg-white rounded-[3rem] p-16 text-center shadow-sm border border-gray-100">
                    <div class="text-5xl mb-4">✅</div>
                    <h3 class="text-xl font-black text-gray-900">Sin reportes pendientes</h3>
                    <p class="text-gray-500 mt-2">¡Todo limpio por aquí!</p>
                </div>

                <div v-else class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50">
                        <h3 class="text-lg font-black text-gray-900">Reportes — {{ reports.total }} total</h3>
                    </div>
                    <div class="divide-y divide-gray-50">
                        <div v-for="report in reports.data" :key="report.id" class="p-6 flex items-start gap-6 hover:bg-gray-50/50 transition">
                            <div class="flex-grow">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase"
                                          :class="report.status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700'">
                                        {{ report.status === 'pending' ? 'Pendiente' : 'Resuelto' }}
                                    </span>
                                </div>
                                <p class="font-bold text-gray-900">{{ report.reason }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Reportado por: <b>{{ report.user?.name || 'Usuario desconocido' }}</b>
                                </p>
                                <p class="text-xs text-gray-400 mt-1">{{ new Date(report.created_at).toLocaleDateString() }}</p>
                            </div>
                            <div class="flex flex-col gap-2 shrink-0">
                                <form v-if="report.status === 'pending'" @submit.prevent="form.post(route('admin.reports.resolve', report.id))">
                                    <button type="submit" class="text-xs font-black text-green-600 hover:underline uppercase">Resolver</button>
                                </form>
                                <form @submit.prevent="form.delete(route('admin.reports.destroy', report.id))">
                                    <button type="submit" class="text-xs font-black text-red-600 hover:underline uppercase">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
