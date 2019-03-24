<template>
    <div class="row table_list">
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.query" placeholder="请输入关键词"></el-input>
                </el-form-item>
                <el-select v-model="filters.plan_id"
                           filterable
                           remote
                           :remote-method="remoteMethodPlan"
                           clearable  placeholder="请选择计划">
                    <el-option
                            v-for="item in planList"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
                <el-select v-model="filters.importance" clearable  placeholder="请选择">
                    <el-option
                            v-for="item in importanceList"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
                <el-form-item>
                    <el-button type="primary" v-on:click="loadData">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleAdd" >新增</el-button>
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
                    prop="name"
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
                    label="重要性"
            >
                <template slot-scope="scope">
                    <span v-html="scope.row.importance_name"></span>
                </template>
            </el-table-column>
            <el-table-column
                    label="完成状态"
            >
                <template slot-scope="scope">
                    <span v-html="scope.row.status_name"></span>
                </template>
            </el-table-column>
            <el-table-column
                    label="量化值"
                    prop="quantization"
            >
            </el-table-column>
            <el-table-column
                    label="实际值"
                    prop="quantization_sum"
            >
            </el-table-column>
            <el-table-column
                    label="量化单位"
                    prop="quantization_unit"
            >
            </el-table-column>
            <el-table-column
                    label="天数"
                    prop="day_num"
            >
            </el-table-column>
            <el-table-column
                    label="实际天数"
                    prop="days_count"
            >
            </el-table-column>
            <el-table-column
                    label="创建时间"
                    prop="created_at"
            >
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="145"
            >
                <template slot-scope="scope">
                    <el-button
                            size="small"
                            type="primary"
                            @click="handleEdit(scope.$index, scope.row)">编辑</el-button>

                    <el-button
                        size="small"
                        type="warning"
                        @click="handleAddJob(scope.row)"
                        >
                        新增
                    </el-button>
                    <el-button
                            size="small"
                            type="info"
                    >
                        <a style="color:white" :href="'/back/plan_task_job/index?plan_task_id=' + scope.row.id" >列表</a>
                    </el-button>
                    <el-button
                            size="small"
                            type="danger"
                            @click="handleDel(scope.$index, scope.row)">删除</el-button>
                </template>
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
        <add-task ref="addTask" @eventFromChild="loadData"></add-task>
        <add-job ref="addJob" @eventFromChild="loadData"></add-job>
    </div>
</template>
<script>
    import ElButton from "../../../../../../node_modules/element-ui/packages/button/src/button";
    import addTask from "./addTask.vue"
    import addJob from "../planTaskJob/addJob.vue"
    export default {
        props:[
          'plan_id'
        ],
        components: {
            ElButton,
            addTask:addTask,
            addJob:addJob
        },
        mounted() {
            this.filters.plan_id =this.plan_id == 0 ? '':this.plan_id;
            this.getPlanList();
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
                    importance:0,
                    plan_id:''
                },
                importanceList:[
                    {label:'重要性',value:0},
                    {label:'不重要',value:1},
                    {label:'一般',value:2},
                    {label:'重要',value:3}
                ],
                tableData:[],
                page:{
                    total:0,
                    perPage:10,
                    currentPage:1,
                    lastPage:0,
                    from:0,
                    to:0
                },
                planList:[],
                saveForm:{
                    name:'',
                    plan_name:'',//父级任务
                    desc:'',
                    content:'',
                    plan_id:'',
                    is_satisfy:0,
                    advice:'',
                    quantization:0,
                    quantization_unit:'',
                    start_time:null,
                    end_time:null,
                    day_num:0,
                    created_at:null,
                    importance:0,
                    status:0,
                    sort:0
                },
                rules:{
                    name:[
                        {required:true,message:'标题必填',trigger:'blur'},
                        {max:255,min:'1',message:'不能超过255个字',trigger:'blur'}
                    ],
                    content:[
                        {required:true,message:'必填',trigger:'blur'}
                    ],
                    day_num:[
                        { required:true,message:'必填'},
                        {type:'number',message:'必须为数字类型'}
                    ]
                },
                loading:false,
                time_count:null,
                dialogVisible: false,
                type:0  //0 新增 1 编辑
            }
        },
        methods:{
            loadData:function(){
                let params = {
                    page:this.page.currentPage,
                    perPage:this.page.perPage,
                    query:this.filters.query,
                    importance:this.filters.importance,
                    plan_id:this.filters.plan_id
                };
                this.loading = true;
                axios.get('/back/plan_task/list',{params:params}).then( (res) =>{

                    let data = res.data.items.map( item => {
                        let importance_name = null;
                        if( item.importance == 0){
                            importance_name = '未选择';
                        } else if( item.importance == 1){
                            importance_name = '不重要';
                        }else if( item.importance == 2){
                            importance_name = '<font color="orange">一般</font>';
                        } else if( item.importance == 3){
                            importance_name = '<font color="red">重要</font>';
                        }
                        let status_name = null;
                        if( item.status == 0){
                            status_name = '<font>未完成</font>';
                        } else if( item.status == 1){
                            status_name = '<font color="red">已完成</font>';
                        }
                        item.status_name = status_name;
                        item.importance_name = importance_name;
                        return item;
                    });
                    this.tableData = data;
                    this.page.total = res.data.total;
                    this.page.from = data.from;
                    this.page.to =data.to;
                    this.loading = false;
                })

            },
            handleAdd:function(){
                this.$refs.addTask.handleAdd(0);
            },
            handleEdit(index,row){
                this.$refs.addTask.handleEdit(index,row);
            },
            handleDel(index,row){
                let that = this;
                this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    axios.get('/back/plan_task/del',{params:{id:row.id}}).then(res => {
                        if( res.data.code == 0){
                            this.$message({
                                type: 'success',
                                message: '删除成功!',
                                duration:2000
                            });
                            that.loadData();
                        } else {
                            this.$message({
                                type: 'error',
                                message: '删除失败!',
                                duration:2000
                            });
                        }
                    })

                }).catch(() => {

                });

            },
            getPlanList(){
                let that = this;
                axios.get("/back/plan/list",{
                    params:{plan_id:this.filters.plan_id}
                }).then( res => {
                    if( res.status == 200){
                        that.planList = res.data.items.map(function(item){
                            let obj = {
                                label:item.name,
                                value:item.id
                            };
                            return obj;
                        })
                    }
                });
            },
            remoteMethodPlan(query){
                let that = this;
                setTimeout(function(){
                    axios.get('/back/plan/list',{
                        params:{query:query}
                    }).then( res =>{
                        if( res.status == 200){
                            that.planList = res.data.items.map(item => {
                                return {
                                    value:item.id,
                                    label:item.name
                                }
                            });
                        }
                    })
                },200);
            },
            handleAddJob(row){
                console.log('taks_id',row);
                this.$refs.addJob.handleAdd(row.id,row.plan_id);
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
            handleClose(){
                this.dialogVisible = false;
            },
            formatTime1(time){
                this.saveForm.start_time = time;
            },
            formatTime2(time){
                this.saveForm.end_time = time;
            },
            formatTime3(time){
                this.saveForm.true_start_time = time;

            },
            formatTime4(time){
                this.saveForm.true_end_time = time;
            }
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