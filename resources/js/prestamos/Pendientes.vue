<template>
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Mis prestamos</h3>
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
            <table class="table table-bordered" v-if="prestamos.length">
                <thead>
                    <th class="text-center">Libro</th>
                    <th class="text-center">Editorial</th>
                    <th class="text-center">Autor</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Acciones</th>
                </thead>
                <tbody>
                    <tr v-for="prestamo in prestamos" :key="prestamo.id">
                        <td class="text-center">
                            {{ prestamo.libro.nombre }}
                        </td>
                        <td class="text-center">
                            {{ prestamo.libro.editorial.nombre }}
                        </td>
                        <td class="text-center">
                            {{ prestamo.libro.autor }}
                        </td>
                        <td class="text-center">
                            {{ prestamo.libro.created_at }}
                        </td>
                        <td class="text-center">
                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                @click="devolverPrestamo(prestamo)"
                            >
                                Devolver
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="alert alert-warning">
                No hay prestamos registrados
            </div>
        </div>
    </div>
</template>

<script>
export default {
    async mounted(){
        await this.listadoPrestamos()
    },
    data(){
        return {
            alerta: {
                ver: false,
                tipo: null,
                texto: null
            },
            prestamos: []
        }
    },
    methods:{
        async devolverPrestamo(prestamo){
            try {
                let response = await axios.put(`/prestamos/${prestamo.id}`, prestamo)

                this.alerta.ver = true
                this.alerta.tipo = 'alert alert-success'
                this.alerta.texto = response.data.message
                await this.listadoPrestamos()
            } catch (error) {
                 this.alerta.ver = true
                this.alerta.tipo = 'alert alert-danger'
                this.alerta.texto = 'No se pudo devolver el prestamo'
            }
        },
        async listadoPrestamos(){
            try {
                let response = await axios.get('/prestamos/pendientes')
                this.prestamos = response.data
            } catch (error) {
                this.prestamos = []
            }
        }
    }
}
</script>
