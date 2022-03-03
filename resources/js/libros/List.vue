<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="mb-0">Libros</h3>
                <a href="/libros/create" class="btn btn-primary">Nuevo</a>
            </div>
        </div>
        <div class="card-body">
            <table-libros/>
        </div>
    </div>
</template>

<script>
import  TableLibros from './Table.vue'

export default {
    components:{
        TableLibros
    }
}
</script>
