<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    business: Object,
});

const form = useForm({
    name: props.business.name,
    category: props.business.category,
    description: props.business.description,
    address: props.business.address,
    phone: props.business.phone,
    whatsapp: props.business.whatsapp,
    work_hours: props.business.work_hours || '',
    logo: null,
});

const imagePreview = ref(props.business.logo_url);

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.logo = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    // Usamos _method put en post porque multipart/form-data necesita esto en Laravel a veces para archivos
    form.post(route('businesses.update', props.business.id), {
        onSuccess: () => {},
    });
};
</script>

<template>
    <Head title="Editar Negocio" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('businesses.show', business.id)" class="p-2 bg-white rounded-xl shadow-sm hover:shadow-md transition text-gray-400 hover:text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </Link>
                <h2 class="font-black text-2xl text-gray-900 leading-tight uppercase tracking-tight">Editar Negocio</h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden p-8 md:p-14 relative">
                    <form @submit.prevent="submit" class="space-y-8 relative z-10">
                        <!-- Logo Upload -->
                        <div class="flex flex-col items-center">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-indigo-50 border-4 border-white shadow-xl mb-4 relative group">
                                <img v-if="imagePreview" :src="imagePreview" class="w-full h-full object-cover">
                                <div v-else class="w-full h-full flex items-center justify-center">
                                    <span class="text-4xl text-indigo-200">🏢</span>
                                </div>
                                <div class="absolute inset-0 bg-black/50 items-center justify-center hidden group-hover:flex transition cursor-pointer" @click="$refs.logoInput.click()">
                                    <span class="text-white text-xs font-bold uppercase tracking-widest">Cambiar</span>
                                </div>
                            </div>
                            <input type="file" ref="logoInput" @change="handleImageChange" class="hidden" accept="image/*">
                            <InputError :message="form.errors.logo" />
                        </div>

                        <!-- Basic Info -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="name" value="Nombre del negocio" />
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="category" value="Categoría" />
                                <select id="category" v-model="form.category" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="Veterinaria">Veterinaria</option>
                                    <option value="Estética">Estética/Baño</option>
                                    <option value="Alimento">Alimento/Accesorios</option>
                                    <option value="Entrenamiento">Entrenamiento</option>
                                    <option value="Guardería">Guardería</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.category" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="description" value="Descripción detallada" />
                            <textarea id="description" v-model="form.description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <!-- Contact & Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <InputLabel for="address" value="Dirección física" />
                                <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" required />
                                <InputError class="mt-2" :message="form.errors.address" />
                            </div>
                            <div>
                                <InputLabel for="phone" value="Teléfono principal" />
                                <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" required />
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>
                            <div>
                                <InputLabel for="whatsapp" value="WhatsApp (opcional)" />
                                <TextInput id="whatsapp" type="text" class="mt-1 block w-full" v-model="form.whatsapp" />
                                <InputError class="mt-2" :message="form.errors.whatsapp" />
                            </div>
                            <div class="md:col-span-2">
                                <InputLabel for="work_hours" value="Horarios de atención" />
                                <TextInput id="work_hours" type="text" class="mt-1 block w-full" v-model="form.work_hours" placeholder="Ej: Lunes a Viernes de 9am a 6pm" />
                                <InputError class="mt-2" :message="form.errors.work_hours" />
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex items-center justify-end">
                            <PrimaryButton class="px-8 py-4 bg-indigo-600 rounded-[1.5rem] font-black uppercase tracking-widest" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Guardar Cambios
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
