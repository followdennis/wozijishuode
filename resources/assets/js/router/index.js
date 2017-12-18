import Index from '../page/Index.vue';
import List from '../page/List.vue';
import Detail from '../page/Detail.vue';
export default[
    { path: '', redirect: '/index' },
    { path: '/index', component:Index },
    { path: '/list', component: List },
    { path: '/detail/:id', component: Detail }
];