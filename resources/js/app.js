require('./bootstrap');

window.Vue = require('vue').default;


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('main-app', require('./components/MainApp.vue').default);


const app = new Vue({
    el: '#app',
});
