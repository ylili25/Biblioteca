<template>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="mb-0">Editoriales</h3>
                <a href="/editoriales/create" class="btn btn-primary">Nueva</a>
            </div>
        </div>
        <div class="card-body">
            <table-editoriales/>
        </div>
    </div>
</template>

<script>
import  TableEditoriales from './Table.vue'

export default {
    components:{
        TableEditoriales
    }
}
</script>
