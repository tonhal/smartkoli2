import axios from 'axios';
import Vue from 'vue';
import { BootstrapVue } from 'bootstrap-vue'

window.Vue = Vue;
Vue.use(BootstrapVue);

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) { }