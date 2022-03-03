<template>
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Prestamos</h3>
        </div>
        <div class="card-body">
            <table-prestamos />
        </div>
    </div>
</template>

<script>
import  TablePrestamos from './Table.vue'

export default {
    components:{
        TablePrestamos
    }
}
</script>
