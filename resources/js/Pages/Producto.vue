<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';
import { defineProps } from 'vue';
import { onMounted } from 'vue';

const props = defineProps({
    products: {
        type: Array,
        required: true
    }
});
const currentSlide = ref(1);

// Estados de los modales
const showAddModal = ref(false);
const showEditModal = ref(false);
const currentProductIndex = ref(null);

// Formularios
const newProduct = ref({
    name: '',
    description: '',
    price: 0,
    stock: 0,
    category: ''
});

const editProduct = ref({
    id: null,
    name: '',
    description: '',
    price: 0,
    stock: 0,
    category: ''
});

// Métodos
const openAddModal = () => {
    newProduct.value = {
        name: '',
        description: '',
        price: 0,
        stock: 0,
        category: ''
    };
    showAddModal.value = true;
};

const openEditModal = (index) => {
    currentProductIndex.value = index;
    const product = props.products[index];
    editProduct.value = {
        id: product.id,
        name: product.name,
        description: product.description,
        price: product.price,
        stock: product.stock,
        category: product.category
    };
    showEditModal.value = true;
};

const closeAddModal = () => {
    showAddModal.value = false;
};

const closeEditModal = () => {
    showEditModal.value = false;
};

const submitNewProduct = async () => {
    const fromData = {
        name: newProduct.value.name,
        description: newProduct.value.description,
        price: newProduct.value.price,
        stock: newProduct.value.stock,
        category: newProduct.value.category
    };
    try {
        const response = await axios.post('/products', fromData);
        Inertia.visit('/products')
        closeAddModal();
    } catch (error) {
        console.error('Error al crear producto:', error);
    }
};

const submitEditProduct = async () => {
    const formData = {
        id: editProduct.value.id,
        name: editProduct.value.name,
        description: editProduct.value.description,
        price: editProduct.value.price,
        stock: editProduct.value.stock,
        category: editProduct.value.category
    };
    try {
        const id = editProduct.value.id;
        const result = await axios.put(`/products/${id}`, formData);
        if (result.status === 200) {
            const index = props.products.findIndex(product => product.id === id);
            if (index !== -1) {
                props.products[index] = { ...props.products[index], ...formData };
            }
        }
        closeEditModal();
    } catch (error) {
        console.error('Error al actualizar producto:', error);
    }
};

const loadProducts = async () => {
    try {
        const response = await axios.get(route('products.index'));
        products.value = response.data.products
    }
    catch (error) {
        console.error(error);
    }
}

const deleteProduct = async (index) => {
    if (confirm('¿Estas seguro de eliminar el producto?')) {
        try {
            const id = props.products[index].id;
            await axios.delete(`/products/${id}`);
            props.products.splice(index, 1);
        } catch (error) {
            console.error('Error al eliminar producto:', error);
        }
    }
};
const plusSlides = (n) => {
    let newIndex = currentSlide.value + n;
    const slides = document.getElementsByClassName("mySlides");
    if (newIndex > slides.length) {
        newIndex = 1;
    }
    if (newIndex < 1) {
        newIndex = slides.length;
    }
    currentSlide.value = newIndex;
    showSlides();
};

const setCurrentSlide = (n) => {
    currentSlide.value = n;
    showSlides();
};

const showSlides = () => {
    let i;
    const slides = document.getElementsByClassName("mySlides");
    const dots = document.getElementsByClassName("dot");

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    if (slides.length > 0) {
        slides[currentSlide.value - 1].style.display = "block";
        dots[currentSlide.value - 1].className += " active";
    }
};

// Initialize slideshow when component mounts
onMounted(() => {
    showSlides();
});
</script>

<template>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Gestión de Productos</h1>

        <!-- Botón para abrir el modal de añadir -->
        <button @click="openAddModal" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-6">
            Añadir Producto
        </button>

        <!-- Tabla de productos -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-4 border-b text-left">Nombre</th>
                        <th class="py-3 px-4 border-b text-left">Descripción</th>
                        <th class="py-3 px-4 border-b text-left">Precio</th>
                        <th class="py-3 px-4 border-b text-left">Stock</th>
                        <th class="py-3 px-4 border-b text-left">Categoría</th>
                        <th class="py-3 px-4 border-b text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">{{ product.name }}</td>
                        <td class="py-3 px-4 border-b">{{ product.description }}</td>
                        <td class="py-3 px-4 border-b">${{ product.price }}</td>
                        <td class="py-3 px-4 border-b">{{ product.stock }}</td>
                        <td class="py-3 px-4 border-b">{{ product.category }}</td>
                        <td class="py-3 px-4 border-b">
                            <button @click="openEditModal(index)" class="text-blue-500 hover:text-blue-700 mr-2">
                                Editar
                            </button>
                            <button @click="deleteProduct(index)" class="text-red-500 hover:text-red-700">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal para añadir producto -->
        <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Añadir Nuevo Producto</h2>

                <form @submit.prevent="submitNewProduct">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="new-name">Nombre</label>
                        <input v-model="newProduct.name" type="text" id="new-name"
                            class="w-full px-3 py-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="new-description">Descripción</label>
                        <textarea v-model="newProduct.description" id="new-description"
                            class="w-full px-3 py-2 border rounded" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="new-price">Precio</label>
                        <input v-model="newProduct.price" type="number" id="new-price" step="0.01" min="0"
                            class="w-full px-3 py-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="new-stock">Stock</label>
                        <input v-model="newProduct.stock" type="number" id="new-stock" min="0"
                            class="w-full px-3 py-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="new-category">Categoría</label>
                        <select v-model="newProduct.category" id="new-category" class="w-full px-3 py-2 border rounded">
                            <option value="">Seleccione una categoría</option>
                            <option value="Electrónicos">Electrónicos</option>
                            <option value="Ropa">Ropa</option>
                            <option value="Hogar">Hogar</option>
                            <option value="Alimentos">Alimentos</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="closeAddModal" class="mr-2 px-4 py-2 border rounded">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal para editar producto -->
        <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Editar Producto</h2>

                <form @submit.prevent="submitEditProduct">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="edit-name">Nombre</label>
                        <input v-model="editProduct.name" type="text" id="edit-name"
                            class="w-full px-3 py-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="edit-description">Descripción</label>
                        <textarea v-model="editProduct.description" id="edit-description"
                            class="w-full px-3 py-2 border rounded" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="edit-price">Precio</label>
                        <input v-model="editProduct.price" type="number" id="edit-price" step="0.01" min="0"
                            class="w-full px-3 py-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="edit-stock">Stock</label>
                        <input v-model="editProduct.stock" type="number" id="edit-stock" min="0"
                            class="w-full px-3 py-2 border rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2" for="edit-category">Categoría</label>
                        <select v-model="editProduct.category" id="edit-category"
                            class="w-full px-3 py-2 border rounded">
                            <option value="">Seleccione una categoría</option>
                            <option value="Electrónicos">Electrónicos</option>
                            <option value="Ropa">Ropa</option>
                            <option value="Hogar">Hogar</option>
                            <option value="Alimentos">Alimentos</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" @click="closeEditModal" class="mr-2 px-4 py-2 border rounded">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Slideshow container -->
        <div class="slideshow-container">
            <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">
                <div class="numbertext">1 / 3</div>
                <img src="/img/img1.png" style="width:100%">
                <div class="text">Caption Text</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">2 / 3</div>
                <img src="/img/img2.jpg" style="width:100%">
                <div class="text">Caption Two</div>
            </div>

            <div class="mySlides fade">
                <div class="numbertext">3 / 3</div>
                <img src="/img/img3.jpg" style="width:100%">
                <div class="text">Caption Three</div>
            </div>

            <!-- Next and previous buttons - changed to @click -->
            <a class="prev" @click="plusSlides(-1)">&#10094;</a>
            <a class="next" @click="plusSlides(1)">&#10095;</a>
        </div>
        <br>

        <!-- The dots/circles - changed to @click -->
        <div style="text-align:center">
            <span class="dot" @click="setCurrentSlide(1)"></span>
            <span class="dot" @click="setCurrentSlide(2)"></span>
            <span class="dot" @click="setCurrentSlide(3)"></span>
        </div>
    </div>
</template>
<style scoped>
* {
    box-sizing: border-box
}

/* Slideshow container */
.slideshow-container {
    max-width: 1000px;
    position: relative;
    margin: auto;
}

/* Hide the images by default */
.mySlides {
    display: none;
}

/* Next & previous buttons */
.prev,
.next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    margin-top: -22px;
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
}

/* Position the "next button" to the right */
.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

/* Caption text */
.text {
    color: #f2f2f2;
    font-size: 15px;
    padding: 8px 12px;
    position: absolute;
    bottom: 8px;
    width: 100%;
    text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
}

/* The dots/bullets/indicators */
.dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}

.active,
.dot:hover {
    background-color: #717171;
}

/* Fading animation */
.fade {
    animation-name: fade;
    animation-duration: 1.5s;
}

@keyframes fade {
    from {
        opacity: .4
    }

    to {
        opacity: 1
    }
}
</style>