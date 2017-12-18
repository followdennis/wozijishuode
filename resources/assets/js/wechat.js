
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./base');
window.Vue = require('vue');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('my-test', require('./components/Test.vue'));
import Vue from 'vue'
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import store from './store'
import routes from './router/index.js';
// 实例化路由
const router = new VueRouter({
    routes
});

import Index from './page/Index.vue'
const app = new Vue({
    el: '#wechat',
    router,
    store,
    render: h=>h(Index)
});
