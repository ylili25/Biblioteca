/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

require('./plugins/vuefontawesome')

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//Editoriales
Vue.component('listado-editoriales', require('./editoriales/List.vue').default);
Vue.component('form-editoriales', require('./editoriales/Form.vue').default);

//Libros
Vue.component('listado-libros', require('./libros/List.vue').default);
Vue.component('form-libros', require('./libros/Form.vue').default);

//Prestamos
Vue.component('listado-prestamos', require('./prestamos/List.vue').default);
Vue.component('form-prestamos', require('./prestamos/Form.vue').default);
Vue.component('prestamos-pendientes', require('./prestamos/Pendientes.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
