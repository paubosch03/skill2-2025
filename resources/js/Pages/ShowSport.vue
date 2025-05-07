<template>
    <div class="bg-gray-300 text-center text-black">
        <h2 class="text-xl font-bold mb-4">Detalles del Deporte</h2>
        <div>
            <table class="w-full border">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Nombre</th>
                    <th class="p-2 text-left">Categoría</th>
                    <th class="p-2 text-left">Jugadores por equipo</th>
                </tr>
                <tr class="border-t">
                    <td class="p-2 text-left">{{ sport.id }}</td>
                    <td class="p-2 text-left">{{ sport.name }}</td>
                    <td class="p-2 text-left">{{ sport.category }}</td>
                    <td class="p-2 text-left">{{ sport.players_per_team }}</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    sport: Object,
});
</script>