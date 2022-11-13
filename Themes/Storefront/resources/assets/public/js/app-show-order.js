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
        url: document.getElementById('url').value,
        manifest: [],
        status: '',

        reviewed: [],
        unreviewed: [],
        current_product_id: '',
        current_product_name: '',
        current_rating: '',
        current_comment: '',
        current_order_id: '',
        field_errors: []
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
        getReviews: function ($id) {
            this.current_order_id = $id
            axios.get(this.url + '/account/orders/' + $id + '/reviews', {})
                .then(function (response) {
                    app.reviewed = response.data.reviewed;
                    app.unreviewed = response.data.unreviewed;
                });

        },
        buildRating: function (num) {
            var rating = ''
            var i
            for (i = 1; i <= 5; i++) {
                if (num >= i) {
                    rating += '<i class="fa fa-star rated"></i>'
                } else {
                    rating += '<i class="fa fa-star-o"></i>'

                }
            }
            return rating;
        },
        setReview: function (product_id) {
            const result = this.unreviewed.find(element => element.product_id == product_id);
            this.current_product_id = result.product_id
            this.current_product_name = result.name
            this.current_comment = ''
        },
        createReview: function () {
            this.field_errors = []
            this.validateFields()
            if (this.field_errors.length <= 0) {
                axios({
                    method: 'post',
                    url: this.url + '/reviews',
                    data: {
                        product_id: this.current_product_id,
                        order_id: this.current_order_id,
                        rating: this.current_rating,
                        comment: this.current_comment
                    },
                }).then(function (response) {
                    response.data.success === true ? app.getReviews(app.current_order_id) : '';
                });
            } else {
                setTimeout(() => {
                    var reviewButton = document.getElementById("add-review-button");
                    reviewButton.classList.remove('btn-loading');
                    reviewButton.classList.remove('disabled');
                    reviewButton.removeAttribute('disabled');
                }, 500);
            }

        },
        validateFields: function () {
            if (this.current_order_id == '') {
                this.field_errors.push('order_id')
            }

            if (this.current_rating == '') {
                this.field_errors.push('rating')
            }

            if (this.current_comment == '') {
                this.field_errors.push('comment')
            }
        },
        hasError: function (field) {
            return this.field_errors.includes(field)
        }
    },
    created: function () {

    },
});
