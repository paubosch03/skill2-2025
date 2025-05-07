<template>
    <div class="search-container mb-4">
        <input
            type="text"
            v-model="search"
            placeholder="Buscar por nombre o categoría..."
            class="px-4 py-2 border rounded-lg shadow-sm w-full sm:w-1/2"
        />
    </div>

    <!-- Carrusel simple -->
    <div class="relative w-full max-w-xl mx-auto mb-8">
        <div class="overflow-hidden rounded-lg border bg-white">
            <div class="flex transition-transform duration-500"
                :style="{ transform: `translateX(-${carouselIndex * 100}%)` }">
                <div
                    v-for="sport in filteredSports"
                    :key="sport.id"
                    class="w-full flex-shrink-0 p-8 flex flex-col items-center"
                    style="min-width: 100%;"
                >
                    <div class="text-2xl font-bold mb-2">{{ sport.name }}</div>
                    <div class="mb-1">Categoría: <span class="font-semibold">{{ sport.category }}</span></div>
                    <div>Jugadores por equipo: <span class="font-semibold">{{ sport.players_per_team }}</span></div>
                </div>
            </div>
        </div>
        <button
            class="absolute left-2 top-1/2 -translate-y-1/2 bg-gray-200 px-2 py-1 rounded-full"
            @click="prevSlide"
            :disabled="carouselIndex === 0"
        >&lt;</button>
        <button
            class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-200 px-2 py-1 rounded-full"
            @click="nextSlide"
            :disabled="carouselIndex === filteredSports.length - 1 || filteredSports.length === 0"
        >&gt;</button>
    </div>

    <div class="bg-gray-300 text-center text-black">
        Deportes:
        <button @click="goToCreateList"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear Deporte
        </button>

        <div>
            <table class="w-full border">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">name</th>
                    <th class="p-2 text-left">Category</th>
                    <th class="p-2 text-left">Jugadores</th>
                    <th class="p-2 text-left">Acciones</th>
                </tr>

                <tr class="border-t" v-for="sport in filteredSports" :key="sport.id">
                    <td class="p-2 text-left">{{ sport.id }}</td>
                    <td class="p-2 text-left">{{ sport.name }}</td>
                    <td class="p-2 text-left">{{ sport.category }}</td>
                    <td class="p-2 text-left">{{ sport.players_per_team }}</td>
                    <td class="p-2">
                        <div class="flex gap-2">
                            <Link :href="route('sport.show', sport.id)" class="text-blue-500">Ver</Link>
                            <Link :href="route('sport.edit', sport.id)" class="text-yellow-500">Editar</Link>
                            <button @click="deleteSport(sport.id)" class="text-red-500">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="p-2 text-center"></td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps, computed } from 'vue';

const props = defineProps({
    sports: Array,
});

const search = ref('');
const sports = ref([...props.sports]);

const filteredSports = computed(() =>
    sports.value.filter(sport =>
        sport.name.toLowerCase().includes(search.value.toLowerCase()) ||
        sport.category.toLowerCase().includes(search.value.toLowerCase())
    )
);

// Carrusel
const carouselIndex = ref(0);

function prevSlide() {
    if (carouselIndex.value > 0) carouselIndex.value--;
}
function nextSlide() {
    if (carouselIndex.value < filteredSports.value.length - 1) carouselIndex.value++;
}

function deleteSport(id) {
    router.delete(route('sport.destroy', id), {
        preserveScroll: true,
        onSuccess: () => {
            sports.value = sports.value.filter(sport => sport.id !== id);
            if (carouselIndex.value >= filteredSports.value.length) {
                carouselIndex.value = Math.max(0, filteredSports.value.length - 1);
            }
        }
    });
}

function goToCreateList() {
    router.visit('/sport/create');
}
</script>