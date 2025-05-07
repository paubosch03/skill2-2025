<template>
    <Head title="Editar Deporte" />

    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Editar Deporte</h1>

        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label for="name" class="block mb-1">Nombre:</label>
                    <input type="text" id="name" v-model="form.name" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="category" class="block mb-1">Categoría:</label>
                    <input type="text" id="category" v-model="form.category" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="players_per_team" class="block mb-1">Jugadores por equipo:</label>
                    <input type="number" id="players_per_team" v-model="form.players_per_team" class="w-full border p-2 rounded" required />
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
import { defineProps, onMounted } from 'vue';

const props = defineProps({
    sport: Object,
});

const form = useForm({
    name: '',
    category: '',
    players_per_team: '',
    _method: 'put',
});

onMounted(() => {
    if (props.sport) {
        form.name = props.sport.name;
        form.category = props.sport.category;
        form.players_per_team = props.sport.players_per_team;
    }
});

function submit() {
    form.post(route('sport.update', props.sport.id));
}
</script>