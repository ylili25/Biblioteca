<template>
    <div>
        <filter-bar
            @filtrar="onFilterSet"
            @borrar-filtro="onFilterReset"
            @cambio-primera-pagina="onPerPageChange"
        />
        <vuetable
            ref="vuetable"
            api-url="/prestamos"
            :fields="fields"
            :sort-order="sortOrder"
            :css="css.table"
            pagination-path=""
            :per-page="per_page"
            :append-params="moreParams"
            @vuetable:pagination-data="onPaginationData"
        />
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
            fields: [
                {
                    name: 'user.name',
                    title: 'Usuario',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: 'libro.nombre',
                    title: 'Libro',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: 'created_at',
                    title: 'Fecha',
                    titleClass: 'text-center',
                    dataClass: 'text-center align-middle'
                },
                {
                    name: 'estado',
                    title: 'Estado',
                    sortField: 'fecha_publicacion',
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
