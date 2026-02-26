<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    category: 'Veterinarias',
    description: '',
    address: '',
    phone: '',
    email: '',
    website: '',
    logo: null,
});

const categories = [
    'Veterinarias',
    'Estética y Baño',
    'Accesorios y Alimento',
    'Entrenamiento',
    'Pensiones',
    'Adopciones Externas',
];

const logoPreview = ref(null);

const handleLogoChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.logo = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            logoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(route('businesses.store'), {
        onFinish: () => {
            form.reset();
            logoPreview.value = null;
        },
    });
};
</script>

<template>
    <Head title="Registrar Negocio" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar Negocio</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                    <div class="p-8 md:p-12">
                        <div class="mb-10">
                            <h3 class="text-2xl font-black text-gray-900 mb-2">Haz crecer tu negocio con nosotros</h3>
                            <p class="text-gray-500">Únete al directorio más grande de Cuauhtémoc especializado en mascotas.</p>
                        </div>

                        <form @submit.prevent="submit" class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <InputLabel for="name" value="Nombre del Negocio" class="font-bold text-gray-700" />
                                    <TextInput id="name" type="text" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500 rounded-xl" v-model="form.name" required placeholder="Ej. Veterinaria El Cachorro" />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div class="space-y-2">
                                    <InputLabel for="category" value="Categoría" class="font-bold text-gray-700" />
                                    <select id="category" v-model="form.category" class="mt-1 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition">
                                        <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.category" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                                <div class="space-y-2">
                                    <InputLabel for="description" value="Descripción del Negocio" class="font-bold text-gray-700" />
                                    <textarea id="description" class="mt-1 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition" rows="5" v-model="form.description" required placeholder="Cuéntanos sobre tus servicios, horarios y qué te hace especial..."></textarea>
                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>

                                <div class="space-y-2">
                                    <InputLabel value="Logo del Negocio" class="font-bold text-gray-700" />
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-2xl hover:border-indigo-400 transition cursor-pointer relative overflow-hidden group">
                                        <div v-if="!logoPreview" class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Sube un logo</span>
                                                    <input id="logo" name="logo" type="file" class="sr-only" @change="handleLogoChange" accept="image/*">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG hasta 2MB</p>
                                        </div>
                                        <div v-else class="w-full h-32 relative">
                                            <img :src="logoPreview" class="w-full h-full object-contain rounded-xl">
                                            <button @click.prevent="logoPreview = null; form.logo = null" class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full shadow-lg hover:bg-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.logo" />
                                </div>
                            </div>

                            <div class="space-y-2">
                                <InputLabel for="address" value="Dirección Completa" class="font-bold text-gray-700" />
                                <TextInput id="address" type="text" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500 rounded-xl" v-model="form.address" required placeholder="Ej. Av. Morelos #123, Col. Centro" />
                                <InputError class="mt-2" :message="form.errors.address" />
                            </div>

                            <div class="border-t border-gray-100 pt-8 mt-12">
                                <h4 class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-6 border-b pb-2 inline-block">Información de Contacto</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="space-y-2">
                                        <InputLabel for="phone" value="Teléfono" class="font-bold text-gray-700" />
                                        <TextInput id="phone" type="text" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500 rounded-xl" v-model="form.phone" placeholder="625 000 0000" />
                                    </div>
                                    <div class="space-y-2">
                                        <InputLabel for="email" value="Correo Electrónico" class="font-bold text-gray-700" />
                                        <TextInput id="email" type="email" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500 rounded-xl" v-model="form.email" placeholder="contacto@ejemplo.com" />
                                    </div>
                                    <div class="space-y-2">
                                        <InputLabel for="website" value="Sitio Web (opcional)" class="font-bold text-gray-700" />
                                        <TextInput id="website" type="url" class="mt-1 block w-full border-gray-200 focus:ring-indigo-500 rounded-xl" v-model="form.website" placeholder="https://www.ejemplo.com" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-12 bg-gray-50 -mx-12 -mb-12 p-8 border-t border-gray-100">
                                <Link :href="route('businesses.index')" class="text-gray-500 hover:text-gray-700 mr-8 font-bold">Cancelar</Link>
                                <PrimaryButton class="px-12 py-4 bg-indigo-600 hover:bg-indigo-700 shadow-2xl shadow-indigo-200 transform hover:-translate-y-1 transition text-lg" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Registrar mi Negocio
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
