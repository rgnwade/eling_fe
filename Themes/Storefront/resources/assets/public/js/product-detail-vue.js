import axios from 'axios';
import Vue from 'vue';
import _ from 'lodash';

window.Vue = Vue;
window.axios = axios;
window.lodash = _;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


var app = new Vue({
    el: '#product-detail',
    data: {
        url: document.getElementById('url').value,
        cabinet_length: parseFloat(document.getElementById('cabinet_length').value),
        cabinet_width: parseFloat(document.getElementById('cabinet_width').value),
        minimum_order: parseFloat(document.getElementById('minimum_order').value),
        customer_length : '',
        customer_width: '',
        recommended_width: '',
        recommended_length: '',
    },
    mounted() {
   
    },
    methods: {
        calculateWidth() {
            let cabinet_width_qty = Math.floor(this.customer_width / this.cabinet_width);
            let recommended_width = (cabinet_width_qty * this.cabinet_width).toFixed(2);
            if (parseFloat(this.customer_width) < this.cabinet_width){
                recommended_width = (this.cabinet_width).toFixed(2);
            }
            this.recommended_width =  recommended_width;
            document.getElementById('recommended_width').value = this.recommended_width;
        },
        calculateLength() {
            let cabinet_length_qty = Math.floor(this.customer_length / this.cabinet_length);
            let recommended_length = (cabinet_length_qty * this.cabinet_length).toFixed(2);
        
            if (parseFloat(this.customer_length) < parseFloat(this.cabinet_length)){
                recommended_length = (this.cabinet_length).toFixed(2);
            }
            this.recommended_length = recommended_length;
            document.getElementById('recommended_length').value = this.recommended_length;
        },
    },
    watch: {
        customer_width(customer_width) {
            this.calculateWidth(customer_width);
        },
        customer_length(customer_length) {
            this.calculateLength(customer_length);
        },
    },
    computed: {
        recommendedSize: function () {
          return (this.recommended_width * this.recommended_length).toFixed(2);
        },
        canAddcart: function () {
            return (this.recommendedSize > this.minimum_order)
          }
      }
});
