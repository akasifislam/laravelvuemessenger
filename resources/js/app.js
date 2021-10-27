require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)


Vue.component('main-app', require('./components/MainApp.vue').default);


const app = new Vue({
    el: '#app',
});
