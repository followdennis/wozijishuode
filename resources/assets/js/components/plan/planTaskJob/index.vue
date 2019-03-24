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
                <el-select v-model="filters.plan_task_id"
                           filterable
                           remote
                           :remote-method="remoteMethodPlanTask"
                           clearable  placeholder="请选择子任务">
                    <el-option
                            v-for="item in planTaskList"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
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
                    prop="name"
            >
                <template slot-scope="scope">
                    {{ scope.row.name }}
                </template>
            </el-table-column>
            <el-table-column
                    label="父级子任务"
                    prop="task.task_name"
            >
            </el-table-column>
            <el-table-column
                    label="量化值"
                    prop="quantization"
            >
            </el-table-column>
            <el-table-column
                    label="评价"
                    prop="asses"
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
        <add-job ref="addJob" @fromChild="loadData"></add-job>
    </div>
</template>
<script>
    import ElButton from "../../../../../../node_modules/element-ui/packages/button/src/button";
    import addJob from "./addJob.vue";
    export default {
        components: {
            ElButton,
            addJob:addJob
        },
        mounted() {
            this.getPlanList();
            this.remoteMethodPlanTask();
            this.loadData();
        },
        computed:{

        },
        watch:{
            'filters.plan_id':function(val,oldVal){
                this.remoteMethodPlanTask();
            }
        },
        data(){
            return {
                msg: '开始',
                filters:{
                    query:'',
                    plan_id:'',
                    plan_task_id:''
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

                planList:[],
                planTaskList:[],
                saveForm:{
                    name:'',
                    plan_name:'',//父级任务
                    content:'',
                    plan_id:0,
                    is_satisfy:0,
                    asses:'',
                    quantization:0
                },
                rules:{
                    name:[
                        {required:true,message:'标题必填',trigger:'blur'},
                        {max:255,min:'1',message:'不能超过255个字',trigger:'blur'}
                    ],
                    content:[
                        {required:true,message:'必填',trigger:'blur'}
                    ],
                    day:[
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
                    plan_id:this.filters.plan_id,
                    plan_task_id:this.filters.plan_task_id
                };
                this.loading = true;
                axios.get('/back/plan_task_job/list',{params:params}).then( (res) =>{

                    let data = res.data.items;
                    this.tableData = data;
                    this.page.total = data.total;
                    this.page.from = data.from;
                    this.page.to =data.to;
                    this.loading = false;
                })

            },
            getPlanList(){
                let that = this;
                axios.get("/back/plan/list").then( res => {
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
            handleAdd:function(){
               this.$refs.addJob.handleAdd(0);
            },
            handleEdit(index,row){
               this.$refs.addJob.handleEdit(index,row);
            },

            handleDel(index,row){
                let that = this;
                this.$confirm('此操作将永久删除该文件, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    axios.get('/back/plan_task_job/del',{params:{id:row.id}}).then(res => {
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
            remoteMethodPlanTask(query = ''){
                let that = this;
                console.log('yes');
                console.log(this.filters.plan_id);
                setTimeout(function(){
                    axios.get('/back/plan_task/query_list',{
                        params:{query:query,plan_id:that.filters.plan_id}
                    }).then( res =>{
                        if( res.status == 200){
                            that.planTaskList = res.data.items.map(item => {
                                return {
                                    value:item.id,
                                    label:item.name
                                }
                            });
                        }
                    })
                },200);
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