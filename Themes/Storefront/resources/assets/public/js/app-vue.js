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


var app = new Vue({
    el: '#app-checkout',
    data: {
        loading: false,
        state: '',
        states: [],
        city: '',
        cities: [],
        district: '',
        districts: [],
        courier: '',
        couriers: [],
        shipping_total: '-',
        url:  document.getElementById('url').value,
        shipping_total_value:  document.getElementById('shipping_total_value').value,
    },
    mounted() {
        if (localStorage.state) {
            this.state = localStorage.state;
        }
        if (localStorage.states) {
            this.states =  JSON.parse(localStorage.states);
        }
        if (localStorage.city) {
            this.city = localStorage.city;
        }
        if (localStorage.cities) {
            this.cities = JSON.parse(localStorage.cities);
        }
        if (localStorage.district) {
            this.district = localStorage.district;
        }
        if (localStorage.districts) {
            this.districts = JSON.parse(localStorage.districts);
        }
        if (localStorage.courier) {
            this.courier = localStorage.courier;
        }
        if (localStorage.couriers) {
            this.couriers = JSON.parse(localStorage.couriers);
        }
    },
    watch: {
        state(newState) {
            localStorage.state = newState;
        },
        states(newStates) {
            localStorage.states = JSON.stringify(newStates);
        },
        city(newCity) {
            localStorage.city = newCity;
        },
        cities(newCities) {
            localStorage.cities = JSON.stringify(newCities);
        },
        district(newDistrict) {
            localStorage.district = newDistrict;
        },
        districts(newDistricts) {
            localStorage.districts = JSON.stringify(newDistricts);
        },
        courier(newCourier) {
            localStorage.courier = newCourier;
        },
        couriers(newCouriers) {
            localStorage.couriers = JSON.stringify(newCouriers);
        },
    },
    methods: {
        getStates: function () {
            this.loading = true;
            axios.post(this.url + '/states', {

            })
                .then(function (response) {
                    app.loading = false;
                    app.states = response.data;
                    // Empty chield
                    app.cities = '';
                    app.city = '';
                    app.districts = '';
                    app.district = '';
                    app.courier = '';
                    app.couriers = '';
                });
        },
        getCities: function () {
            this.loading = true;
            axios.post(this.url + '/cities', {
                params: {
                    state: this.state,
                },
            })
                .then(function (response) {
                    app.loading = false;
                    app.cities = response.data;
                    app.city = '';

                    // Empty districts
                    app.districts = '';
                    app.district = '';
                });
        },
        getDistricts: function () {
            this.loading = true;
            axios.post(this.url + '/districts', {
                params: {
                    city: this.city,
                },
            })
                .then(function (response) {
                    app.loading = false;
                    app.districts = response.data;
                    app.district = '';
                });
        },
        getCost: function () {
            this.loading = true;
            axios.post(this.url + '/shipping/cost', {
                params: {
                    district: this.district,
                    courier: this.courier,
                },
            })
                .then(function (response) {
                    app.loading = false;
                    document.getElementById('total-amount').textContent = response.data.total;
                    document.getElementById('shipping-total-amount').textContent = response.data.shipping_total.formatted;
                    document.getElementById('coupon-value').innerHTML = `&#8211;${response.data.discount}`;
                });
        },
        getCourier: function () {
            this.loading = true;
            axios.post(this.url + '/shipping/couriers', {
                params: {
                    district: this.district,
                },
            })
                .then(function (response) {
                    app.loading = false;
                    app.couriers = response.data;
                    app.courier = '';
                });
        },
    },
    created: function () {
        this.loading = false;
        if (this.shipping_total_value < 1) {
            localStorage.clear();
        }
        if (localStorage.state) {
            this.state = localStorage.state;
            this.states = JSON.parse(localStorage.states);
        } else {
            this.getStates();
        }
    },
});
