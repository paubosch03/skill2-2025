<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Estado reactivo
const appliances = ref([]);
const showAddModal = ref(false);
const showEditModal = ref(false);
const editingAppliance = ref(null);
const formApplianceData = ref({
    id: null,
    name: '',
    brand: '',
    model: '',
    power: ''
});

// Obtener electrodomésticos
onMounted(() => {
    fetchAppliances();
});

const fetchAppliances = async () => {
    try {
        const response = await axios.get('/appliances');
        appliances.value = response.data;
    } catch (error) {
        console.error('Error al obtener electrodomésticos:', error);
    }
};

// Funciones vacías (sin lógica)
const openAddModal = () => {
    showAddModal.value = true;
};
const openEditModal = (appliance) => {
    editingAppliance.value = { ...appliance };
    formApplianceData.value = { ...appliance };
    showEditModal.value = true;
};
const closeModals = () => {
    showAddModal.value = false;
    showEditModal.value = false;
};
const saveNewAppliance = async () => {
    try {
        const response = await axios.post('/appliance', formApplianceData.value);
        if (response.status === 200) {
            appliances.value.push(response.data)
            closeModals()
        } else {
            console.warn('Appliance added, but received status:', response.status);
        }
    } catch (error) {
        console.error('Error adding Appliance:', error);
    }
};
const updateAppliance = async () => {
    if (!editingAppliance.value) {
        console.error('No appliance selected for editing.');
        return;
    }

    try {
        const applianceId = editingAppliance.value.id;
        const response = await axios.put(`/appliance/${applianceId}`, formApplianceData.value);
        if (response.status === 200) {
            const index = appliances.value.findIndex(a => a.id === applianceId);
            if (index !== -1) {
                appliances.value[index] = response.data;
            }
            closeModals();
        } else {
            console.warn('Appliance updated, but received status:', response.status);
        }
    } catch (error) {
        console.error(`Error updating appliance with ID ${editingAppliance.value.id}:`, error);
    }
};
const confirmDeleteAppliance = (appliance) => {
    if (confirm(`¿Estás seguro de que deseas eliminar ${appliance.name}?`)) {
        deleteAppliance(appliance);
    }
};
const deleteAppliance = async (appliance) => {
    try {
        const response = await axios.delete(`/appliance/${appliance.id}`);
        if (response.status === 200) {
            appliances.value = appliances.value.filter(a => a.id !== appliance.id);
        } else {
            console.warn('Appliance deleted, but received status:', response.status);
        }
    } catch (error) {
        console.error(`Error deleting appliance with ID ${appliance.id}:`, error);
    }
};
</script>

<template>
    <div class="container mx-auto mt-4">
        <h1 class="text-2xl font-bold mb-4">Electrodomésticos</h1>

        <button @click="showAddModal = true"
            class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Appliance
        </button>

        <!-- Your Table -->
        <table class="min-w-full bg-white border border-gray-200" id="housesTable">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 border-b text-left">Nombre</th>
                    <th class="py-3 px-4 border-b text-left">Marca</th>
                    <th class="py-3 px-4 border-b text-left">Precio</th>
                    <th class="py-3 px-4 border-b text-left">Potencia (W)</th>
                    <th class="py-3 px-4 border-b text-left">Acciones</th>
                </tr>
            </thead>
            <tbody v-if="appliances.length > 0">
                <!-- Loop through the reactive 'appliances' array -->
                <!-- Use appliance.id for the key - IMPORTANT for Vue's rendering efficiency -->
                <tr v-for="appliance in appliances" :key="appliance.id" class="hover:bg-gray-50">
                    <td class="py-3 px-4 border-b">{{ appliance.name }}</td>
                    <td class="py-3 px-4 border-b">{{ appliance.brand }}</td>
                    <td class="py-3 px-4 border-b">{{ appliance.price }}</td>
                    <td class="py-3 px-4 border-b">{{ appliance.power }}</td>
                    <td class="py-3 px-4 border-b">
                        <!-- Pass the specific 'appliance' object to the methods -->
                        <button @click="openEditModal(appliance)" class="text-blue-500 hover:text-blue-700 mr-2">
                            Editar
                        </button>
                        <button @click="confirmDeleteAppliance(appliance)" class="text-red-500 hover:text-red-700">
                            Eliminar
                        </button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="5" class="text-center py-4 px-4 border-b">No houses found.</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal de Añadir (solo visual) -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Añadir Electrodoméstico</h2>

            <div class="space-y-4">
                <div>
                    <label class="block mb-1">Nombre</label>
                    <input type="text" v-model="formApplianceData.name" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Marca</label>
                    <input type="text" v-model="formApplianceData.brand" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Modelo</label>
                    <input type="text" v-model="formApplianceData.price" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Potencia (W)</label>
                    <input type="number" v-model="formApplianceData.power" class="w-full p-2 border rounded">
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100">
                    Cancelar
                </button>
                <button @click="saveNewAppliance" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de Editar (solo visual) -->
    <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Editar Electrodoméstico</h2>

            <!-- Mismo formulario que en añadir -->
            <div class="space-y-4">
                <div>
                    <label class="block mb-1">Nombre</label>
                    <input type="text" v-model="formApplianceData.name" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Marca</label>
                    <input type="text" v-model="formApplianceData.brand" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Modelo</label>
                    <input type="text" v-model="formApplianceData.price" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Potencia (W)</label>
                    <input type="number" v-model="formApplianceData.power" class="w-full p-2 border rounded">
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100">
                    Cancelar
                </button>
                <button @click="updateAppliance" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Actualizar
                </button>
            </div>
        </div>
    </div>
</template>