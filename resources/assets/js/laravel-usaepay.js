window.Vue = require('vue');
window.axios = require('axios');

Vue.component('creditcardfield',require('./components/CreditCard.vue').default);


const app = new Vue({
    el: '#vue-app'
});
