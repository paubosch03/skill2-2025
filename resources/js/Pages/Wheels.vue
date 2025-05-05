<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const wheels = ref([]);
const showAddModal = ref(false);
const showEditModal = ref(false);
const editingWheel = ref(null);
const formWheelData = ref({
    id: null,
    brand: '',
    price: '',
    stock: ''
});
const openAddModal = () => {
    showAddModal.value = true;
};
const openEditModal = (wheel) => {
    showEditModal.value = true;
    formWheelData.value = { ...wheel };
    editingWheel.value = { ...wheel };
};
const closeModals = () => {
    showAddModal.value = false;
    showEditModal.value = false;
};
onMounted(() => {
    fetchWheels();
});

const fetchWheels = async () => {
    try {
        const response = await axios.get('/wheels')
        wheels.value = response.data
    } catch (error) {
        console.error('Error al obtener la rueda', error)
    }
}

const saveNewWheel = async () => {
    try {
        const response = await axios.post('/wheel', formWheelData.value)
        if (response.status === 200) {
            wheels.value.push(response.data)
            closeModals();
        }
    } catch (error) {
        console.error('Error al añadir la rueda', error)
    }
}

const updateWheel = async () => {
    try {
        const wheelId = formWheelData.value.id
        const response = await axios.put(`/wheel/${wheelId}`, formWheelData.value);
        if (response.status === 200) {
            const index = wheels.value.findIndex(w => w.id === wheelId)
            if (index != -1) {
                wheels.value[index] = response.data
                closeModals();
            }
        } else {
            console.warn('Wheel updated, but received status:', response.status);
        }
    } catch (error) {
        console.error(`Error updating wheel with ID ${editingWheel.value.id}:`, error);
    }
}

const deleteWheel = async (wheel) => {
    try {
        const response = await axios.delete(`/wheel/${wheel.id}`);
        if (response.status === 200) {
            wheels.value = wheels.value.filter(w => w.id !== wheel.id);
        } else {
            console.warn('Wheel deleted, but received status:', response.status);
        }
    } catch (error) {
        console.error(`Error deleting cities with ID ${wheel.id}:`, error);

    }

}
</script>
<template>
    <div class="container mx-auto mt-4 px-2 sm:px-4">
        <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Gestión de Ruedas</h1>

        <button @click="openAddModal"
            class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
            Añadir Rueda
        </button>
        <!-- Tabla de ropa -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 text-sm sm:text-base">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Marca</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Precio</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Stock</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="wheel in wheels" :key="wheel.id" class="hover:bg-gray-50">
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ wheel.brand }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ wheel.price }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ wheel.stock }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">
                            <button @click="openEditModal(wheel)" class="text-blue-500 hover:text-blue-700 mr-2">
                                Editar
                            </button>
                            <button @click="deleteWheel(wheel)" class="text-red-500 hover:text-red-700">
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
                        <input type="text" v-model="formWheelData.brand" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Precio</label>
                        <input type="text" v-model="formWheelData.price" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Stock</label>
                        <input type="text" v-model="formWheelData.stock" class="w-full p-2 border rounded">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button @click="saveNewWheel" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Guardar
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal de Editar (solo visual) -->
        <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Editar Rueda</h2>

                <!-- Mismo formulario que en añadir -->
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1">Marca</label>
                        <input type="text" v-model="formWheelData.brand" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Precio</label>
                        <input type="text" v-model="formWheelData.price" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block mb-1">Stock</label>
                        <input type="text" v-model="formWheelData.stock" class="w-full p-2 border rounded">
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button @click="updateWheel" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>