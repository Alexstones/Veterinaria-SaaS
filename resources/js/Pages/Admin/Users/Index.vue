<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({ users: Object });

const blockForm = useForm({});
</script>

<template>
    <Head title="Gestión de Usuarios" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">Usuarios</h2>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8 border-b border-gray-50">
                        <h3 class="text-lg font-black text-gray-900">Todos los usuarios registrados — {{ users.total }} total</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-6 py-4">Usuario</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Rol</th>
                                    <th class="px-6 py-4">Estado</th>
                                    <th class="px-6 py-4">Registrado</th>
                                    <th class="px-6 py-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4">
                                        <p class="font-bold text-gray-900">{{ user.name }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ user.email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-[10px] font-black uppercase">{{ user.role || 'user' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase"
                                              :class="user.status === 'blocked' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'">
                                            {{ user.status === 'blocked' ? 'Bloqueado' : 'Activo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ new Date(user.created_at).toLocaleDateString() }}</td>
                                    <td class="px-6 py-4">
                                        <form v-if="user.status !== 'blocked'" @submit.prevent="blockForm.post(route('admin.users.block', user.id))">
                                            <button type="submit" class="text-xs font-black text-red-600 hover:underline uppercase">Bloquear</button>
                                        </form>
                                        <form v-else @submit.prevent="blockForm.post(route('admin.users.unblock', user.id))">
                                            <button type="submit" class="text-xs font-black text-green-600 hover:underline uppercase">Reactivar</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div v-if="users.last_page > 1" class="p-6 flex gap-2">
                        <Link v-for="link in users.links" :key="link.label" :href="link.url || '#'"
                              class="px-4 py-2 rounded-xl text-sm font-bold transition"
                              :class="link.active ? 'bg-indigo-600 text-white' : 'bg-gray-50 text-gray-600 border border-gray-100'"
                              v-html="link.label" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
