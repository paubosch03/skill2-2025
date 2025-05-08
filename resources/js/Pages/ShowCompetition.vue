<template>
    <div class="bg-gray-300 text-center text-black min-h-screen flex flex-col items-center justify-center">
        <h2 class="text-xl font-bold mb-4">Detalles de la Competición</h2>
        <div>
            <table class="w-full border bg-white rounded">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Nombre</th>
                    <th class="p-2 text-left">Lugar</th>
                    <th class="p-2 text-left">Fecha de inicio</th>
                    <th class="p-2 text-left">Fecha de fin</th>
                    <th class="p-2 text-left">Premio</th>
                    <th class="p-2 text-left">Deporte</th>
                </tr>
                <tr class="border-t">
                    <td class="p-2 text-left">{{ competition.id }}</td>
                    <td class="p-2 text-left">{{ competition.name }}</td>
                    <td class="p-2 text-left">{{ competition.location }}</td>
                    <td class="p-2 text-left">{{ competition.start_date }}</td>
                    <td class="p-2 text-left">{{ competition.end_date }}</td>
                    <td class="p-2 text-left">{{ competition.prize }}</td>
                    <td class="p-2 text-left">{{ competition.sport ? competition.sport.name : 'Sin deporte' }}</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    competition: Object,
});
</script>