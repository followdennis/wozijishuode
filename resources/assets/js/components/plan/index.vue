<template>
    <div class="row table_list">
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.query" placeholder="请输入关键词"></el-input>
                </el-form-item>
                <el-select v-model="filters.today" clearable  placeholder="请选择日期">
                    <el-option
                            v-for="item in todayTask.list"
                            :key="item.taskId"
                            :label="item.today"
                            :value="item.taskId">
                    </el-option>
                </el-select>
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
                element-loading-background="rgba(0, 0, 0, 0.8)"
                :row-class-name="tableRowClassName">
            <el-table-column
                    type="index"
                    label="ID"
                    width="60">
            </el-table-column>
            <el-table-column
                    label="任务名称"
            >
                <template slot-scope="scope">
                    {{ scope.row.name }}
                </template>
            </el-table-column>
            <el-table-column
                    label="简记"
                    prop="desc"
            >
            </el-table-column>
            <el-table-column
                    prop="day"
                    label="预计天数"
            >
            </el-table-column>
            <el-table-column
                    label="开始时间"
                    prop="start_time"
            >
            </el-table-column>
            <el-table-column
                    label="结束时间"
                    prop="end_time"
            >
            </el-table-column>
            <el-table-column
                    label="重要性"
                    prop="importance"
            >
            </el-table-column>
            <el-table-column
                    label="满意度"
                    prop="satisfaction"
            >
            </el-table-column>
            <el-table-column
                    label="数量"
                    prop="sub_task_num"
            >
            </el-table-column>
            <el-table-column
                    label="完成数"
                    prop="sub_task_finished_num"
            >
            </el-table-column>
        </el-table>
        <div class="block">
            <el-col :span="24" class="toolbar" style="margin:4px;">
                <!--<el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0">批量删除</el-button>-->
                <el-pagination
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page="page.currentPage"
                        :page-sizes="[10, 20, 50, 100]"
                        :page-size="page.perPage"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="page.total"
                        style="float:right;">
                </el-pagination>
                <span style="display:block;float:right;padding-top:6px;font-size:13px;color: #48576a;">第{{page.from}}到{{page.to}}条</span>
            </el-col>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            this.getTaskList();
            this.loadData();
            console.log('Component mounted.')
        },
        computed:{

        },
        data(){
            return {
                msg: '开始',
                filters:{
                    query:'',
                    today:''
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
                todayTask:{
                    list:[]
                },
                saveForm:{
                    questionId:0,
                    num:0,
                    numDesc:'',
                    assess:0,
                    taskId:0,
                    start:0,
                    description:''
                },
                loading:false,
                time_count:null
            }
        },
        methods:{
            loadData:function(){
                let params = {
                    page:this.page.currentPage,
                    perPage:this.page.perPage,
                    query:this.filters.query,
                    today:this.filters.today
                }
                this.loading = true;
                axios.get('/back/plan/list',{params:params}).then( (res) =>{
                    console.log(res);
                    let data = res.data.items;
                    this.tableData = data;
                    this.page.total = data.total;
                    this.page.from = data.from;
                    this.page.to =data.to;
                    this.loading = false;
                })

            },
            getTaskList:function(){
                axios.get('/back/diary/today_get_task_list').then((res)=>{
                    let list = res.data;
                    this.todayTask.list = list;
                })
            },
            handleAdd:function(){
                this.addFormVisible = true;
                this.addForm = {
                    question: '',
                    sort: 0,
                };
            },
            handleSave:function(index,row){
                console.log('save');
//                this.saveForm = Object.assign({}, row);
                this.saveForm = {
                    questionId:row.questionId,
                    num:row.answer.num,
                    numDesc:row.answer.numDesc,
                    assess:row.answer.assess,
                    taskId:row.answer.taskId,
                    description:row.answer.description,
                    today:this.filters.today
                }
                axios.post('/back/diary/today/thoughts/add',this.saveForm).then((res)=>{

                }).catch(()=>{
                    console.log('save failed');
                })
                console.log(this.saveForm);
            },
            handleStart:function(index,row){
                row.answer.start = !row.answer.start;
                let count=function(){
                    row.answer.num++;
                }
                if(row.answer.start === true){
                    this.time_count =  setInterval(count,1000);
                }else{
                    clearInterval(this.time_count);
                }
                console.log(row.answer.start);
            },
            startChange:function(data){
                console.log('start-change');
                console.log(data);
            },
            tableRowClassName(row, rowIndex) {

            },
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
                this.page.perPage = val;
                this.loadData();
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val} ${this.page.perPage}`);
                this.page.currentPage = val;
                this.loadData();
            },
            selsChange:function(sels){
                this.sels = sels;
            },
        }
    }
</script>
<style>
    .table_list{
        margin:0px;
    }
    .el-table .warning-row{
        background:#d9f7c9;
    }
    .el-table .success-row{
        background: #f0f9eb;
    }
    .number_count{
        width:118px;
    }
</style>