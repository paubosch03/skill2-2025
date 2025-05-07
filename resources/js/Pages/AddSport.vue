<template>
    <!-- Define el título de la página -->

    <Head title="Crear Sport" />

    <!-- Contenedor principal -->
    <div class="container mx-auto p-4">
        <!-- Título de la página -->
        <h1 class="text-xl font-bold mb-4">Crear Sport</h1>

        <!-- Formulario en un contenedor con borde -->
        <div class="bg-white p-4 border rounded">
            <!-- Formulario con método para prevenir el envío normal -->
            <form @submit.prevent="submit">
                <!-- Campo para el name del producto -->
                <div class="mb-3">
                    <!-- Etiqueta del campo -->
                    <label for="name" class="block mb-1">name:</label>
                    <!-- Input para el name -->
                    <input type="text" id="name" v-model="form.name" class="w-full border p-2 rounded" required />
                </div>

                <!-- Campo para la descripcion -->
                <div class="mb-3">
                    <label for="category" class="block mb-1">category:</label>
                    <textarea id="category" v-model="form.category"
                        class="w-full border p-2 rounded" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="players_per_team" class="block mb-1">Jugadores por equipo:</label>
                    <input type="number" id="players_per_team" v-model="form.players_per_team"
                        class="w-full border p-2 rounded" required></input>
                </div>

                <div class="flex justify-between mt-4">
                    <Link :href="route('sport.index')" class="bg-gray-300 px-3 py-1 rounded">
                    Cancelar
                    </Link>
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
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
    sports: Array,
});


const form = useForm({
    name: '',
    category: '',
    players_per_team: '',

});

function submit() {
    form.post(route('sport.store'));
}
</script>