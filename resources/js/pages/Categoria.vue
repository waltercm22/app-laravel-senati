<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { FileText, Pencil, Plus, Save, SquareX, Trash2 } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';

const categorias = ref([]);
const miNombre = ref('');
const mostrarModal = ref(false);
const mostrarModalEditar = ref(false);
const idCategoria = ref();

//Formulario
const formulario = ref({
    nombre_categoria: '',
    descripcion: '',
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categoria',
        href: dashboard().url,
    },
];

const listarCategoria = async () => {
    try {
        const repuesta = await axios.get('/categorias-data');
        console.log(repuesta);
        if (repuesta.data.success) {
            categorias.value = repuesta.data.data;
            miNombre.value = repuesta.data.nombre;
        }
    } catch (error: any) {}
};

const abrirModal = () => {
    mostrarModal.value = true;
};

const cerrarModal = () => {
    mostrarModal.value = false;
};

//funciones para manipular el modal editar
const abrirModalEditar = ( dataCategoria : any ) => {
    mostrarModalEditar.value = true;
    idCategoria.value = dataCategoria.id;

    console.log(dataCategoria.nombre_categoria);
    console.log(dataCategoria.descripcion);
    console.log(dataCategoria);

    formulario.value.nombre_categoria = dataCategoria.nombre_categoria;
    formulario.value.descripcion = dataCategoria.descripcion;

};

const cerrarModalEditar = () => {
    mostrarModalEditar.value = false;
};


const enviarFormulario = async () => {
    console.log('Walter Molina');
    console.log(formulario.value);

    const respuesta = await axios.post('/categorias-data', formulario.value);
    if (respuesta.data.success) {
        Swal.fire({
            title: 'Recurso Creado',
            text: 'Categoria Creada',
            icon: 'success',
        });
        mostrarModal.value = false;
        listarCategoria();
    } else {
        Swal.fire({
            title: 'Error al crear',
            text: 'Categoria no creada',
            icon: 'error',
        });
    }
};

const exportarPdf = () =>{
    const url = '/categorias-data-pdf';
    window.location.href = url;
}


const actualizarFormulario = async () => {
    console.log('Walter Molina');
    console.log(formulario.value);

    const respuesta = await axios.put(`/categorias-data/${idCategoria.value}`, formulario.value);
    if (respuesta.data.success) {
        Swal.fire({
            title: 'Recurso Actualizado',
            text: 'Categoria Actualizada',
            icon: 'success',
        });
        mostrarModalEditar.value = false;
        listarCategoria();
    } else {
        Swal.fire({
            title: 'Error al actualizar',
            text: 'Categoria no actualizada',
            icon: 'error',
        });
    }
};

const eliminarCategoria = async (id: number) => {
    const respuesta = await axios.delete(`/categorias-data/${id}`);
    console.log(respuesta);
    if (respuesta.data.success) {
        Swal.fire({
            title: 'Recurso Eliminado',
            text: 'Categoria Eliminada',
            icon: 'success',
        });
    }
    listarCategoria();
};

const confirmacion = (id: number) => {
    Swal.fire({
        title: 'Estas Seguro?',
        text: 'El recurso se eliminará de forma permanente',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Apectar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarCategoria(id);
        }
    });
};

onMounted(listarCategoria);
</script>

<template>
    <Head title="Categoria" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col items-center justify-center">
            <div class="mt-4">
                <p class="text-2xl text-amber-600">Gestión Categoria 😼</p>
                <small>{{ miNombre }}</small>
            </div>
            <div>
                <!-- Modal registro categoria -->
                <div
                    class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="modalTitle"
                    v-if="mostrarModal"
                >
                    <div
                        class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-900"
                    >
                        <h2
                            id="modalTitle"
                            class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white"
                        >
                            Registro Categoria
                        </h2>

                        <form class="mt-4" @submit.prevent="enviarFormulario">
                            <div class="mb-3">
                                <label for="nombre_categoria">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Nombre
                                    </span>
                                    <input
                                        type="text"
                                        id="nombre_categoria"
                                        v-model="formulario.nombre_categoria"
                                        class="mt-0.5 w-full rounded border-gray-300 p-2 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                    />
                                </label>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Descripcion
                                    </span>
                                    <input
                                        type="text"
                                        id="descripcion"
                                        v-model="formulario.descripcion"
                                        class="mt-0.5 w-full rounded border-gray-300 p-2 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                    />
                                </label>
                            </div>
                            <footer class="mt-6 flex justify-end gap-2">
                                <button
                                    type="button"
                                    class="flex items-center justify-center gap-2 rounded bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                                    @click="cerrarModal"
                                >
                                    <SquareX /> Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="flex items-center justify-center gap-2 rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                                >
                                    <Save /> Guardar
                                </button>
                            </footer>
                        </form>
                    </div>
                </div>

                <!-- Modal Editar Categoria -->
                <div
                    class="fixed inset-0 z-50 grid place-content-center bg-black/50 p-4"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="modalTitle"
                    v-if="mostrarModalEditar"
                >
                    <div
                        class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-900"
                    >
                        <h2
                            id="modalTitle"
                            class="text-xl font-bold text-gray-900 sm:text-2xl dark:text-white"
                        >
                            Editar Categoria
                        </h2>

                        <form class="mt-4" @submit.prevent="actualizarFormulario">
                            <div class="mb-3">
                                <label for="nombre_categoria">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Nombre
                                    </span>
                                    <input
                                        type="text"
                                        id="nombre_categoria"
                                        v-model="formulario.nombre_categoria"
                                        class="mt-0.5 w-full rounded border-gray-300 p-2 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                    />
                                </label>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                    >
                                        Descripcion
                                    </span>
                                    <input
                                        type="text"
                                        id="descripcion"
                                        v-model="formulario.descripcion"
                                        class="mt-0.5 w-full rounded border-gray-300 p-2 shadow-sm sm:text-sm dark:border-gray-600 dark:bg-gray-900 dark:text-white"
                                    />
                                </label>
                            </div>
                            <footer class="mt-6 flex justify-end gap-2">
                                <button
                                    type="button"
                                    class="flex items-center justify-center gap-2 rounded bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                                    @click="cerrarModalEditar"
                                >
                                    <SquareX /> Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="flex items-center justify-center gap-2 rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700"
                                >
                                    <Save /> Guardar
                                </button>
                            </footer>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-2 md:mx-10 lg:mx-20">
            <div class="mb-3 flex flex-row gap-4">
                <a
                    class="group relative inline-flex items-center overflow-hidden rounded-sm border border-current px-8 py-3 text-indigo-600 dark:text-white"
                    href="#"
                    @click="abrirModal"
                >
                    <span
                        class="absolute -start-full transition-all group-hover:start-4"
                    >
                        <Plus />
                    </span>
                    <span
                        class="text-sm font-medium transition-all group-hover:ms-4"
                    >
                        Agregar
                    </span>
                </a>
                <a
                    class="group relative inline-flex items-center overflow-hidden rounded-sm border border-current px-8 py-3 text-amber-800 dark:text-white"
                    href="#"
                    @click="exportarPdf"
                >
                    <span
                        class="absolute -start-full transition-all group-hover:start-4"
                    >
                        <FileText />
                    </span>
                    <span
                        class="text-sm font-medium transition-all group-hover:ms-4"
                    >
                        Exportar PDF
                    </span>
                </a>
            </div>

            <div
                class="bg-neutral-primary-soft rounded-base border-default relative overflow-x-auto border shadow-xs"
            >
                <table
                    class="text-body w-full text-left text-sm rtl:text-right"
                >
                    <thead
                        class="text-body bg-neutral-secondary-soft rounded-base border-default border-b text-sm"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Descripción
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 font-medium">
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in categorias"
                            :key="item.id"
                            class="bg-neutral-primary border-default border-b"
                        >
                            <th
                                scope="row"
                                class="text-heading px-6 py-4 font-medium whitespace-nowrap"
                            >
                                {{ item.nombre_categoria }}
                            </th>
                            <td class="px-6 py-4">{{ item.descripcion }}</td>
                            <td class="px-6 py-4">{{ item.estado }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-row gap-4">
                                    <a
                                        class="inline-block rounded-sm border border-current px-8 py-3 text-sm text-indigo-600 transition hover:scale-110 hover:rotate-2"
                                        href="#"
                                        @click="abrirModalEditar(item)"
                                    >
                                        <Pencil />
                                    </a>
                                    <a
                                        class="inline-block rounded-sm border border-current px-8 py-3 text-sm font-medium text-rose-600 transition hover:scale-110 hover:rotate-2"
                                        href="#"
                                        @click="confirmacion(item.id)"
                                    >
                                        <Trash2 />
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>