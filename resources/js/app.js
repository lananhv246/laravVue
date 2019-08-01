/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');
window.Vue = require('vue');
//import Vue from 'vue'
window.VeeValidate = require('vee-validate');
//window.Vuetify = require('vuetity');
import Vuetify from 'vuetify'
//Import vue-router
import Routers from '@/js/routers.js'

//Component File
import App from '@/js/views/App'
Vue.use(VeeValidate);
Vue.use(Vuetify);
const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
    router: Routers,
    render:h => h(App),
});

export default app;
