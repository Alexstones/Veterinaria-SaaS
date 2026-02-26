<template>
    <Head :title="`${pet.name || pet.species} – Mascota`" />

    <component :is="$page.props.auth.user ? AuthenticatedLayout : GuestLayout">
        <template #header v-if="$page.props.auth.user">
            <div class="flex items-center space-x-4">
                <Link :href="route('pets.index')" class="p-2 bg-white rounded-xl shadow-sm hover:shadow-md transition text-gray-400 hover:text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase tracking-tight">Detalles de la Mascota</h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Gallery & Description -->
                    <div class="lg:col-span-2 space-y-8">
                        <div class="bg-white rounded-[3rem] overflow-hidden shadow-sm border border-gray-100">
                            <div class="aspect-video relative overflow-hidden bg-indigo-50">
                                <img v-if="pet.image_url" :src="pet.image_url" class="w-full h-full object-cover">
                                <div v-else class="w-full h-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-indigo-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="absolute top-6 left-6">
                                    <span :class="{
                                        'bg-rose-500/90': pet.type === 'adopcion',
                                        'bg-amber-500/90': pet.type === 'perdido',
                                        'bg-teal-500/90': pet.type === 'encontrado'
                                    }" class="backdrop-blur-md text-white px-6 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-2xl">
                                        {{ pet.type }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-10 md:p-14">
                                <div class="flex justify-between items-start mb-8">
                                    <div>
                                        <h1 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tighter">{{ pet.name || pet.species }}</h1>
                                        <p class="text-gray-500 font-bold mt-1 text-lg" v-if="pet.name">{{ pet.species }}</p>
                                        <p class="text-gray-400 font-bold mt-2 uppercase tracking-widest text-sm">{{ pet.location }}</p>
                                    </div>
                                    <div class="bg-indigo-50 p-4 rounded-3xl text-center min-w-[100px]">
                                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Publicado</p>
                                        <p class="text-lg font-black text-indigo-600 leading-none mt-1">{{ new Date(pet.created_at).toLocaleDateString(undefined, { day: 'numeric', month: 'short' }) }}</p>
                                    </div>
                                </div>
                                <div class="prose prose-indigo max-w-none">
                                    <h3 class="text-xl font-black text-gray-900 mb-4 uppercase tracking-tight">Historia y Detalles</h3>
                                    <p class="text-gray-600 text-lg leading-relaxed whitespace-pre-wrap font-medium">{{ pet.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-8">
                        <!-- Characteristics -->
                        <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-8">Características</h3>
                            <div class="space-y-6">
                                <div class="flex items-center group">
                                    <div class="p-3 bg-rose-50 rounded-2xl mr-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg></div>
                                    <div><p class="text-[10px] font-black text-gray-400 uppercase">Sexo</p><p class="font-black text-gray-900">{{ pet.sex || 'No especificado' }}</p></div>
                                </div>
                                <div class="flex items-center group">
                                    <div class="p-3 bg-amber-50 rounded-2xl mr-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" /></svg></div>
                                    <div><p class="text-[10px] font-black text-gray-400 uppercase">Tamaño</p><p class="font-black text-gray-900">{{ pet.size || 'No especificado' }}</p></div>
                                </div>
                                <div class="flex items-center group">
                                    <div class="p-3 bg-teal-50 rounded-2xl mr-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                                    <div><p class="text-[10px] font-black text-gray-400 uppercase">Edad</p><p class="font-black text-gray-900">{{ pet.age || 'No especificada' }}</p></div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Card -->
                        <div class="bg-gray-900 rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden">
                            <div class="absolute -right-10 -top-10 h-40 w-40 bg-white/5 rounded-full blur-3xl"></div>
                            <h3 class="text-xs font-black text-white/40 uppercase tracking-[0.2em] mb-8 relative z-10">Contacto Directo</h3>
                            <div class="space-y-4 relative z-10">
                                <a :href="`tel:${pet.contact_info?.phone || ''}`" class="flex items-center justify-center w-full py-5 bg-white text-gray-900 rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-gray-100 transition active:scale-95">
                                    🤙 Llamar ahora
                                </a>
                                <a :href="`https://wa.me/${pet.contact_info?.whatsapp || ''}`" target="_blank" class="flex items-center justify-center w-full py-5 bg-green-500 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-green-600 transition active:scale-95">
                                    💬 Enviar WhatsApp
                                </a>
                                <p class="text-[10px] text-center text-white/30 font-medium pt-2">Nunca realices depósitos sin verificar.</p>
                            </div>
                        </div>

                        <!-- Safety Tips -->
                        <div class="bg-indigo-50 border border-indigo-100 rounded-3xl p-8">
                            <p class="text-indigo-900 font-black text-xs uppercase tracking-tight mb-1">⚠️ Consejo de Seguridad</p>
                            <p class="text-indigo-600 text-xs font-medium leading-relaxed">Verifica siempre la identidad del responsable en un lugar público.</p>
                        </div>

                        <!-- Report Button -->
                        <div v-if="$page.props.auth.user" class="text-center">
                            <button @click="showReportModal = true" class="text-xs text-gray-400 hover:text-rose-500 font-bold uppercase tracking-widest transition">
                                🚩 Reportar esta publicación
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Modal -->
        <Teleport to="body">
            <div v-if="showReportModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="showReportModal = false">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
                <div class="relative bg-white rounded-[2.5rem] p-10 max-w-md w-full shadow-2xl">
                    <h3 class="text-xl font-black text-gray-900 mb-2">Reportar Publicación</h3>
                    <p class="text-gray-500 text-sm mb-6 font-medium">Nuestro equipo revisará el reporte en menos de 24 horas.</p>
                    <form @submit.prevent="submitReport">
                        <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Motivo del reporte</label>
                        <textarea v-model="reportForm.reason" rows="4" required
                                  class="w-full border border-gray-200 rounded-2xl p-4 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-rose-500 resize-none"
                                  placeholder="Describe por qué crees que esta publicación es inapropiada..."></textarea>
                        <p v-if="reportForm.errors.reason" class="text-rose-500 text-xs mt-2">{{ reportForm.errors.reason }}</p>
                        <div class="flex gap-4 mt-6">
                            <button type="button" @click="showReportModal = false"
                                    class="flex-1 py-4 bg-gray-100 text-gray-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition">
                                Cancelar
                            </button>
                            <button type="submit" :disabled="reportForm.processing"
                                    class="flex-1 py-4 bg-rose-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-700 transition disabled:opacity-50">
                                Enviar Reporte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
    </component>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ pet: Object });

const showReportModal = ref(false);
const reportForm = useForm({ reason: '' });

const submitReport = () => {
    reportForm.post(route('pets.report', props.pet.id), {
        onSuccess: () => {
            showReportModal.value = false;
            reportForm.reset();
        },
    });
};
</script>
