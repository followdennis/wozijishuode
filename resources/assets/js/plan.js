
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import ElementUI from 'element-ui'    //引入element－ui

import 'element-ui/lib/theme-default/index.css' //引入element－ui所需的css样式资源文件
Vue.use(ElementUI);    //把引入的ElementUI装入我们的Vue
Vue.component('my_plan',require('./components/plan/index.vue'));

const app = new Vue({
    el: '#plan'
});
