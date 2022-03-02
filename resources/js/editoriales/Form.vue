<template>
    <form @submit.prevent="submit">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="mb-0">{{ titulo }}</h3>
                    <a href="/editoriales" class="btn btn-primary">Regresar</a>
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
                <div class="row">
                    <div class="col-12">
                        <label>Nombre</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ingresar nombre"
                            v-model="editorial.nombre"
                        >
                        <div v-for="error in errores.nombre" :key=error>
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
                <a href="/editoriales" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    props:['editorial_id'],
    async mounted(){
        if (this.editorial_id) {
            await this.buscarEditorial()
        }
    },
    data() {
        return {
            alerta:{
                ver: false,
                tipo: null,
                texto: null
            },
            editorial:{
                id: null,
                nombre: null
            },
            errores: {}
        }
    },
    computed:{
        titulo(){
            return (this.editorial_id)
            ? 'Editar Editorial'
            : 'Nueva Editorial'
        }
    },
    methods:{
        async buscarEditorial(){
            try {
                let response = await axios.get(`/editoriales/${this.editorial_id}`)

                this.editorial.id     = response.data.id
                this.editorial.nombre = response.data.nombre

            } catch (error) {
                this.editorial = {
                    id: null,
                    nombre: null
                }
            }
        },
        async submit(){
            try {
                let data = (this.editorial.id)
                ? await axios.put(`/editoriales/${this.editorial.id}`, this.editorial)
                : await axios.post('/editoriales', this.editorial)

                this.alerta.ver = true
                this.alerta.tipo = 'alert alert-success'
                this.alerta.texto = data.data.message
                this.errores = {}
            } catch (error) {
                this.alerta.ver = true
                this.alerta.tipo = 'alert alert-danger'
                this.alerta.texto = 'No se pudo guardar la editorial'
                this.errores = error.response.data.errors
            }
        }
    }
}
</script>
