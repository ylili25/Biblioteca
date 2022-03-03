<template>
    <form @submit.prevent="submit">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="mb-0">{{ titulo }}</h3>
                    <a href="/libros" class="btn btn-primary">Regresar</a>
                </div>
            </div>
            <div class="card-body">
                <div
                    :class="alerta.tipo"
                    role="alert"
                    v-if="alerta.ver"
                >
                    {{alerta.texto}}
                </div>
                <div class="row  gy-3">
                    <div class="col-6">
                        <label>Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ingresar nombre"
                            v-model="libro.nombre"
                        >
                        <div v-for="error in errores.nombre" :key=error>
                            <strong class="text-danger">{{error}}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Autor</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ingresar autor"
                            v-model="libro.autor"
                        >
                        <div v-for="error in errores.autor" :key=error>
                            <strong class="text-danger">{{error}}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Isbn</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ingresar isbn"
                            v-model="libro.isbn"
                        >
                        <div v-for="error in errores.isbn" :key=error>
                            <strong class="text-danger">{{error}}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Cantidad</label>
                        <input
                            type="number"
                            class="form-control"
                            placeholder="Ingresar cantidad"
                            v-model="libro.cantidad"
                        >
                        <div v-for="error in errores.cantidad" :key=error>
                            <strong class="text-danger">{{error}}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Fecha_publicación</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="libro.fecha_publicacion"
                        >
                        <div v-for="error in errores.fecha_publicacion" :key=error>
                            <strong class="text-danger">{{error}}</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Editorial</label>
                        <select
                            class="form-control"
                            v-model="libro.editorial_id"
                        >
                        <option :value="null">Seleccionar....</option>
                        <option
                            v-for="editorial in editoriales" :key="editorial.id"
                            :value="editorial.id"
                        >
                            {{ editorial.nombre }}
                        </option>
                        </select>
                        <div v-for="error in errores.editorial_id" :key=error>
                            <strong class="text-danger">{{error}}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button
                    class="btn btn-success"
                    type="submit"
                >
                    Guardar
                </button>
                <a href="/libros" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    props:['libro_id'],
    async mounted(){
        await this.listadoEditoriales()
        if (this.libro_id) {
            await this.buscarLibro()
        }
    },
    data() {
        return {
            alerta:{
                ver: false,
                tipo: null,
                texto: null
            },
            libro:{
                id: null,
                nombre: null,
                autor: null,
                isbn: null,
                cantidad: null,
                fecha_publicacion: null,
                editorial_id: null
            },
            editoriales:[],
            errores: {}
        }
    },
    computed:{
        titulo(){
            return (this.libro_id)
            ? 'Editar Libro'
            : 'Nuevo Libro'
        }
    },
    methods:{
        async buscarLibro(){
            try {
                let response = await axios.get(`/libros/${this.libro_id}`)

                this.libro.id                = response.data.id
                this.libro.nombre            = response.data.nombre
                this.libro.autor             = response.data.autor
                this.libro.isbn              = response.data.isbn
                this.libro.cantidad          = response.data.cantidad
                this.libro.fecha_publicacion = response.data.fecha_publicacion
                this.libro.editorial_id      = response.data.editorial_id

            } catch (error) {
                this.libro = {
                    id: null,
                    nombre: null,
                    autor: null,
                    isbn: null,
                    cantidad: null,
                    fecha_publicacion: null,
                    editorial_id: null
                }
            }
        },
        async listadoEditoriales(){
            try {
                let response = await axios.get('/editoriales/listado')
                    this.editoriales = response.data
            } catch (error) {
                this.editoriales = []
            }
        },
        async submit(){
            try {
                let data = (this.libro.id)
                ? await axios.put(`/libros/${this.libro.id}`, this.libro)
                : await axios.post('/libros', this.libro)

                this.alerta.ver = true
                this.alerta.tipo = 'alert alert-success'
                this.alerta.texto = data.data.message
                this.errores = {}
            } catch (error) {
                this.alerta.ver = true
                this.alerta.tipo = 'alert alert-danger'
                this.alerta.texto = 'No se pudo guardar el libro'
                this.errores = error.response.data.errors
            }
        }
    }
}
</script>
