<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { defineProps } from 'vue'

const props = defineProps({
    bikes: {
        type: Array,
        required: true
    }
});
const bikes = ref(props.bikes);
const houses = ref([]);
const showAddModal = ref(false);
const showEditModal = ref(false);
const editingBike = ref(null);
const formBikedata = ref({
    id: null,
    brand: '',
    model: '',
    type: '',
    size: '',
    color: '',
    frame_material: '',
    speeds: '',
    price: '',
});

console.log(bikes.value);
const openAddModal = () => {
    showAddModal.value = true;
};

const openEditModal = (bike) => {
    showEditModal.value = true;
    formBikedata.value = { ...bike };
    editingBike.value = { ...bike };
};

const closeModals = () => {
    showAddModal.value = false;
    showEditModal.value = false;
};

onMounted(() => {
    featchBikes()
});

const featchBikes = async () => {
    try {
        const response = await axios.get('/bikes')
        bikes.value = response.data
    } catch (error) {
        console.error('Error al obtener la bicicleta', error)
    }
}

const saveNewBike = async () => {
    try {
        const response = await axios.post('/bike', formBikedata.value)
        if (response.status === 200) {
            bikes.value.push(response.data)
            closeModals();
        }
    } catch (error) {
        console.error('Error al añadir la rueda', error)
    }
}

const updateBike = async () => {
    try {
        const bikeId = editingBike.value.id
        const response = await axios.put(`/bike/${bikeId}`, formBikedata.value)
        if (response.status === 200) {
            const index = bikes.value.findIndex(b => b.id === bikeId)
            if (index != -1) {
                bikes.value[index] = response.data
                closeModals();
            }
        } else {
            console.warn('Bike updated, but received status:', response.status);
        }
    } catch (error) {
        console.error(`Error updating bike with ID ${editingBike.value.id}:`, error);

    }
}

const deleteBike = async (bike) => {
    try {
        const response = await axios.delete(`/bike/${bike.id}`)
        if (response.status === 200) {
            bikes.value = bikes.value.filter(b => b.id !== bike.id)
        }
    } catch {
        console.error(`Error deleting bike with ID ${bike.id}:`, error);

    }
}
</script>

<template>
    <div class="container mx-auto mt-4 px-2 sm:px-4">
        <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Gestión de Bicis</h1>

        <button @click="openAddModal"
            class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
            Añadir Bicicleta
        </button>

        <!-- Tabla de bicicletas -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 text-sm sm:text-base">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Marca</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Modelo</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Tipo</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Color</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Material</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Velocidades</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Precio</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Casa</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="bike in props.bikes" :key="bike.id" class="hover:bg-gray-50">
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ bike.brand }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ bike.model }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ bike.type }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ bike.color }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ bike.frame_material }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ bike.speeds }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ bike.price }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ bike.houses?.address || 'Sin casa' }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">
                            <button @click="openEditModal(bike)" class="text-blue-500 hover:text-blue-700 mr-2">
                                Editar
                            </button>
                            <button @click="deleteBike(bike)" class="text-red-500 hover:text-red-700">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal para añadir bicicleta -->
        <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Añadir Bicicleta</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1">Marca</label>
                        <input type="text" v-model="formBikedata.brand" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Modelo</label>
                        <input type="text" v-model="formBikedata.model" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Tipo</label>
                        <input type="text" v-model="formBikedata.type" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Color</label>
                        <input type="text" v-model="formBikedata.color" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Material</label>
                        <input type="text" v-model="formBikedata.frame_material" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Velocidades</label>
                        <input type="text" v-model="formBikedata.speeds" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Precio</label>
                        <input type="text" v-model="formBikedata.price" class="w-full p-2 border rounded">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button @click="saveNewBike" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Guardar
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal para editar bicicleta -->
        <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Editar Bicicleta</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block mb-1">Marca</label>
                        <input type="text" v-model="formBikedata.brand" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Modelo</label>
                        <input type="text" v-model="formBikedata.model" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Tipo</label>
                        <input type="text" v-model="formBikedata.type" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Color</label>
                        <input type="text" v-model="formBikedata.color" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Material</label>
                        <input type="text" v-model="formBikedata.frame_material" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Velocidades</label>
                        <input type="text" v-model="formBikedata.speeds" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Precio</label>
                        <input type="text" v-model="formBikedata.price" class="w-full p-2 border rounded">
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button @click="updateBike" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>