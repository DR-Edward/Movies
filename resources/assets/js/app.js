/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.$bus = new Vue({})

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify);

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

// turn components
Vue.component('turns-index', require('./components/turns/index.vue').default);
Vue.component('turns-create', require('./components/turns/create.vue').default);
Vue.component('turns-update', require('./components/turns/update.vue').default);

// movies components
Vue.component('movies-index', require('./components/movies/index.vue').default);
Vue.component('movies-create', require('./components/movies/create.vue').default);
Vue.component('movies-update', require('./components/movies/update.vue').default);

Vue.component('picker-date', require('./components/pickerDate.vue').default);
Vue.component('picker-time', require('./components/pickerTime.vue').default);

Vue.component('drag-n-drop-image', require('./components/dragAndDropImage.vue').default);

Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
