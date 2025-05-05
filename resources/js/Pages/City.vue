<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const cities = ref([]);
const showAddModal = ref(false);
const showEditModal = ref(false);
const editingCity = ref(null);
const formCityData = ref({
    id: null,
    name: '',
    country: '',
    population: ''
});

const openAddModal = () => {
    showAddModal.value = true;
};

const openEditModal = (city) => {
    showEditModal.value = true;
    formCityData.value = { ...city };
    editingCity.value = { ...city };
};

const closeModals = () => {
    showAddModal.value = false;
    showEditModal.value = false;
};

onMounted(() => {
    fetchCities();
});

const fetchCities = async () => {
    try {
        const response = await axios.get('/cities');
        cities.value = response.data
    } catch (error) {
        console.error('Error al obtener la ciudad', error)
    }

}

const saveNewCity = async () => {
    try {
        const response = await axios.post('/city', formCityData.value);
        if (response.status === 200) {
            cities.value.push(response.data);
            closeModals();
        } else {
            console.warn('Cities added, but received status:', response.status)
        }
    } catch (error) {
        console.error('Error adding Cities:', error);
    }
}

const updateCity = async () => {
    try {
        const cityId = editingCity.value.id
        const response = await axios.put(`/city/${cityId}`, formCityData.value)
        if (response.status === 200) {
            const index = cities.value.findIndex(c => c.id === cityId);
            if (index != -1) {
                cities.value[index] = response.data;
                closeModals();
            }
        } else {
            console.warn('City updated, but received status:', response.status);
        }
    } catch (error) {
        console.error(`Error updating city with ID ${editingCity.value.id}:`, error);
    }
}

const deleteCity = async (city) =>{
    try{
        const response = await axios.delete(`/city/${city.id}`);
        if(response.status === 200){
            cities.value = cities.value.filter(c => c.id !== city.id);
        }else{
            console.warn('City deleted, but received status:', response.status);
        }
    }catch(error){
        console.error(`Error deleting cities with ID ${city.id}:`, error);

    }
}
</script>
<template>
    <div class="container mx-auto mt-4 px-2 sm:px-4">
        <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Gestión de Ciudades</h1>

        <button @click="openAddModal"
            class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
            Añadir Ciudad
        </button>
        <!-- Tabla de ropa -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 text-sm sm:text-base">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Nombre</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Ciudad</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Ciudadanos</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="city in cities" :key="city.id" class="hover:bg-gray-50">
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ city.name }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ city.country }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ city.population }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">
                            <button @click="openEditModal(city)" class="text-blue-500 hover:text-blue-700 mr-2">
                                Editar
                            </button>
                            <button @click="deleteCity(city)" class="text-red-500 hover:text-red-700">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Añadir Ciudad</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1">Nombre</label>
                        <input type="text" v-model="formCityData.name" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Ciudad</label>
                        <input type="text" v-model="formCityData.country" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Ciudadanos</label>
                        <input type="text" v-model="formCityData.population" class="w-full p-2 border rounded">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button @click="saveNewCity" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Guardar
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal de Editar (solo visual) -->
        <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Editar Ciudad</h2>

                <!-- Mismo formulario que en añadir -->
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1">Nombre</label>
                        <input type="text" v-model="formCityData.name" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Ciudad</label>
                        <input type="text" v-model="formCityData.country" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Ciudadanos</label>
                        <input type="text" v-model="formCityData.population" class="w-full p-2 border rounded">
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button @click="updateCity" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>