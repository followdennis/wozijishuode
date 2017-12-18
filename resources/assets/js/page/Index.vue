<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <header-component></header-component>
                    <div class="panel-heading">组件案例2</div>

                    <div class="panel-body">
                       你好  {{ msg }}

                    <div class="route-test">
                        <router-link to="/index">这是首页</router-link>
                        <router-link to="/list">这是列表页</router-link>
                        <br/>
                        <router-view></router-view>
                    </div>
                    </div>

                    <footer-component></footer-component>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .route-test{
        color:red;
    }
</style>
<script>
    import HeaderComponent from '../components/wechat/Header.vue';
    import FooterComponent from '../components/wechat/Footer.vue';
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        components:{
            HeaderComponent,
            FooterComponent
        },
        data(){
            return {
                msg:'我是主体内容  ',
                code:200
            }
        }
    }
</script>
