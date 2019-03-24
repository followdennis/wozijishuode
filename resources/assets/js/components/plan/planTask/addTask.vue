<template>
    <el-dialog
            :title="title"
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
                <el-select v-model="saveForm.plan_id"
                           filterable
                           remote
                           :remote-method="remoteMethod"
                           placeholder="请选择">
                    <el-option
                        v-for="item in planList"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"

                    >
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="简介">
                <el-input v-model="saveForm.desc"></el-input>
            </el-form-item>
            <el-form-item label="正文" prop="content">
                <el-input type="textarea" :rows="6" v-model="saveForm.content"></el-input>
            </el-form-item>
            <el-form-item label="预估天数" prop="day_num">
                <el-input v-model.number="saveForm.day_num"></el-input>
            </el-form-item>
            <el-form-item label="量化值" prop="quantization">
                <el-col :span="10"><el-input v-model.number="saveForm.quantization"></el-input></el-col>
                <el-col class="line" :span="3"> &nbsp; &nbsp;量化单位</el-col>
                <el-col :span="11"><el-input v-model="saveForm.quantization_unit"></el-input></el-col>
            </el-form-item>
            <el-form-item label="开始时间">
                <el-col :span="10">
                    <el-date-picker
                            type="datetime"
                            placeholder="选择日期"
                            v-model="saveForm.start_time"
                            format="yyyy-MM-dd HH:mm:ss"
                            @change="formatTime1"
                            value-format="yyyy-MM-dd HH:mm:ss"
                            style="width: 100%;"></el-date-picker>
                </el-col>
                <el-col class="line" :span="4"> &nbsp;  结束时间 </el-col>
                <el-col :span="10">
                    <el-date-picker
                            type="datetime"
                            placeholder="选择时间"
                            v-model="saveForm.end_time"
                            format="yyyy-MM-dd HH:mm:ss"
                            value-format="yyyy-MM-dd HH:mm:ss"
                            @change="formatTime2"
                            style="width: 100%;"></el-date-picker>
                </el-col>
            </el-form-item>
            <el-form-item label="重要性" >
                <el-select v-model="saveForm.importance" placeholder="请选择">
                    <el-option label="重要" :value="3"></el-option>
                    <el-option label="一般" :value="2"></el-option>
                    <el-option label="不重要" :value="1"></el-option>
                    <el-option label="请选择" :value="0"></el-option>

                </el-select>
            </el-form-item>
            <el-form-item label="是否满意">
                <el-radio-group v-model="saveForm.is_satisfy">
                    <el-radio   :label="1"  >满意</el-radio>
                    <el-radio  :label="0" >不满意</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="改进方法">
                <el-input v-model="saveForm.advice"></el-input>
            </el-form-item>
            <el-form-item label="状态">
                <el-radio-group v-model="saveForm.status">
                    <el-radio   :label="1"  >完成</el-radio>
                    <el-radio  :label="0" >未完成</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="handleSave">确 定</el-button>
            </span>
    </el-dialog>
</template>

<script>
    import ElButton from "../../../../../../node_modules/element-ui/packages/button/src/button";
    import ElOption from "../../../../../../node_modules/element-ui/packages/select/src/option";
    export default {
        components: {
            ElOption,
            ElButton
        },
        mounted() {

        },
        computed:{

        },
        data(){
            return {
                msg: '开始',
                saveForm:{
                    name:'',
                    plan_name:'',//父级任务
                    desc:'',
                    content:'',
                    plan_id:0,
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
                title:"提示",
                planList:[],
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
                    ],
                    plan_id:[
                        {required:true,message:'必填'}
                    ]
                },
                loading:false,
                time_count:null,
                dialogVisible: false,
                type:0  //0 新增 1 编辑
            }
        },
        methods:{
            handleAdd:function(id){
                this.title = "新增子任务";
                this.initTaskList(id);
                this.dialogVisible = true;
                this.type = 0;//新增
                this.saveForm = {
                    name:'',
                    plan_id:id == 0 ? '':id,//父级任务
                    desc:'',
                    content:'',
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
                };
            },

            handleEdit(index,row){
                this.title="编辑子任务";
                this.dialogVisible = true;
                this.type = 1;
                let that = this;
                console.log('plan_id',row.plan_id);
                this.initTaskList(row.plan_id);
                axios.get('/back/plan_task/show',{params:{id:row.id}}).then( res => {
                    if ( res.data.code == 0){
                        let data = res.data.data;
                        that.saveForm = {
                            id:data.id,
                            plan_id:data.plan_id,
                            name:data.name,
                            desc:data.desc,
                            content:data.content,
                            is_satisfy:data.is_satisfy,
                            advice:data.advice,
                            quantization:data.quantization,
                            quantization_unit:data.quantization_unit,
                            start_time:data.start_time,
                            end_time:data.end_time,
                            day_num:data.day_num,
                            created_at:data.created_at,
                            importance:data.importance,
                            status:data.status,
                            sort:data.sort
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
            //初始化任务列表
            initTaskList(id){
                let that = this;
                axios.get("/back/plan/list",{
                    params:{id:id}
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
            handleSave:function(){
//                this.saveForm = Object.assign({}, row);
                let that = this;
                if( this.type == 0){
                    //新增
                    this.$refs['saveForm'].validate( valid =>{
                        if( valid ){
                            axios.post('/back/plan_task/add',this.saveForm).then((res)=>{
                                if( res.data.code == 0){
                                    this.$message({
                                        type: 'success',
                                        message: '添加成功!',
                                        duration:2000
                                    });
                                    that.dialogVisible = false;
                                    that.$emit("eventFromChild",'');//刷新数据
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
                            axios.post('/back/plan_task/edit',this.saveForm).then((res)=>{
                                if( res.data.code == 0){
                                    this.$message({
                                        type: 'success',
                                        message: '编辑成功!',
                                        duration:2000
                                    });
                                    that.dialogVisible = false;
                                    that.$emit("eventFromChild",'');//刷新数据
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
            remoteMethod(query){
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
                console.log('close');
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
