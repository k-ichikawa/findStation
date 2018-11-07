require('./bootstrap');

window.Vue = require('vue');

Vue.component('area-info-component', require('./components/AreaInfoComponent.vue'));

const app = new Vue({
    el: '#app'
});
