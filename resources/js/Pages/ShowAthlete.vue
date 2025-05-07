<template>
    <div class="bg-gray-300 text-center text-black min-h-screen flex flex-col items-center justify-center">
        <h2 class="text-xl font-bold mb-4">Detalles del Atleta</h2>
        <div>
            <table class="w-full border bg-white rounded">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Nombre</th>
                    <th class="p-2 text-left">Apellido</th>
                    <th class="p-2 text-left">Fecha de nacimiento</th>
                    <th class="p-2 text-left">País</th>
                </tr>
                <tr class="border-t">
                    <td class="p-2 text-left">{{ athlete.id }}</td>
                    <td class="p-2 text-left">{{ athlete.first_name }}</td>
                    <td class="p-2 text-left">{{ athlete.last_name }}</td>
                    <td class="p-2 text-left">{{ athlete.birth_date }}</td>
                    <td class="p-2 text-left">{{ athlete.country }}</td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    athlete: Object,
});
</script>