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
                    label="问题"
                    width="400"
            >
                <template slot-scope="scope">

                    <el-popover v-if="scope.row.description != null &&  scope.row.description !=''" trigger="hover" placement="top">
                        <p>说明: {{ scope.row.description }}</p>
                        <div slot="reference" class="name-wrapper">
                            {{ scope.row.questionName }}
                        </div>
                    </el-popover>
                    <div v-else>
                        {{ scope.row.questionName }}
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                    label="简记"
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
                    <el-input-number controls-position="right" class="number_count" v-model="scope.row.answer.num" :min="0" :max="1000"></el-input-number>
                </template>
            </el-table-column>
            <el-table-column
                    label="数量描述"
            >
                <template slot-scope="scope">
                    <el-input v-model="scope.row.answer.numDesc" placeholder=""></el-input>
                </template>
            </el-table-column>
            <el-table-column
                    label="评估"
            >
                <template slot-scope="scope">
                    <div style="margin-top: 8px">
                        <el-radio-group v-model="scope.row.answer.assess" size="small">
                            <el-radio-button label="1">是</el-radio-button>
                            <el-radio-button label="2">否</el-radio-button>
                            <el-radio-button label="3">不清楚</el-radio-button>
                        </el-radio-group>
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="140"
            >
                <template slot-scope="scope">
                    <el-button
                            size="small"
                            type="primary"
                            @click="handleSave(scope.$index, scope.row)">保存</el-button>
                    <el-button
                            size="small"
                            :type="scope.row.answer.start === true?'success':'danger'"
                            v-text="scope.row.answer.start === true?'停止':'开始'"
                            @click="handleStart(scope.$index, scope.row)"></el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>
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
                axios.get('/back/diary/today/thoughts/lists',{params:params}).then((response)=>{
                    var data = response.data;
                    this.tableData = data;
//                    console.log(data);
                    this.loading = false;
                }).catch(function(error){
                    console.log(error);
                });
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
                    var response = res.data;
                    console.log(response);
                    if(response.state === 1){
                        row.answer.isCreate = 1;
                        this.$message({
                            message:response.msg,
                            type:'success'
                        });
                    }else if(response.state === 2){
                        this.$message({
                            message:response.msg,
                            type:'warning'
                        });
                    }else{
                        this.$message({
                            message:response.msg,
                            type:'error'
                        });
                    }
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
                if (row.answer.isCreate === 1) {
                    return 'warning-row';
                }
                return '';
            }
        }
    }
</script>
