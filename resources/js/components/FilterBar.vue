<template>
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-12 col-xs-12 col-md-4 col-xl-4 col-lg-4">
            <span>Mostrar </span>
            <select @change="cambiarPrimeraPagina">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <span> registros</span>
        </div>
        <div class="col-12 col-xs-12 col-md-6 col-xl-4 col-lg-4">
            <div class="input-group">
                <input type="text" class="form-control"
                    v-model="filterText"
                    @keyup.enter="filtrar"
                    placeholder="ingrese texto para buscar..."
                />
                <button
                    type="button"
                    class="btn btn-light"
                    @click="borrarFiltro"
                >
                    Borrar
                </button>
                <button
                    type="button"
                    class="btn btn-primary"
                    @click="filtrar"
                >
                    Buscar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                filterText: '',
                perPage: 10
            };
        },
        methods: {
            filtrar() {
                this.$emit('filtrar', this.filterText);
            },
            borrarFiltro() {
                this.filterText = '';
                this.$emit('borrar-filtro');
            },
            cambiarPrimeraPagina(e) {
                this.perPage = Number(e.target.value);
                this.$emit('cambio-primera-pagina', this.perPage);
            }
        }
    };
</script>
