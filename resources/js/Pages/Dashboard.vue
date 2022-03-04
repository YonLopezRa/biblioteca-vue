<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ¡Bienvenido {{ $page.props.user.name }}! Estas loggeado como:
                {{ isPrestatario ? "Prestatario" : "Administrador" }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <v-container class="pa-9">
                        <v-row>
                            <v-col cols="6"
                                ><h3>
                                    Estos son los libros en la biblioteca
                                </h3></v-col
                            >
                            <v-col cols="6"
                            v-if="!isPrestatario"
                                ><v-btn
                                    outlined
                                    rounded
                                    text
                                    @click="setNuevoLibro()"
                                >
                                    {{
                                        nuevoLibro ? "Cerrar" : "Agregar"
                                    }}
                                    nuevo libro
                                </v-btn></v-col
                            >
                        </v-row>
                        <v-card v-if="nuevoLibro">
                            <v-card-title>
                                <span class="text-h5">{{modificar ? 'Modificar' : 'Nuevo'}} libro</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                label="Titulo del libro*"
                                                v-model="form.titulo"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                label="Autor*"
                                                v-model="form.autor"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="4">
                                            <v-text-field
                                                label="Editorial*"
                                                v-model="form.editorial"
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-textarea
                                                label="Descripción*"
                                                v-model="form.descripcion"
                                                required
                                            ></v-textarea>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>*Requeridos</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="nuevoLibro = false"
                                >
                                    Cancelar
                                </v-btn>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    :disabled="form.titulo == '' || form.autor == '' || form.editorial == '' || form.descripcion == '' "
                                    @click="guardarNuevoLibro"
                                >
                                    Guardar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                        <v-row v-if="isPrestatario">
                            <v-col cols="4" v-for="(libro, index) in libros" :key="index">
                        <v-card class="mx-auto mt-9" max-width="344" outlined >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="text-overline mb-4">
                                        Titulo : {{libro.titulo}}
                                    </div>
                                    <v-list-item-title class="text-h5 mb-1">
                                        Autor: {{libro.autor}}
                                    </v-list-item-title>
                                    <v-list-item-subtitle
                                        >Editorial: {{libro.editorial}}</v-list-item-subtitle
                                    >
                                    <v-list-item-subtitle
                                        >Descripción: {{libro.descripcion}}
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>

                            <v-card-actions>
                                <v-btn outlined  @click="rentarLibro(libro, isRented(libro))"> {{isRented(libro).rented ? 'Devolver' : 'Rentar'}} </v-btn>
                            </v-card-actions>
                        </v-card>
                        </v-col>
                        </v-row>
                        <v-row v-if="!isPrestatario">
                            <v-col cols="4" v-for="(libro, index) in libros" :key="index">
                        <v-card class="mx-auto mt-9" max-width="344" outlined >
                            <v-list-item three-line>
                                <v-list-item-content>
                                    <div class="text-overline mb-4">
                                        Titulo : {{libro.titulo}}
                                    </div>
                                    <v-list-item-title class="text-h5 mb-1">
                                        Autor: {{libro.autor}}
                                    </v-list-item-title>
                                    <v-list-item-subtitle
                                        >Editorial: {{libro.editorial}}</v-list-item-subtitle
                                    >
                                    <v-list-item-subtitle
                                        >Descripción: {{libro.descripcion}}
                                    </v-list-item-subtitle>
                                    <h3 v-if="libro.rentados.length > 0" class="mt-6">Rentado por:</h3>
                                    <v-list-item-subtitle
                                    v-for="(rentado, index) in libro.rentados" :key="index"
                                        >
                                      <strong> {{rentado.user.name}}</strong>  el: {{rentado.created_at}}
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>

                            <v-card-actions>
                                <v-btn outlined rounded text @click="setModificar(libro)"> Modificar </v-btn>
                                <v-btn
                                    outlined
                                    rounded
                                    text
                                    @click="eliminarLibro(libro.id)"
                                    color="red"
                                    class="ml-3"
                                >
                                    Eliminar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                        </v-col>
                        </v-row>

                    </v-container>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";

export default {
    name: "dashboardLibros",
    data() {
        return {
            isPrestatario: this.$page.props.user.prestatario || false,
            nuevoLibro: false,
            modificar: false,
            form: this.$inertia.form({
                id: null,
                titulo: "",
                autor: "",
                editorial: "",
                descripcion: "",
            }),
            formRenta: this.$inertia.form({
                id_usuario: null,
                id_libro: null,
            }),
        };
    },
    components: {
        AppLayout,
        Welcome,
    },
    props: {
        libros: {
            type: Array,
            default: () => [],
        },
        rentados: {
            type: Array,
            default: () => [],
        },
    },
    methods: {
        guardarNuevoLibro() {
            this.form.post(this.route("libros.store"), {
                onFinish: () =>
                    this.form.reset("password", "password_confirmation"),
            });
            this.nuevoLibro = false

        },
        eliminarLibro(id) {
            this.form.delete(route('libros.destroy', id), {
                onSuccess: () => {

                },
            })
        },
        setModificar(libro) {
            this.nuevoLibro = true;
            this.modificar = true;
            this.form.id = libro.id;
            this.form.titulo = libro.titulo;
            this.form.autor  = libro.autor;
            this.form.editorial = libro.editorial;
            this.form.descripcion  = libro.descripcion;
        },
        setNuevoLibro() {
            this.nuevoLibro = !this.nuevoLibro;
            this.modificar = false;
            this.form.id = null;
            this.form.titulo = '';
            this.form.autor  = '';
            this.form.editorial = '';
            this.form.descripcion  = '';
        },
        rentarLibro(libro, isRented) {
            if (isRented.rented) return this.eliminarRenta(isRented.whichRented);
            this.formRenta.id_usuario = this.$page.props.user.id;
            this.formRenta.id_libro = libro.id;
            this.formRenta.post(this.route("rentados.store"), {
                onFinish: () => {}
            });
        },
        isRented(libro) {
            const rented = this.rentados.filter(renta => renta.id_libro == libro.id);
            if(rented.length > 0) {
                return {
                    rented : true,
                    whichRented: rented[0],
                }
            }
            return {
                    rented : false,
                    whichRented: null,
                }
        },
        eliminarRenta(whichRented) {
            console.log(whichRented);
            this.formRenta.delete(route("rentados.destroy", whichRented.id), {
                onFinish: () => {}
            });
        }
    }
};
</script>
