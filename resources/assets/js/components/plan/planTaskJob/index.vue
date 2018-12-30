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
                    prop="name"
            >
                <template slot-scope="scope">
                    {{ scope.row.name }}
                </template>
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
        <el-dialog
                title="提示"
                :visible.sync="dialogVisible"
                width="30%"
                :before-close="handleClose"
                center
        >

            <el-form ref="saveForm" :model="saveForm" :rules="rules" label-width="80px">
                <el-form-item label="任务名称" prop="name">
                    <el-input v-model="saveForm.name"></el-input>
                </el-form-item>
                <el-form-item label="父级任务" >
                    <el-input v-model="saveForm.plan_name"></el-input>
                </el-form-item>
                <el-form-item label="简介">
                    <el-input v-model="saveForm.desc"></el-input>
                </el-form-item>
                <el-form-item label="正文" prop="content">
                    <el-input type="textarea" v-model="saveForm.content"></el-input>
                </el-form-item>
                <el-form-item label="量化值" prop="day_num">
                    <el-col :span="10"><el-input v-model.number="saveForm.quantization"></el-input></el-col>
                    <el-col class="line" :span="3">量化单位</el-col>
                    <el-col :span="11"><el-input v-model="saveForm.quantization_unit"></el-input></el-col>
                </el-form-item>
                <el-form-item label="评价">
                    <el-input v-model="saveForm.asses"></el-input>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="handleSave">确 定</el-button>
            </span>
        </el-dialog>
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
                    today:this.filters.today
                }
                this.loading = true;
                axios.get('/back/plan_task/list',{params:params}).then( (res) =>{

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
                this.dialogVisible = true;
                this.type = 0;//新增
                this.saveForm = {
                    name:'',
                    plan_name:'',//父级任务
                    content:'',
                    plan_id:0,
                    plan_task_id:0,
                    asses:'',
                    quantization:0,
                };
            },
            handleEdit(index,row){
                this.dialogVisible = true;
                this.type = 1;
                let that = this;
                axios.get('/back/plan_task_job/show',{params:{id:row.id}}).then( res => {
                    if ( res.data.code == 0){
                        let data = res.data.data;
                        that.saveForm = {
                            id:data.id,
                            name:data.name,
                            plan_task_name:data.plan_task_name,//父级任务
                            content:data.content,
                            asses:data.asses,
                            quantization:0
                        };
                    }else {
                        this.$message({
                            type:'error',
                            duration:2000,
                            message:'获取详情失败'
                        })
                    }
                })
            },

            handleSave:function(){
//                this.saveForm = Object.assign({}, row);
                let that = this;
                if( this.type == 0){
                    //新增
                    this.$refs['saveForm'].validate( valid =>{
                        if( valid ){
                            axios.post('/back/plan_task_job/add',this.saveForm).then((res)=>{
                                if( res.data.code == 0){
                                    this.$message({
                                        type: 'success',
                                        message: '添加成功!',
                                        duration:2000
                                    });
                                    that.dialogVisible = false;
                                    that.loadData();
                                } else{
                                    this.$message({
                                        type: 'error',
                                        message: '操作失败!',
                                        duration:2000
                                    });
                                }
                            }).catch(()=>{
                                console.log('save failed');
                            })
                        }
                    })

                } else if( this.type == 1){
                    //编辑
                    this.$refs['saveForm'].validate( valid =>{
                        if( valid ){
                            axios.post('/back/plan_task_job/edit',this.saveForm).then((res)=>{
                                if( res.data.code == 0){
                                    this.$message({
                                        type: 'success',
                                        message: '编辑成功!',
                                        duration:2000
                                    });
                                    that.dialogVisible = false;
                                    that.loadData();
                                } else{
                                    this.$message({
                                        type: 'error',
                                        message: '操作失败!',
                                        duration:2000
                                    });
                                }
                            }).catch(()=>{
                                this.$message({
                                    type: 'error',
                                    message: '操作失败!',
                                    duration:2000
                                });
                            })
                        }
                    })
                }

                console.log(this.saveForm);
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