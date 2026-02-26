<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    type: 'adopcion',
    species: '',
    name: '',
    sex: '',
    size: '',
    age: '',
    location: '',
    description: '',
    image: null,
    contact_info: {
        phone: '',
        whatsapp: '',
    },
});

const imagePreview = ref(null);

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(route('pets.store'), {
        onFinish: () => {
            form.reset();
            imagePreview.value = null;
        },
    });
};
</script>

<template>
    <Head title="Publicar Mascota" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Publicar Mascota</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="type" value="Tipo de publicación" />
                                    <select id="type" v-model="form.type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="adopcion">Adopción</option>
                                        <option value="perdido">Perdido</option>
                                        <option value="encontrado">Encontrado</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.type" />
                                </div>

                                <div>
                                    <InputLabel for="species" value="Especie / Raza" />
                                    <TextInput id="species" type="text" class="mt-1 block w-full" v-model="form.species" required placeholder="Ej. Labrador, Gato criollo..." />
                                    <InputError class="mt-2" :message="form.errors.species" />
                                </div>
                            </div>

                            <div>
                                <InputLabel for="name" value="Nombre de la mascota (opcional)" />
                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Ej. Max, Luna, Sin nombre..." />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <InputLabel for="sex" value="Sexo" />
                                    <select id="sex" v-model="form.sex" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">No sabe</option>
                                        <option value="Macho">Macho</option>
                                        <option value="Hembra">Hembra</option>
                                    </select>
                                </div>
                                <div>
                                    <InputLabel for="size" value="Tamaño" />
                                    <select id="size" v-model="form.size" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="Pequeño">Pequeño</option>
                                        <option value="Mediano">Mediano</option>
                                        <option value="Grande">Grande</option>
                                    </select>
                                </div>
                                <div>
                                    <InputLabel for="age" value="Edad aproximada" />
                                    <TextInput id="age" type="text" class="mt-1 block w-full" v-model="form.age" placeholder="Ej. 2 meses, 3 años..." />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                                <div class="space-y-6">
                                    <div>
                                        <InputLabel for="location" value="Ubicación / Colonia" />
                                        <TextInput id="location" type="text" class="mt-1 block w-full" v-model="form.location" required placeholder="Ej. Fracc. La Ciudadela" />
                                    </div>

                                    <div>
                                        <InputLabel for="description" value="Descripción y señas particulares" />
                                        <textarea id="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" v-model="form.description" required></textarea>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <InputLabel value="Fotografía de la mascota" />
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-indigo-400 transition cursor-pointer relative overflow-hidden group">
                                        <div v-if="!imagePreview" class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Sube una imagen</span>
                                                    <input id="image" name="image" type="file" class="sr-only" @change="handleImageChange" accept="image/*">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 2MB</p>
                                        </div>
                                        <div v-else class="w-full h-48 relative">
                                            <img :src="imagePreview" class="w-full h-full object-cover rounded-xl shadow-lg">
                                            <button @click.prevent="imagePreview = null; form.image = null" class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full shadow-lg hover:bg-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.image" />
                                </div>
                            </div>

                            <div class="border-t pt-6 space-y-4">
                                <h3 class="text-lg font-medium text-gray-900 font-black uppercase tracking-widest text-xs">Información de contacto</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <InputLabel for="phone" value="Teléfono" />
                                        <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.contact_info.phone" />
                                    </div>
                                    <div>
                                        <InputLabel for="whatsapp" value="WhatsApp" />
                                        <TextInput id="whatsapp" type="text" class="mt-1 block w-full" v-model="form.contact_info.whatsapp" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ms-4 px-8 py-3 bg-indigo-600 hover:bg-indigo-700 shadow-xl" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Publicar
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
