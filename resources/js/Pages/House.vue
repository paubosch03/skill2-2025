<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios'; // Make sure axios is installed (npm install axios)

// --- Reactive State ---
const houses = ref([]); // Holds the list of houses displayed in the table
const showAddModal = ref(false); // Controls visibility of the add modal
const editingHouse = ref(null); // Holds the house object being edited, or null
const formHouseData = ref({ // Holds data for the add/edit form
    id: null,
    address: '',
    city: '',
    zip_code: '',
    country: ''
});

// --- Lifecycle Hook ---
onMounted(() => {
    fetchHouses(); // Load initial data when the component is mounted
});

// --- Methods ---

// Fetch all houses from the API
const fetchHouses = async () => {
    try {
        // Adjust '/houses' to your actual API endpoint for getting all houses
        const response = await axios.get('/houses');
        houses.value = response.data; // Update the reactive array
    } catch (error) {
        console.error('Error fetching houses:', error);
        // Add user feedback here (e.g., show an error message)
    }
};

// Prepare and show the modal for adding a new house
const openAddModal = () => {
    editingHouse.value = null; // Ensure we are not in edit mode
    // Reset form data for a new entry
    formHouseData.value = { id: null, address: '', city: '', zip_code: '', country: '' };
    showAddModal.value = true;
};

// Prepare and show the modal for editing an existing house
const openEditModal = (house) => {
    editingHouse.value = house; // Store the house being edited
    // Populate form with the existing house data
    formHouseData.value = { ...house }; // Use spread syntax to copy data
    showAddModal.value = false; // Ensure add modal flag is false if reusing modal logic
    // If using a separate edit modal flag, set it here.
    // For simplicity, this example reuses the editingHouse ref to control modal state/content.
};

// Close the add/edit modal
const closeModal = () => {
    showAddModal.value = false;
    editingHouse.value = null;
    // Consider resetting formHouseData here as well if needed
};

// Save (Create or Update) a house
const saveHouse = async () => {
    if (editingHouse.value) {
        // --- Update existing house ---
        try {
            const houseId = editingHouse.value.id;
            // Adjust '/house/{id}' to your actual API endpoint for updating
            const response = await axios.put(`/house/${houseId}`, formHouseData.value);

            if (response.status === 200) {
                // Find the index of the updated house in the array
                const index = houses.value.findIndex(h => h.id === houseId);
                if (index !== -1) {
                    // Update the house in the local array with the response data
                    // (or formHouseData if the API doesn't return the updated object)
                    houses.value[index] = response.data; // Or use { ...formHouseData.value }
                }
                closeModal();
            } else {
                console.warn('House updated, but received status:', response.status);
            }
        } catch (error) {
            console.error(`Error updating house with ID ${editingHouse.value.id}:`, error);
            // Add user feedback for error
        }

    } else {
        // --- Create new house ---
        try {
            // Adjust '/house' to your actual API endpoint for creating
            // Exclude 'id' if it shouldn't be sent for creation
            // const payload = { ...formHouseData.value };
            // delete payload.id;

            const response = await axios.post('/house', formHouseData.value);

            if (response.status === 201 || response.status === 200) {
                // Add the newly created house (returned from API) to the list
                houses.value.push(response.data);
                closeModal();
            } else {
                console.warn('House added, but received status:', response.status);
            }
        } catch (error) {
            console.error('Error adding house:', error);
            // Add user feedback for error (e.g., display validation messages from error.response.data)
        }
    }
};


// Show confirmation before deleting
const confirmDeleteHouse = (house) => {
    if (confirm(`Are you sure you want to delete the house at ${house.address}?`)) {
        deleteHouse(house);
    }
};

// Delete a house
const deleteHouse = async (houseToDelete) => {
    if (!houseToDelete || !houseToDelete.id) {
        console.error("Cannot delete: House or house ID is missing.");
        return;
    }

    try {
        // Adjust '/house/{id}' to your actual API endpoint for deleting
        await axios.delete(`/house/${houseToDelete.id}`);

        // Remove the house from the reactive array after successful deletion
        houses.value = houses.value.filter(h => h.id !== houseToDelete.id);

        console.log(`House with ID ${houseToDelete.id} deleted successfully.`);
    } catch (error) {
        console.error(`Error deleting house with ID ${houseToDelete.id}:`, error);
        // Add user feedback here (e.g., show an error message)
    }
};

</script>
<template>
    <div>
        <!-- Optional: Add House Button -->
        <button @click="showAddModal = true"
            class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New House
        </button>

        <!-- Your Table -->
        <table class="min-w-full bg-white border border-gray-200" id="housesTable">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-3 px-4 border-b text-left">Dirección</th>
                    <th class="py-3 px-4 border-b text-left">Ciudad</th>
                    <th class="py-3 px-4 border-b text-left">País</th>
                    <th class="py-3 px-4 border-b text-left">Código Postal</th>
                    <th class="py-3 px-4 border-b text-left">Acciones</th>
                </tr>
            </thead>
            <tbody v-if="houses.length > 0">
                <!-- Loop through the reactive 'houses' array -->
                <!-- Use house.id for the key - IMPORTANT for Vue's rendering efficiency -->
                <tr v-for="house in houses" :key="house.id" class="hover:bg-gray-50">
                    <td class="py-3 px-4 border-b">{{ house.address }}</td>
                    <td class="py-3 px-4 border-b">{{ house.city }}</td>
                    <td class="py-3 px-4 border-b">{{ house.country }}</td>
                    <td class="py-3 px-4 border-b">{{ house.zip_code }}</td>
                    <td class="py-3 px-4 border-b">
                        <!-- Pass the specific 'house' object to the methods -->
                        <button @click="openEditModal(house)" class="text-blue-500 hover:text-blue-700 mr-2">
                            Editar
                        </button>
                        <button @click="confirmDeleteHouse(house)" class="text-red-500 hover:text-red-700">
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

        <!-- Add/Edit Modal (Example Structure - Implement as needed) -->
        <div v-if="showAddModal || editingHouse"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex justify-center items-center">
            <div class="bg-white p-5 rounded-lg shadow-xl w-1/3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                    {{ editingHouse ? 'Edit House' : 'Add New House' }}
                </h3>
                <!-- Your Form Fields Here -->
                <div>
                    <label>Address:</label>
                    <input type="text" v-model="formHouseData.address" class="border p-1 w-full mb-2">
                    <label>City:</label>
                    <input type="text" v-model="formHouseData.city" class="border p-1 w-full mb-2">
                    <label>Country:</label>
                    <input type="text" v-model="formHouseData.country" class="border p-1 w-full mb-2">
                    <label>Zip Code:</label>
                    <input type="text" v-model="formHouseData.zip_code" class="border p-1 w-full mb-2">
                </div>
                <div class="mt-4 flex justify-end">
                    <button @click="closeModal"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        Cancel
                    </button>
                    <button @click="saveHouse"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        {{ editingHouse ? 'Update' : 'Save' }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>



<style scoped>
/* Add any component-specific styles here if needed */
/* Tailwind classes are already applied in the template */
</style>