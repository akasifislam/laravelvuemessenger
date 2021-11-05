require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex'
import storeVuex from "./store/index"
import filter from './filter'

Vue.use(Vuex)


// vue chat scroll
import VueChatScroll from 'vue-chat-scroll';

Vue.use(VueChatScroll);
// vue chat scroll


const store = new Vuex.Store(storeVuex)


Vue.component('main-app', require('./components/MainApp.vue').default);


const app = new Vue({
    el: '#app',
    store
});
