<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    plan: Object,
    businesses: Array,
});

const form = useForm({
    business_id: props.businesses.length > 0 ? props.businesses[0].id : '',
    plan_id: props.plan.id,
});

const submit = () => {
    form.post(route('subscriptions.store'));
};
</script>

<template>
    <Head title="Confirmar Suscripción" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('plans.index')" class="p-2 bg-white rounded-xl shadow-sm hover:shadow-md transition text-gray-400 hover:text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase tracking-tight">Activar Suscripción</h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-12 text-center">
                    <span class="px-4 py-1.5 bg-indigo-600 text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-4 inline-block shadow-lg shadow-indigo-100">
                        Paso Final de Activación
                    </span>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tighter">Estás a un paso de potenciar tu negocio</h1>
                    <p class="text-gray-500 mt-4 font-medium max-w-lg mx-auto leading-relaxed">Confirma los detalles de tu plan y selecciona el establecimiento que deseas destacar en nuestra plataforma.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                    <!-- Left: Plan Summary -->
                    <div class="space-y-8">
                        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-100 relative overflow-hidden">
                            <!-- Background Accent -->
                            <div class="absolute right-0 top-0 w-32 h-32 bg-indigo-50/50 blur-3xl rounded-full translate-x-1/2 -translate-y-1/2"></div>
                            
                            <h3 class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-8">Resumen del Plan</h3>
                            
                            <div class="mb-10">
                                <h2 class="text-3xl font-black text-gray-900 tracking-tighter mb-2">{{ plan.name }}</h2>
                                <div class="flex items-baseline">
                                    <span class="text-4xl font-black text-indigo-600">${{ plan.price }}</span>
                                    <span class="text-gray-400 font-black uppercase text-[10px] tracking-widest ml-2">IVA Incluido / Mes</span>
                                </div>
                            </div>

                            <div class="space-y-6 pt-10 border-t border-gray-50">
                                <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">Lo que obtienes:</h4>
                                <ul class="space-y-4">
                                    <li v-for="feature in plan.features" :key="feature" class="flex items-start text-gray-600">
                                        <div class="p-1 bg-indigo-50 rounded-full mr-4 mt-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-bold leading-tight">{{ feature }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="bg-indigo-900 rounded-[2.5rem] p-10 text-white shadow-2xl shadow-indigo-100 flex items-center">
                            <div class="bg-white/10 p-4 rounded-2xl mr-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-black text-sm uppercase tracking-widest leading-none mb-1">Satisfacción Garantizada</h4>
                                <p class="text-indigo-200 text-xs font-medium">Cancela tu suscripción en cualquier momento sin penalizaciones.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Checkout Form -->
                    <div class="bg-white rounded-[3rem] p-10 md:p-14 shadow-sm border border-gray-100">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-10">Configuración Final</h3>
                        
                        <form @submit.prevent="submit" class="space-y-10">
                            <div v-if="businesses.length > 0">
                                <InputLabel for="business_id" value="Sincronizar con Negocio" class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4 block" />
                                <div class="relative group">
                                    <select id="business_id" v-model="form.business_id" class="w-full h-20 pl-6 pr-12 bg-gray-50 border-gray-100 focus:bg-white rounded-[1.5rem] font-black text-gray-900 shadow-sm focus:border-indigo-600 focus:ring-0 transition-all appearance-none cursor-pointer">
                                        <option v-for="business in businesses" :key="business.id" :value="business.id">
                                            {{ business.name }}
                                        </option>
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <InputError class="mt-4" :message="form.errors.business_id" />
                            </div>
                            <div v-else class="bg-rose-50 border border-rose-100 p-8 rounded-[2rem] text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-rose-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <p class="text-rose-900 font-black tracking-tight mb-4">No tienes negocios registrados aún.</p>
                                <Link :href="route('businesses.create')" class="inline-flex items-center justify-center px-8 py-4 bg-rose-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-700 transition shadow-xl shadow-rose-200">
                                    Registrar Negocio Primero
                                </Link>
                            </div>

                            <div class="bg-indigo-50/50 rounded-[2rem] p-8 border border-indigo-100/50">
                                <div class="flex justify-between items-center mb-4">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total a Facturar Hoy</p>
                                    <p class="text-3xl font-black text-gray-900">${{ plan.price }} MXN</p>
                                </div>
                                <div class="flex items-center text-[10px] font-bold text-indigo-500 uppercase tracking-widest">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Renovación Automática el {{ new Date(new Date().setMonth(new Date().getMonth() + 1)).toLocaleDateString() }}
                                </div>
                            </div>

                            <div class="pt-6">
                                <PrimaryButton class="w-full justify-center h-20 bg-indigo-600 text-white rounded-[1.5rem] font-black text-sm uppercase tracking-widest hover:bg-indigo-700 shadow-2xl shadow-indigo-100 transition transform active:scale-95 disabled:opacity-30" :disabled="form.processing || businesses.length === 0">
                                    <span v-if="form.processing">Procesando Pago...</span>
                                    <span v-else>Confirmar y Activar Plan</span>
                                </PrimaryButton>
                                
                                <div class="mt-8 flex items-center justify-center space-x-6 text-gray-300">
                                    <svg class="h-8 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                                    <svg class="h-8 w-12" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8h16v10z"/></svg>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Pago 100% Seguro</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
