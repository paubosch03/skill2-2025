<template>

    <Head title="Editar Competición" />

    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Editar Competición</h1>

        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label for="name" class="block mb-1">Nombre:</label>
                    <input type="text" id="name" v-model="form.name" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="location" class="block mb-1">Lugar:</label>
                    <input type="text" id="location" v-model="form.location" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="start_date" class="block mb-1">Fecha de inicio:</label>
                    <input type="date" id="start_date" v-model="form.start_date" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="end_date" class="block mb-1">Fecha de fin:</label>
                    <input type="date" id="end_date" v-model="form.end_date" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="prize" class="block mb-1">Premio:</label>
                    <input type="text" id="prize" v-model="form.prize" class="w-full border p-2 rounded" required />
                </div>

                <div class="flex justify-between mt-4">
                    <Link :href="route('Competition.index')" class="bg-gray-300 px-3 py-1 rounded">
                        Cancelar
                    </Link>
                    <button type="submit" class="bg-[#2b72e6] text-white px-3 py-1 rounded">
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
    competition: Object,
});

const form = useForm({
    name: '',
    location: '',
    start_date: '',
    end_date: '',
    prize: '',
    _method: 'put',
});

onMounted(() => {
    if (props.competition) {
        form.name = props.competition.name;
        form.location = props.competition.location;
        form.start_date = props.competition.start_date;
        form.end_date = props.competition.end_date;
        form.prize = props.competition.prize;
    }
});

function submit() {
    form.post(route('Competition.update', props.competition.id));
}
</script>