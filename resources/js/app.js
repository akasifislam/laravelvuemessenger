require('./bootstrap');

window.Vue = require('vue').default;


Vue.component('main-app', require('./components/MainApp.vue').default);


const app = new Vue({
    el: '#app',
});
