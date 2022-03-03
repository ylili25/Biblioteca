<template>
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Nuevo prestamo</h3>
        </div>
        <div class="card-body">
            <div
                :class="`${alerta.tipo} d-flex justify-content-between`"
                role="alert"
                v-if="alerta.ver"
            >
                {{alerta.texto}}
                <button
                    type="button"
                    class="btn-close"
                    @click="alerta.ver = false"
                ></button>
            </div>
            <div class="row  gy-3">
                <div
                    class="col-4"
                    v-for="libro in libros"
                    :key="libro.id"
                >
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ libro.nombre }}</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-center">
                                <b>{{ libro.autor }}</b>
                            </h6>
                            <p class="card-text mb-1">
                                <b>Editorial:</b> {{ libro.editorial.nombre }}
                            </p>
                            <p class="card-text mb-1">
                                <b>ISBN:</b> {{ libro.isbn }}
                            </p>
                            <p class="card-text">
                                <b>Cantidad:</b>
                                <span class="badge bg-primary">{{ libro.cantidad }}</span>
                            </p>
                            <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-success btn-sm"
                                    @click="submit(libro.id)"
                                    :disabled="libro.cantidad === 0"
                                >
                                    Pedir prestado
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    async mounted(){
       await this.listadoLibros()
    },
    data() {
        return {
            alerta:{
                ver: false,
                tipo: null,
                texto: null
            },
            libros: [],
            errores: {}
        }
    },
    methods:{
        async listadoLibros(){
            try {
                let response = await axios.get('/listado/libros')
                this.libros = response.data
            } catch (error) {
                this.libros = []
            }
        },
        async submit(libro_id){
            try {
                let data = await axios.post('/prestamos', {
                    libro_id,
                    estado: 'Entregado'
                })

                this.alerta.ver = true
                this.alerta.tipo = 'alert alert-success'
                this.alerta.texto = data.data.message
                this.errores = {}
                await this.listadoLibros()
            } catch (error) {
                this.alerta.ver = true
                this.alerta.tipo = 'alert alert-danger'
                this.alerta.texto = 'No se pudo guardar el prestamo'
            }
        }
    }
}
</script>
