<template>
    <div class="row table_list">
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.query" placeholder="请输入关键词"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" v-on:click="loadData">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleAdd">新增</el-button>
                </el-form-item>
            </el-form>
        </el-col>
        <el-table
                :data="tableData"
                border
                style="width: 100%"
                v-loading="loading"
                element-loading-text="加载中..."
                element-loading-spinner="el-icon-loading"
                element-loading-background="rgba(0, 0, 0, 0.8)">
            <el-table-column
                    prop="questionId"
                    label="ID"
                    width="60">
            </el-table-column>
            <el-table-column
                    prop="questionName"
                    label="问题"
                    width="400"
            >
            </el-table-column>
            <el-table-column
                    label="描述"
            >
                <template slot-scope="scope">
                    <el-input v-model="scope.row.answer.description" placeholder=""></el-input>
                </template>
            </el-table-column>
            <el-table-column
                    prop="answer.num"
                    label="数量"
            >
                <template slot-scope="scope">
                    <el-input-number site="mini" v-model="scope.row.answer.num" :min="0" :max="1000"></el-input-number>
                </template>
            </el-table-column>
            <el-table-column
                    prop="answer.numDesc"
                    label="数量描述"
            >
            </el-table-column>
            <el-table-column
                    label="评估"
            >
                <template slot-scope="scope">
                    <div style="margin-top: 8px">
                        <el-radio-group v-model="scope.row.answer.assess" size="small">
                            <el-radio-button label="是"></el-radio-button>
                            <el-radio-button label="否"></el-radio-button>
                            <el-radio-button label="不清楚"></el-radio-button>
                        </el-radio-group>
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="200"
            >
                <template slot-scope="scope">
                    <el-button
                            size="small"
                            type="primary"
                            @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button
                            size="small"
                            type="danger"
                            @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>
<style scoped="scope">
    .table_list{
        margin:0px;
    }
</style>
<script>
    export default {
        mounted() {
            this.loadData();
            console.log('Component mounted.')
        },
        data(){
            return {
                msg: 'hei hei',
                filters:{
                    query:''
                },
                tableData:[],
                page:{
                    total:0,
                    perPage:10,
                    currentPage:1,
                    lastPage:0,
                    from:0,
                    to:0
                },
                loading:false,
            }
        },
        methods:{
            loadData:function(){
                let params = {
                    page:this.page.currentPage,
                    perPage:this.page.perPage,
                    query:this.filters.query
                }
                this.loading = true;
                axios.get('/back/diary/today/thoughts/lists',{params:params}).then((response)=>{
                    var data = response.data;
                    this.tableData = data;
                    this.loading = false;
                }).catch(function(error){
                    console.log(error);
                });
            },
            handleAdd:function(){
                this.addFormVisible = true;
                this.addForm = {
                    question: '',
                    sort: 0,
                };
            },
        }
    }
</script>
