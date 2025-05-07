<template>
    <div class="search-container mb-4 flex flex-col sm:flex-row gap-4">
        <input id="search-athlete" type="text" v-model="search" placeholder="Buscar por nombre o país..."
            class="px-4 py-2 border rounded-lg shadow-sm w-full sm:w-1/2" />
        <select v-model="selectedSport" class="px-4 py-2 border rounded-lg shadow-sm">
            <option value="">Todos los deportes</option>
            <option v-for="sport in sports" :key="sport" :value="sport">{{ sport }}</option>
        </select>
        <select v-model="selectedCountry" class="px-4 py-2 border rounded-lg shadow-sm">
            <option value="">Todos los países</option>
            <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
        </select>
    </div>

    <!-- Carrusel simple -->
    <div class="relative w-full max-w-xl mx-auto mb-8">
        <div class="overflow-hidden rounded-lg border bg-white">
            <div class="flex transition-transform duration-500"
                :style="{ transform: `translateX(-${carouselIndex * 100}%)` }">
                <div v-for="athlete in filteredAthletes" :key="athlete.id"
                    class="w-full flex-shrink-0 p-8 flex flex-col items-center" style="min-width: 100%;">
                    <div class="text-2xl font-bold mb-2">{{ athlete.first_name }}</div>
                    <div class="mb-1">Nombre: <span class="font-semibold">{{ athlete.last_name }}</span></div>
                    <div>Ciudades: <span class="font-semibold">{{ athlete.country }}</span></div>
                </div>
            </div>
        </div>
        <button class="absolute left-2 top-1/2 -translate-y-1/2 bg-gray-200 px-2 py-1 rounded-full" @click="prevSlide"
            :disabled="carouselIndex === 0">&lt;</button>
        <button class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-200 px-2 py-1 rounded-full" @click="nextSlide"
            :disabled="carouselIndex === athletes.length - 1 || athletes.length === 0">&gt;</button>
    </div>

    <div class="bg-gray-300 text-center text-black">
        Deportes:
        <button @click="goToCreateList"
            class="bg-[#2b72e6] hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
            Crear Deporte
        </button>

        <div>
            <table class="w-full border">
                <tr>
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">First Name</th>
                    <th class="p-2 text-left">Last Name</th>
                    <th class="p-2 text-left">Country</th>
                    <th class="p-2 text-left">Sport</th>
                    <th class="p-2 text-left">Acciones</th>
                </tr>

                <tr class="border-t" v-for="athlete in filteredAthletes" :key="athlete.id">
                    <td class="p-2 text-left">{{ athlete.id }}</td>
                    <td class="p-2 text-left">{{ athlete.first_name }}</td>
                    <td class="p-2 text-left">{{ athlete.last_name }}</td>
                    <td class="p-2 text-left">{{ athlete.country }}</td>
                    <td class="p-2 text-left">
                        {{ athlete.sport ? athlete.sport.name : 'Sin deporte' }}
                    </td>
                    <td class="p-2">
                        <div class="flex gap-2">
                            <Link :href="route('Athlete.show', athlete.id)" class="text-[#0e55c9]">Ver</Link>
                            <Link :href="route('Athlete.edit', athlete.id)" class="text-[#0a0800]">Editar</Link>
                            <button @click="deleteAthlete(athlete.id)" class="text-[#ba0f0f]">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="p-2 text-center"></td>
                </tr>
            </table>
            <div v-if="filteredAthletes.length === 0" class="p-4 text-center text-red-600">
                No se encontraron atletas con los filtros seleccionados.
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, defineProps, computed } from 'vue';

const props = defineProps({
    athletes: Array,
    require: true,
});

const search = ref('');
const selectedSport = ref('');
const selectedCountry = ref('');
const athletes = ref([...props.athletes]);

// Obtener lista única de deportes y países
const sports = computed(() => {
    const set = new Set();
    athletes.value.forEach(a => a.sport && set.add(a.sport.name));
    return Array.from(set);
});
const countries = computed(() => {
    const set = new Set();
    athletes.value.forEach(a => set.add(a.country));
    return Array.from(set);
});

// Filtro combinado
const filteredAthletes = computed(() =>
    athletes.value.filter(athlete =>
        (athlete.first_name.toLowerCase().includes(search.value.toLowerCase()) ||
            athlete.last_name.toLowerCase().includes(search.value.toLowerCase()) ||
            athlete.country.toLowerCase().includes(search.value.toLowerCase())
        ) &&
        (selectedSport.value === '' || (athlete.sport && athlete.sport.name === selectedSport.value)) &&
        (selectedCountry.value === '' || athlete.country === selectedCountry.value)
    )
);

// Carrusel
const carouselIndex = ref(0);

function prevSlide() {
    if (carouselIndex.value > 0) carouselIndex.value--;
}
function nextSlide() {
    if (carouselIndex.value < filteredAthletes.value.length - 1) carouselIndex.value++;
}

function deleteAthlete(id) {
    router.delete(route('Athlete.destroy', id), {
        preserveScroll: true,
        onSuccess: () => {
            athletes.value = athletes.value.filter(athlete => athlete.id !== id);
            if (carouselIndex.value >= filteredAthletes.value.length) {
                carouselIndex.value = Math.max(0, filteredAthletes.value.length - 1);
            }
        }
    });
}

function goToCreateList() {
    router.visit('/Athlete/create');
}
</script>