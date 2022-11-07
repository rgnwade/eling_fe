import axios from 'axios';
import Vue from 'vue';



window.Vue = Vue;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    // eslint-disable-next-line no-console
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
Vue.use(require('vue-moment'));
var app = new Vue({
    el: '#app-show-order',
    data: {
        loading: false,
        url:  document.getElementById('url').value,
        manifest: [],
        status: '',
    },
    mounted() {

    },
    watch: {
    },
    methods: {
        getTracking: function (order_id) {
            $('#loading').show();
            $('#resi_modal').modal('show');
            axios.post(this.url + '/resi', {
                params: {
                    order_id: order_id,
                },
            })
                .then(function (response) {
                    $('#loading').hide();
                    app.manifest = response.data.manifest;
                    app.status = response.data.delivery_status.status;

                })
                .finally(function () {
                    $('#loading').hide();
                });
        },
    },
    created: function () {

    },
});
