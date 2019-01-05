<template>
    <el-dialog
            title="提示"
            :visible.sync="dialogVisible"
            width="30%"
            :before-close="handleClose"
            center
    >

        <el-form ref="saveForm" :model="saveForm" :rules="rules" label-width="80px">
            <el-form-item label="任务名称" prop="name"
            >
                <el-input v-model="saveForm.name"></el-input>
            </el-form-item>
            <el-form-item label="父级任务" >
                <el-select v-model="saveForm.plan_task_id"
                           filterable
                           remote
                           :remote-method="remoteMethod"
                           @change="handleSelectTask"
                           placeholder="请选择">
                    <el-option
                            v-for="item in taskList"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"

                    >
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="正文" prop="content">
                <el-input type="textarea" v-model="saveForm.content"></el-input>
            </el-form-item>
            <el-form-item label="评价">
                <el-input v-model="saveForm.asses"></el-input>
            </el-form-item>
            <el-form-item label="量化值" prop="quantization">
                <el-input v-model = "saveForm.quantization"></el-input>
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
    export default {
        components: {ElButton},
        mounted() {
        },
        computed:{

        },
        data(){
            let numVald = ( rule, value ,callback) => {
              if( !/^\d+$/.test(value)){
                  return callback(new Error("格式不正确"));
              } else {
                  return callback();
              }
            };
            return {
                msg: '开始',
                filters:{
                    query:'',
                    today:''
                },
                saveForm:{
                    name:'',
                    content:'',
                    plan_id:0,
                    plan_task_id:0,
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
                    quantization:[
                        {required:true,message:'必填'},
                        {validator:numVald,message:'必须为数字类型',trigger:'blur'}
                    ]
                },
                taskList:[],
                loading:false,
                time_count:null,
                dialogVisible: false,
                type:0  //0 新增 1 编辑
            }
        },
        methods:{
            //传入 task_id
            handleAdd:function(task_id,plan_id){
                this.initTaskList(task_id);
                this.dialogVisible = true;
                this.type = 0;//新增
                this.saveForm = {
                    name:'',
                    content:'',
                    plan_id:plan_id,
                    plan_task_id:task_id == 0 ? '': task_id,
                    asses:'',
                    quantization:0,
                };
            },
            handleEdit(index,row){
                console.log(row);
                this.dialogVisible = true;
                this.type = 1;
                let that = this;
                this.initTaskList(row.plan_task_id);
                axios.get('/back/plan_task_job/show',{params:{id:row.id}}).then( res => {
                    if ( res.data.code == 0){
                        let data = res.data.data;
                        that.saveForm = {
                            id:data.id,
                            name:data.name,
                            plan_task_id:data.plan_task_id,//父级任务
                            content:data.content,
                            asses:data.asses,
                            quantization:data.quantization
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

            initTaskList(task_id){
                let that = this;
                axios.get('/back/plan_task/list',
                    {params:{id:task_id}}).then( res => {
                    if( res.status == 200){
                        that.taskList = res.data.items.map(item => {
                            return {value:item.id,label:item.name};
                        })
                    }
                });
            },
            handleSave:function(){
//                this.saveForm = Object.assign({}, row);

                console.log(this.saveForm);

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

                                    that.$emit("fromChild",'');
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
                                    that.$emit("fromChild",'');
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
            remoteMethod(query){
                let that = this;
                setTimeout(function(){
                    axios.get('/back/plan_task/list',{
                        params:{query:query}
                    }).then( res =>{
                        if( res.status == 200){
                            that.taskList = res.data.items.map(item => {
                                return {
                                    value:item.id,
                                    label:item.name,
                                    plan_id:item.plan_id
                                }
                            });
                        }
                    })
                },200);
            },
            handleSelectTask(val){
                this.taskList.forEach( (item ,index) =>{
                    if( item.value == val){
                        this.saveForm.plan_id = item.plan_id;
                        return false;
                    }
                })
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
            handleClose(form){
//                this.$refs[form].clearValidate();
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

    .el-table .warning-row{
        background:#d9f7c9;
    }
    .el-table .success-row{
        background: #f0f9eb;
    }

</style>