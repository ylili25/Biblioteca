<template>
    <div>
        <filter-bar
            @filtrar="onFilterSet"
            @borrar-filtro="onFilterReset"
            @cambio-primera-pagina="onPerPageChange"
        />
        <div
            :class="alerta.tipo"
            role="alert"
            v-if="alerta.ver"
        >
            {{alerta.texto}}
        </div>
        <vuetable
            ref="vuetable"
            api-url="/libros"
            :fields="fields"
            :sort-order="sortOrder"
            :css="css.table"
            pagination-path=""
            :per-page="per_page"
            :append-params="moreParams"
            @vuetable:pagination-data="onPaginationData"
        >
            <template
                    slot="actions"
                    slot-scope="props"
            >
                <div class="text-center align-middle actions">
                    <a
                        class="btn btn-warning btn-sm"
                        data-toggle="tooltip"
                        title="Editar"
                        :href="`/libros/${props.rowData.id}/edit`"
                    >
                        Editar
                    </a>
                    <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        data-toggle="tooltip"
                        title="Eliminar"
                        @click="deleteRow(props.rowData.id)"
                    >
                        Eliminar
                    </button>
                </div>
            </template>
        </vuetable>
        <div class="row paginate">
            <div class="col-md-6">
                <vuetable-pagination-info
                ref="paginationInfo"
                info-template="Mostrando del {from} al {to} de un total de {total} registros"
                />
            </div>
            <div class="col-md-6 text-right">
                <vuetable-pagination
                ref="pagination"
                :css="css.pagination"
                @vuetable-pagination:change-page="onChangePage"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { Vuetable, VuetablePagination, VuetablePaginationInfo } from 'vuetable-2'
import FilterBar from '../components/FilterBar.vue'

export default {
    components:{
        FilterBar,
        Vuetable,
        VuetablePagination,
        VuetablePaginationInfo
    },
    data() {
        return {
            alerta: {
                ver: false,
                tipo: null,
                texto: null,
            },
            fields: [
                {
                    name: 'id',
                    title: 'Id',
                    sortField: 'id',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: 'nombre',
                    title: 'Nombre',
                    sortField: 'nombre',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: 'autor',
                    title: 'Autor',
                    sortField: 'autor',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: 'isbn',
                    title: 'Isbn',
                    sortField: 'isbn',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: 'cantidad',
                    title: 'Cantidad',
                    sortField: 'cantidad',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: 'fecha_publicacion',
                    title: 'Fecha de Publicación',
                    sortField: 'fecha_publicacion',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: 'editorial.nombre',
                    title: 'Editorial',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: '__slot:actions',
                    title: 'Acciones',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                 }
            ],
            sortOrder: [{
                field: 'id',
                direction: 'asc'
            }],
            moreParams: {
                query: ''
            },
            per_page: 10,
            css: {
                table: {
                    tableClass: 'table table-striped table-bordered table-sm table-hover',
                    loadingClass: 'loading',
                    ascendingIcon: 'fa fa-chevron-up',
                    descendingIcon: 'fa fa-chevron-down',
                    handleIcon: 'fa fa-bars'
                },
                pagination: {
                    infoClass: '',
                    wrapperClass: 'vuetable-pagination',
                    activeClass: 'btn-info',
                    disabledClass: 'disabled',
                    pageClass: 'btn btn-border',
                    linkClass: 'btn btn-border',
                    icons: {
                        first: '',
                        prev: '',
                        next: '',
                        last: ''
                    }
                }
            }
        }
    },
    methods:{
        onPaginationData (paginationData) {
            this.$refs.pagination.setPaginationData(paginationData)
            this.$refs.paginationInfo.setPaginationData(paginationData)
        },
        onChangePage (page) {
            this.$refs.vuetable.changePage(page)
        },
        async deleteRow(libro_id) {
            try {
                let response = await axios.delete(`/libros/${libro_id}`)

                this.alerta.ver = true
                this.alerta.tipo = 'alert alert-success'
                this.alerta.texto = response.data.message
                Vue.nextTick(() => this.$refs.vuetable.refresh())
            } catch (error) {
                this.alerta.ver = true
                this.alerta.tipo = 'alert alert-danger'
                this.alerta.texto = 'No se pudo eliminar el libro'
            }
        },
        onFilterSet (filterText) {
            this.moreParams = {
                query: filterText
            }
            Vue.nextTick(() => this.$refs.vuetable.refresh())
        },
        onFilterReset () {
            this.moreParams = {
                query: ''
            }
            Vue.nextTick(() => this.$refs.vuetable.refresh())
        },
        onPerPageChange (perPage) {
            this.per_page = perPage
            Vue.nextTick(() => this.$refs.vuetable.refresh())
        }
    }
}
</script>
