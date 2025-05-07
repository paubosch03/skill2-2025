<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-light tracking-wide text-gray-700">
                Panel de Control
            </h2>
        </template>

        <div class="py-12 bg-gray-50">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="space-y-6">
                    <!-- Tarjeta de bienvenida -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Bienvenido al sistema</h3>
                            <p class="text-gray-600">Seleccione una categoría para comenzar</p>
                        </div>
                    </div>

                    <!-- Grid de opciones -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Producto -->
                        <a href="/Producto" class="group block transition-all duration-200 hover:scale-[1.02]">
                            <div
                                class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-blue-50 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Productos</h3>
                                <p class="text-gray-500 text-sm flex-grow">Gestión de inventario y productos</p>
                                <span class="mt-4 inline-flex items-center text-blue-600 group-hover:underline text-sm">
                                    Acceder
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </a>

                        <!-- Car -->
                        <a href="/Car" class="group block transition-all duration-200 hover:scale-[1.02]">
                            <div
                                class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-indigo-50 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Vehículos</h3>
                                <p class="text-gray-500 text-sm flex-grow">Gestión de automóviles y transporte</p>
                                <span
                                    class="mt-4 inline-flex items-center text-indigo-600 group-hover:underline text-sm">
                                    Acceder
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </a>

                        <!-- House -->
                        <a href="/House" class="group block transition-all duration-200 hover:scale-[1.02]">
                            <div
                                class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-teal-50 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Inmuebles</h3>
                                <p class="text-gray-500 text-sm flex-grow">Gestión de propiedades y viviendas</p>
                                <span class="mt-4 inline-flex items-center text-teal-600 group-hover:underline text-sm">
                                    Acceder
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </a>

                        <!-- Appliance -->
                        <a href="/Appliance" class="group block transition-all duration-200 hover:scale-[1.02]">
                            <div
                                class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-amber-50 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Electrodomésticos</h3>
                                <p class="text-gray-500 text-sm flex-grow">Gestión de dispositivos electrónicos</p>
                                <span
                                    class="mt-4 inline-flex items-center text-amber-600 group-hover:underline text-sm">
                                    Acceder
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </a>

                        <!-- Clothes -->
                        <a href="/Clothes" class="group block transition-all duration-200 hover:scale-[1.02]">
                            <div
                                class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-rose-50 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Moda</h3>
                                <p class="text-gray-500 text-sm flex-grow">Gestión de prendas y accesorios</p>
                                <span class="mt-4 inline-flex items-center text-rose-600 group-hover:underline text-sm">
                                    Acceder
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </a>

                        <a href="/City" class="group block transition-all duration-200 hover:scale-[1.02]">
                            <div
                                class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-rose-50 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 21V9a1 1 0 011-1h3V5a1 1 0 011-1h6a1 1 0 011 1v3h3a1 1 0 011 1v12M9 21V12h6v9" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Ciudades</h3>
                                <p class="text-gray-500 text-sm flex-grow">Gestión de Ciudades</p>
                                <span class="mt-4 inline-flex items-center text-rose-600 group-hover:underline text-sm">
                                    Acceder
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </a>
                        <!-- Wheel -->
                        <a href="/Wheels" class="group block transition-all duration-200 hover:scale-[1.02]">
                            <div
                                class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-rose-50 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 4a6 6 0 110 12 6 6 0 010-12zm0 3a3 3 0 100 6 3 3 0 000-6z" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Ruedas</h3>
                                <p class="text-gray-500 text-sm flex-grow">Gestión de Ruedas</p>
                                <span class="mt-4 inline-flex items-center text-rose-600 group-hover:underline text-sm">
                                    Acceder
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </a>

                        <!-- Bicycle -->
                        <a href="/Bikes" class="group block transition-all duration-200 hover:scale-[1.02]">
                            <div
                                class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-green-50 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 17a4 4 0 100-8 4 4 0 000 8zm14 0a4 4 0 100-8 4 4 0 000 8zM5 17l4-4m0 0l4 4m-4-4l4-4m6 8h-3m-3-4h3l3-3" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Bicicletas</h3>
                                <p class="text-gray-500 text-sm flex-grow">Gestión de bicicletas</p>
                                <span class="mt-4 inline-flex items-center text-green-600 group-hover:underline text-sm">
                                    Acceder
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </a>
                        <!--Sports-->
                        <a href="/sport" class="group block transition-all duration-200 hover:scale-[1.02]">
                            <div
                                class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md h-full flex flex-col">
                                <div class="flex items-center mb-4">
                                    <div class="bg-green-50 p-3 rounded-full">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 4a6 6 0 110 12 6 6 0 010-12zm0 3a3 3 0 100 6 3 3 0 000-6z" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Deportes</h3>
                                <p class="text-gray-500 text-sm flex-grow">Gestión de deportes</p>
                                <span class="mt-4 inline-flex items-center text-green-600 group-hover:underline text-sm">
                                    Acceder
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </a>
                        <!-- Espacio para futuras opciones -->
                        <div
                            class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-full flex flex-col items-center justify-center">
                            <div class="text-gray-400 mb-2">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm">Nueva categoría</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>