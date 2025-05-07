<template>

    <Head title="Crear Atleta" />

    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Crear Atleta</h1>

        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label for="first_name" class="block mb-1">Nombre:</label>
                    <input type="text" id="first_name" v-model="form.first_name" class="w-full border p-2 rounded"
                        required />
                </div>

                <div class="mb-3">
                    <label for="last_name" class="block mb-1">Apellido:</label>
                    <input type="text" id="last_name" v-model="form.last_name" class="w-full border p-2 rounded"
                        required />
                </div>

                <div class="mb-3">
                    <label for="birth_date" class="block mb-1">Fecha de nacimiento:</label>
                    <input type="date" id="birth_date" v-model="form.birth_date" class="w-full border p-2 rounded"
                        required />
                </div>

                <div class="mb-3">
                    <label for="country" class="block mb-1">País:</label>
                    <input type="text" id="country" v-model="form.country" class="w-full border p-2 rounded" required />
                </div>

                <div class="flex justify-between mt-4">
                    <Link :href="route('Athlete.index')" class="bg-gray-300 px-3 py-1 rounded">
                    Cancelar
                    </Link>
                    <button type="submit" class="bg-[#0a51c5] text-white px-3 py-1 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';

const props = defineProps({
    athletes: Array,
});

const form = useForm({
    first_name: '',
    last_name: '',
    birth_date: '',
    country: ''
})

function submit() {
    form.post(route('Athlete.store'))
}
</script>
