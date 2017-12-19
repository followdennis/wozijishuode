require('./base');
window.Vue = require('vue');

// Vue.component('my-test', require('./components/Test.vue'));
import Vue from 'vue'
import VueRouter from 'vue-router';
Vue.use(VueRouter);
//element引入
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
Vue.use(ElementUI);
import store from './store'
import routes from './router/index.js';
// 实例化路由
const router = new VueRouter({
    routes
});
const app = new Vue({
    el: '#wechat',
    router,
    store
});
