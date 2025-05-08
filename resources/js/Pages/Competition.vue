<template>
    <div class="bg-gray-300 text-center text-black py-8">
        <h1 class="text-2xl font-bold mb-6">Listado de Competiciones</h1>
        <button @click="goToCreateList"
            class="bg-[#2b72e6] hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
            Crear Competición
        </button>
        <div>
            <table class="w-full border bg-white">
                <thead>
                    <tr>
                        <th class="p-2 text-left">ID</th>
                        <th class="p-2 text-left">Nombre</th>
                        <th class="p-2 text-left">Lugar</th>
                        <th class="p-2 text-left">Fecha de inicio</th>
                        <th class="p-2 text-left">Fecha de fin</th>
                        <th class="p-2 text-left">Premio</th>
                        <th class="p-2 text-left">Deporte</th>
                        <th class="p-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t" v-for="competition in competitions" :key="competition.id">
                        <td class="p-2 text-left">{{ competition.id }}</td>
                        <td class="p-2 text-left">{{ competition.name }}</td>
                        <td class="p-2 text-left">{{ competition.location }}</td>
                        <td class="p-2 text-left">{{ competition.start_date }}</td>
                        <td class="p-2 text-left">{{ competition.end_date }}</td>
                        <td class="p-2 text-left">{{ competition.prize }}</td>
                        <td class="p-2 text-left">
                            {{ competition.sport ? competition.sport.name : 'Sin deporte' }}
                        </td>
                        <td class="p-2">
                            <div class="flex gap-2">
                                <Link :href="route('Competition.show', competition.id)" class="text-[#0e55c9]">Ver</Link>
                                <Link :href="route('Competition.edit', competition.id)" class="text-[#0a0800]">Editar</Link>
                                <button @click="deleteCompetition(competition)" class="text-[#ba0f0f]">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-if="competitions.length === 0" class="p-4 text-center text-red-600">
                No se encontraron competiciones.
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';
import axios from 'axios';

const props = defineProps({
    competitions: Array,
    require: true,
});

const competitions = ref([...props.competitions]);

const deleteCompetition = async (competition) => {
    try {
        const response = await axios.delete(`/competition/${competition.id}`)
        if (response.status === 200) {
            competitions.value = competitions.value.filter(c => c.id !== competition.id)
        }
    } catch (error) {
        console.error(`Error deleting competition with ID ${competition.id}:`, error);
    }
};

function goToCreateList() {
    router.visit('/Competition/create');
}
</script>