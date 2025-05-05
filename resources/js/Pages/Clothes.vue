<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const clothes = ref([]);
const showAddModal = ref(false);
const showEditModal = ref(false);
const editingClothe = ref(null);
const formClothesData = ref({
    id: '',
    type: '',
    brand: '',
    color: '',
    size: '',
    price: '',
    material: '',
    gender: ''
});
onMounted(() => {
    fetchClothes();
});

const fetchClothes = async () => {
    try {
        const response = await axios.get('/clothes');
        clothes.value = response.data
    } catch (error) {
        console.error('Error al obtener la ropa', error)
    }
}

const openAddModal = () => {
    showAddModal.value = true;
};
const openEditModal = (clothing) => {
    formClothesData.value = { ...clothing };
    editingClothe.value = { ...clothing };
    showEditModal.value = true;
};
const closeModals = () => {
    showAddModal.value = false;
    showEditModal.value = false;
};
const saveNewClothing = async () => {
    try {
        const response = await axios.post('/clothe', formClothesData.value)
        if (response.status === 200) {
            clothes.value.push(response.data)
            closeModals()
        } else {
            console.warn('Clothes added, but received status:', response.status)
        }
    } catch (error) {
        console.error('Error adding Clothes:', error);
    }
    closeModals();
};
const updateClothing = async () => {
    try {
        const clotheId = editingClothe.value.id;
        const response = await axios.put(`/clothe/${clotheId}`, formClothesData.value)
        if (response.status === 200) {
            const index = clothes.value.findIndex(c => c.id === clotheId)
            if (index != -1) {
                clothes.value[index] = response.data;
            }
            closeModals();
        } else {
            console.warn('Clothes updated, but received status:', response.status);
        }
    } catch (error) {
        console.error(`Error updating clothe with ID ${editingClothe.value.id}:`, error);
    }
};

const deleteClothing = async (clothe) => {
    try {
        const response = await axios.delete(`/clothe/${clothe.id}`);
        if (response.status === 200) {
            clothes.value = clothes.value.filter(c => c.id !== clothe.id);
        } else {
            console.warn('Clothe deleted, but received status:', response.status);
        }
    } catch (error) {
        console.error(`Error deleting clothes with ID ${clothe.id}:`, error);

    }
};
</script>

<template>
    <div class="container mx-auto mt-4 px-2 sm:px-4">
        <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-center">Gestión de Ropa</h1>

        <button @click="openAddModal"
            class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full sm:w-auto">
            Añadir Prenda
        </button>

        <!-- Tabla de ropa -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 text-sm sm:text-base">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Tipo</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Marca</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Color</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Talla</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Precio</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Material</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Género</th>
                        <th class="py-2 px-2 sm:py-3 sm:px-4 border-b text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="clothing in clothes" :key="clothing.id" class="hover:bg-gray-50">
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ clothing.type }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ clothing.brand }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ clothing.color }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ clothing.size }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">${{ clothing.price }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ clothing.material }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">{{ clothing.gender }}</td>
                        <td class="py-2 px-2 sm:py-3 sm:px-4 border-b">
                            <button @click="openEditModal(clothing)" class="text-blue-500 hover:text-blue-700 mr-2">
                                Editar
                            </button>
                            <button @click="deleteClothing(clothing)" class="text-red-500 hover:text-red-700">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Añadir (responsive) -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-4 sm:p-6 rounded-lg w-[95vw] max-w-md sm:w-1/3">
            <h2 class="text-lg sm:text-xl font-bold mb-4">Añadir Prenda</h2>
            <div class="space-y-3 sm:space-y-4">
                <div>
                    <label class="block mb-1">Tipo de Prenda</label>
                    <input type="text" v-model="formClothesData.type" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Marca</label>
                    <input type="text" v-model="formClothesData.brand" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Color</label>
                    <input type="text" v-model="formClothesData.color" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Talla</label>
                    <input type="text" v-model="formClothesData.size" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Precio</label>
                    <input type="number" v-model="formClothesData.price" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Material</label>
                    <input type="text" v-model="formClothesData.material" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Género</label>
                    <select v-model="formClothesData.gender" class="w-full p-2 border rounded">
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Unisex">Unisex</option>
                        <option value="Niño">Niño</option>
                        <option value="Niña">Niña</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
                <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100 w-full sm:w-auto">
                    Cancelar
                </button>
                <button @click="saveNewClothing"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 w-full sm:w-auto">
                    Guardar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de Editar (responsive) -->
    <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-4 sm:p-6 rounded-lg w-[95vw] max-w-md sm:w-1/3">
            <h2 class="text-lg sm:text-xl font-bold mb-4">Editar Prenda</h2>
            <div class="space-y-3 sm:space-y-4">
                <div>
                    <label class="block mb-1">Tipo de Prenda</label>
                    <input type="text" v-model="formClothesData.type" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Marca</label>
                    <input type="text" v-model="formClothesData.brand" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Color</label>
                    <input type="text" v-model="formClothesData.color" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Talla</label>
                    <input type="text" v-model="formClothesData.size" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Precio</label>
                    <input type="number" v-model="formClothesData.price" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Material</label>
                    <input type="text" v-model="formClothesData.material" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block mb-1">Género</label>
                    <select v-model="formClothesData.gender" class="w-full p-2 border rounded">
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Unisex">Unisex</option>
                        <option value="Niño">Niño</option>
                        <option value="Niña">Niña</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 mt-6">
                <button @click="closeModals" class="px-4 py-2 border rounded hover:bg-gray-100 w-full sm:w-auto">
                    Cancelar
                </button>
                <button @click="updateClothing"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 w-full sm:w-auto">
                    Actualizar
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Estilos básicos para la tabla */
table {
    border-collapse: collapse;
    width: 100%;
}

th,
td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f8f9fa;
    font-weight: 600;
}

tr:hover {
    background-color: #f5f5f5;
}

/* Estilos para los botones */
button {
    transition: all 0.3s ease;
}

/* Estilos para los modales */
.fixed {
    z-index: 50;
}

.bg-opacity-50 {
    background-color: rgba(0, 0, 0, 0.5);
}

.rounded-lg {
    border-radius: 0.5rem;
}

/* Estilos para los inputs */
input,
select {
    border: 1px solid #e2e8f0;
    border-radius: 0.25rem;
    transition: border-color 0.2s;
}

input:focus,
select:focus {
    border-color: #4299e1;
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
}

html,
body,
#app {
    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 100vw;
}
</style>