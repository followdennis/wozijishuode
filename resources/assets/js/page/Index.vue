<template>
    <div class="container">
        <el-row>
            <el-col :span="24">
                <div class="grid-content bg-purple-dark">
                    <header-component></header-component>
                </div>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="18" style="background-color: silver;">
                <el-tabs type="border-card">
                    <el-tab-pane label="用户管理">{{ list }}</el-tab-pane>
                    <el-tab-pane label="配置管理" @click="alert('ok')">配置管理{{ list }}</el-tab-pane>
                    <el-tab-pane label="角色管理">角色管理</el-tab-pane>
                    <el-tab-pane label="定时任务补偿">定时任务补偿</el-tab-pane>
                </el-tabs>
            </el-col>
            <el-col :span="6">
                <div class="route-test">
                    <router-link to="/index">这是首页</router-link>
                    <router-link to="/list">这是列表页</router-link>
                    <br/>
                    <router-view></router-view>
                </div>
            </el-col>
        </el-row>
        <el-row>
            <el-col :span="24">
                <footer-component></footer-component>
            </el-col>
        </el-row>
    </div>

</template>
<style>
    .el-row {
        margin-bottom: 20px;
    &:last-child {
         margin-bottom: 0;
     }
    }

    .bg-purple-dark {
        background: #99a9bf;
    }

    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }

</style>
<script>
    import HeaderComponent from '../components/wechat/Header.vue';
    import FooterComponent from '../components/wechat/Footer.vue';
    import ElRow from "element-ui/packages/row/src/row";
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
                msg:'我是主体内容  ',
                code:200,
                list:''
            }
        },
        components:{
            ElRow,
            HeaderComponent,
            FooterComponent
        },
        created:function(){
            this.getAritcle();
        },
        methods:{
            getAritcle(){
                axios.get('/api/wx').then((response) =>{
                    var json = response.data;
                    this.list = json;
                    console.log(json);
                }).catch(function(error){
                    console.log(error);
                });
            },
            getArticle2(){
                alert('ok');
            }
        }
    }
</script>
