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
    // eslint-disable-next-line no-console
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


var app = new Vue({
    el: '#eling-cart',
    data: {
        url: document.getElementById('url').value,
        cart_items: [],
        total_amount: '',
        shipping_cost: '',
        subtotal: '',
        total_weight: '',
        taxes: [],
        loading: false,
        code: '',
        coupon_code: '',
        coupon_amount: '',
    },
    mounted() {
        this.loading = true;
        this.getCartItems();
    },
    methods: {
        getCartItems: function () {
            this.loading = true;
            axios.get(this.url + '/cart/items', {})
                .then(function (response) {
                    app.cart_items = response.data.cart_items;
                    app.subtotal = response.data.subtotal;
                    app.total_amount = response.data.total_amount;
                    app.total_weight = response.data.total_weight;
                    app.shipping_cost = response.data.shipping_cost;
                    app.taxes = response.data.taxes;
                    app.coupon_code = response.data.coupon_code;
                    app.coupon_amount = response.data.coupon_amount;
                    app.loading = false;
                });

        },
        removeCartItem(id) {
            this.loading = true;
            axios.delete(this.url + '/cart/items/' + id + '/remove', {})
                .then(function (response) {
                    response.data.success === true ? app.getCartItems() : '';
                });
            this.getCartItems();
            app.loading = false;
        },
        increaseQty(id) {
            this.cart_items = this.cart_items.map(function (item) {
                if (item.id === id) {
                    let quantity = parseInt(item.quantity) + 1;
                    return { ...item, quantity };
                } else {
                    return item;
                }
            });
            this.updateCart(id);
        },
        decreaseQty(id) {
            this.cart_items = this.cart_items.map(function (item) {
                if (item.id === id) {
                    let quantity = parseInt(item.quantity) - 1;
                    return { ...item, quantity };
                } else {
                    return item;
                }
            });
            this.updateCart(id);

        },
        updateCart: _.debounce(function (id) {
            this.updateCartItem(id);
        }, 500
        ),
        updateCartItem(id) {
            this.loading = true;
            let item = this.cart_items.find(function (item) {
                return item.id === id;
            });

            axios({
                method: 'put',
                url: this.url + '/cart/items/' + item.id + '/qty',
                data: { qty: item.quantity },
            }).then(function (response) {
                response.data.success === true ? app.getCartItems() : '';
            });
            app.loading = false;
        },
        isButtonDisabled(item) {
            return parseInt(item.quantity) <= 1;
        },
        redeemCoupon() {
            this.loading = true
            axios({
                method: 'post',
                url: this.url + '/cart/coupon/redeem',
                data: { coupon: this.code },
            }).then(function (response) {
                if (response.data.success) {
                    app.getCartItems()
                    app.code = ''
                    alert(response.data.message)
                } else {
                    alert(response.data.errors)
                }
            });
            app.loading = false;
        },
        removeCoupon() {
            this.loading = true
            axios({
                method: 'delete',
                url: this.url + '/cart/coupon',
                data: { coupon: this.coupon_code },
            }).then(function (response) {
                if (response.data.success) {
                    app.getCartItems()
                } else {
                    alert(response.data.errors)
                }
            });
            app.loading = false;
        }
    },
});
