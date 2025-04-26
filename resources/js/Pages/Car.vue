<script setup>
import { ref } from 'vue'
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';
import { defineProps } from 'vue';

const props = defineProps({
    cars: {
        type: Array,
        required: true
    }
});

const newCar = ref({
    make: '',
    model: '',
    year: null,
    color: '',
    price: 0,
    mileage: 0,
    fuel_type: '',
    transmission: '',
    vin: ''
})

const editCar = ref({
    make: '',
    model: '',
    year: null,
    color: '',
    price: 0,
    mileage: 0,
    fuel_type: '',
    transmission: '',
    vin: ''
})

const showAddModal = ref(false)
const showEditModal = ref(false)
const editIndex = ref(null)
const searchQuery = ref('')
const filteredCars = ref([...props.cars]);

// Métodos
const openAddModal = () => {
    showAddModal.value = true
}

const closeAddModal = () => {
    showAddModal.value = false
    NewCar()
}

const openEditModal = (index) => {
    editIndex.value = index
    editCar.value = { ...props.cars[index] }
    showEditModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
    EditCar()
}

const NewCar = () => {
    newCar.value = {
        make: '',
        model: '',
        year: null,
        color: '',
        price: 0,
        mileage: 0,
        fuel_type: '',
        transmission: '',
        vin: ''
    }
}

const EditCar = () => {
    editCar.value = {
        make: '',
        model: '',
        year: null,
        color: '',
        price: 0,
        mileage: 0,
        fuel_type: '',
        transmission: '',
        vin: ''
    }
    editIndex.value = null
}

const insertNewCar = async () => {
    const formData = {
        make: newCar.value.make,
        model: newCar.value.model,
        year: newCar.value.year,
        color: newCar.value.color,
        price: newCar.value.price,
        mileage: newCar.value.mileage
    }
    try {
        const response = await axios.post('car', formData);
        Inertia.visit('/car')
        closeAddModal()
    } catch (error) {
        console.error('Error al crear un coche', error)
    }
}

const updateCar = async () => {
    const formData = {
        id: editCar.value.id,
        make: editCar.value.make,
        model: editCar.value.model,
        year: editCar.value.year,
        color: editCar.value.color,
        price: editCar.value.price,
        mileage: editCar.value.mileage,
    };
    try {
        const id = editCar.value.id;
        const result = await axios.put(`/cars/${id}`, formData);
        if (result.status === 200) {
            const index = props.cars.findIndex(car => car.id === id);
            if (index !== -1) {
                props.cars[index] = { ...props.cars[index], ...formData };
            }
        }
        closeEditModal()
    } catch (error) {
        console.error('Error al actualizar el coche:', error);
    }
}


const deleteCar = async (index) => {
    if (confirm('¿Estas seguro de eliminar el coche?')) {
        try {
            const id = props.cars[index].id;
            await axios.delete(`/cars/${id}`);
            props.cars.splice(index, 1);
        } catch (error) {
            console.error('Error al eliminar el coche:', error);
        }
    }
}

const searchCar = () => {
    if (!searchQuery.value) {
        filteredCars.value = [...props.cars];
        return;
    }
    const query = searchQuery.value.toLowerCase();
    filteredCars.value = props.cars.filter(car => {
        return car.make.toLowerCase().includes(query) ||
            car.model.toLowerCase().includes(query) ||
            car.year.toString().includes(query) ||
            car.color.toLowerCase().includes(query) ||
            car.price.toString().includes(query) ||
            car.mileage.toString().includes(query);
    });
};
</script>
<template>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Gestión de Coches</h1>

        <button @click="openAddModal" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-6">
            Añadir Coche
        </button>
        <input type="text" id="CarSeachBox" v-model="searchQuery">
        <button @click="searchCar" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded mb-6">Buscar</button>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-4 border-b text-left">Marca</th>
                        <th class="py-3 px-4 border-b text-left">Modelo</th>
                        <th class="py-3 px-4 border-b text-left">Año</th>
                        <th class="py-3 px-4 border-b text-left">Color</th>
                        <th class="py-3 px-4 border-b text-left">Precio</th>
                        <th class="py-3 px-4 border-b text-left">Kilometraje</th>
                        <th class="py-3 px-4 border-b text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(car, index) in filteredCars" :key="car.id" class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">{{ car.make }}</td>
                        <td class="py-3 px-4 border-b">{{ car.model }}</td>
                        <td class="py-3 px-4 border-b">{{ car.year }}</td>
                        <td class="py-3 px-4 border-b">{{ car.color }}</td>
                        <td class="py-3 px-4 border-b">${{ car.price.toLocaleString() }}</td>
                        <td class="py-3 px-4 border-b">{{ car.mileage.toLocaleString() }} km</td>
                        <td class="py-3 px-4 border-b">
                            <button @click="openEditModal(index)" class="text-blue-500 hover:text-blue-700 mr-2">
                                Editar
                            </button>
                            <button @click="deleteCar(index)" class="text-red-500 hover:text-red-700">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal para añadir coche -->
        <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Añadir Nuevo Coche</h2>

                <form @submit.prevent="insertNewCar">
                    <!-- Marca -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="add-make">Marca</label>
                        <input v-model="newCar.make" type="text" id="add-make" class="w-full px-3 py-2 border rounded"
                            required>
                    </div>

                    <!-- Modelo -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="add-model">Modelo</label>
                        <input v-model="newCar.model" type="text" id="add-model" class="w-full px-3 py-2 border rounded"
                            required>
                    </div>

                    <!-- Año -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="add-year">Año</label>
                        <input v-model="newCar.year" type="number" id="add-year" min="1900"
                            :max="new Date().getFullYear()" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <!-- Color -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="add-color">Color</label>
                        <input v-model="newCar.color" type="text" id="add-color"
                            class="w-full px-3 py-2 border rounded">
                    </div>
                    <!-- Precio -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="add-price">Precio ($)</label>
                        <input v-model="newCar.price" type="number" id="add-price" step="0.01" min="0"
                            class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <!-- Kilometraje -->
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="add-mileage">Kilometraje (km)</label>
                        <input v-model="newCar.mileage" type="number" id="add-mileage" min="0"
                            class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <!-- Botones -->
                    <div class="flex justify-end">
                        <button type="button" @click="closeAddModal"
                            class="mr-2 px-4 py-2 border rounded hover:bg-gray-100 transition">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal para editar coche -->
        <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-2xl"> <!-- Aumenté el ancho máximo -->
                <h2 class="text-xl font-bold mb-4">Editar Coche</h2>

                <form @submit.prevent="updateCar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4"> <!-- Grid de 2 columnas -->

                        <!-- Columna Izquierda -->
                        <div>
                            <!-- Marca -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="edit-make">Marca</label>
                                <input v-model="editCar.make" type="text" id="edit-make"
                                    class="w-full px-3 py-2 border rounded" required>
                            </div>

                            <!-- Modelo -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="edit-model">Modelo</label>
                                <input v-model="editCar.model" type="text" id="edit-model"
                                    class="w-full px-3 py-2 border rounded" required>
                            </div>

                            <!-- Año -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="edit-year">Año</label>
                                <input v-model="editCar.year" type="number" id="edit-year" min="1900"
                                    :max="new Date().getFullYear()" class="w-full px-3 py-2 border rounded" required>
                            </div>

                            <!-- Color -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="edit-color">Color</label>
                                <input v-model="editCar.color" type="text" id="edit-color"
                                    class="w-full px-3 py-2 border rounded">
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div>
                            <!-- Precio -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="edit-price">Precio ($)</label>
                                <input v-model="editCar.price" type="number" id="edit-price" step="0.01" min="0"
                                    class="w-full px-3 py-2 border rounded" required>
                            </div>

                            <!-- Kilometraje -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2" for="edit-mileage">Kilometraje (km)</label>
                                <input v-model="editCar.mileage" type="number" id="edit-mileage" min="0"
                                    class="w-full px-3 py-2 border rounded" required>
                            </div>
                        </div>
                    </div>

                    <!-- Botones (ancho completo) -->
                    <div class="flex justify-end mt-4">
                        <button type="button" @click="closeEditModal"
                            class="mr-2 px-4 py-2 border rounded hover:bg-gray-100 transition">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>


<style scoped>
/* Estilos igual que en el ejemplo anterior */
</style>