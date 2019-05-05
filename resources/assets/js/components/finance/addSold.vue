<template>
    <el-dialog
            :title="title"
            :visible.sync="dialogVisible"
            width="30%"
            :before-close="handleClose"
            center
    >

        <el-form ref="saveForm" :model="saveForm" :rules="rules" label-width="80px">
             
            <el-form-item label="卖出数量" prop="count">
                <el-input v-model="saveForm.count"></el-input>
            </el-form-item>
           
            <el-form-item label="卖出总额" prop="sold_money">
                <el-input v-model="saveForm.sold_money"></el-input>
            </el-form-item>
            <el-form-item label="卖出单价" prop="sold_unit_price">
                <el-input v-model="saveForm.sold_unit_price"></el-input>
            </el-form-item>
        
            
            <el-form-item label="小记" prop="remark">
                <el-input type="textarea" :rows="6" v-model="saveForm.remark"></el-input>
            </el-form-item>
           
            <el-form-item label="卖出时间">
                <el-col :span="10">
                    <el-date-picker
                            type="datetime"
                            placeholder="选择日期"
                            v-model="saveForm.sold_time"
                            format="yyyy-MM-dd HH:mm:ss"
                            @change="formatTime1"
                            value-format="yyyy-MM-dd HH:mm:ss"
                            style="width: 100%;"></el-date-picker>
                </el-col>
            </el-form-item>
           
        </el-form>
        <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">取 消</el-button>
                <el-button type="primary" @click="handleSave">确 定</el-button>
            </span>
    </el-dialog>
</template>

<script>
    import ElButton from "../../../../../node_modules/element-ui/packages/button/src/button";
    import ElOption from "../../../../../node_modules/element-ui/packages/select/src/option";
    export default {
        components: {
            ElOption,
            ElButton
        },
        mounted() {
           
            
        },
        computed:{
            
        },
        created() {
           
        },
        watch:{
           
        },
        data(){
            return {
                msg: '开始',
                saveForm:{
                    id:0,
                    coin_buy_id:0,
                    count:0,//卖出数量
                    buy_count:0,//买入数量
                    buy_money:0,//买入总额
                    sold_money:0,//卖出总额
                    sold_unit_price:0,//卖出单价
                    buy_unit_price:0,//买入时的单价
                    
                    sold_time:null,
                    remark:null
                },
                title:"提示",
                coinTypeList:[],
                rules:{
                    count:[
                        {required:true,message:'输入卖出数量',trigger:'blur'},
                        //两位正小数，最多6位
                        { pattern: /^\d{1,6}(?=\.{0,1}\d{1,2}$|$)/ , message: '请输入正确的数量',trigger:'blur'}
                    ],
                    total_money:[
                        {required:true,message:'请输入卖出总额',trigger:'blur'},
                        //两位正小数，最多6位
                        { pattern: /^\d{1,6}(?=\.{0,1}\d{1,2}$|$)/ , message: '请输入正确的总额',trigger:'blur'}
                    ],
                    unit_price:[
                        {required:true,message:'请输入卖出单价',trigger:'blur'},
                        //两位正小数，最多6位
                        { pattern: /^\d{1,6}(?=\.{0,1}\d{1,4}$|$)/ , message: '请输入正确的单价',trigger:'blur'}
                    ],
                    market_price:[
                        {required:false,message:'请输入卖出市场价',trigger:'blur'},
                        //两位正小数，最多6位
                        { pattern: /^\d{1,6}(?=\.{0,1}\d{1,4}$|$)/ , message: '请输入正确的单价',trigger:'blur'}
                    ],
                    remark:[
                        {required:false,message:'小记',trigger:'blur'},
                        {max:255,min:'1',message:'不能超过255个字',trigger:'blur'}
                    ]
                },
                loading:false,
                dialogVisible: false,
                type:0,//新增为0 编辑为1
            }
        },
        methods:{
            handleAdd:function(index,row){
                
                const current_time = this.getCurentTime();
                this.type = 0;//新增标记
                this.title = "新增卖出";
                this.dialogVisible = true;
               
                console.log(row);
                this.saveForm = {
                    coin_buy_id:row.id,
                    buy_unit_price:row.unit_price, //买入时的单价
                    count:null,//卖出数量
                    buy_count:row.count,//买入数量
                    buy_money:row.total_money,//买入总额
                    sold_money:null,//卖出总额
                    sold_unit_price:null,//卖出单价
                
                    sold_time:current_time,
                    remark:null
            
                };
            },
           
            handleEdit(index,row){
                this.title="编辑卖出";
                this.dialogVisible = true;
                this.type = 1;
                let that = this;
             
            
                console.log('show',row);

                this.saveForm = {
                    id:row.id,
                    buy_unit_price:row.buy_unit_price,
                    buy_count:row.count,//买入数量
                    buy_money:row.buy_money,//买入总额
                    count:String(row.count),//卖出数量
                    sold_money:String(row.sold_money),//卖出总额
                    sold_unit_price:String(row.sold_price),//卖出单价
                    sold_time:row.sold_time,
                    remark:row.remark
                };
            },
           
            handleSave:function(){
//                this.saveForm = Object.assign({}, row);
               
                let that = this;
                if( this.type == 0){
                    //新增
                    this.$refs['saveForm'].validate( valid =>{
                        if( valid ){
                            axios.post('/back/sold/add',this.saveForm).then((res)=>{
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
                            axios.post('/back/sold/edit',this.saveForm).then((res)=>{
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
            //获取币种列表
            remoteMethod(){
                let that = this;
                setTimeout(function(){
                    axios.get('/back/coin/type').then( res =>{
                        if( res.status == 200){
                            console.log("okkk")
                            console.log(res.data);
                            that.coinTypeList = res.data.map(item => {
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
                console.log(time);
                this.saveForm.buy_time = time;
            },
            formatTime2(time){
                this.saveForm.end_time = time;
            },
            formatTime3(time){
                this.saveForm.true_start_time = time;

            },
            formatTime4(time){
                this.saveForm.true_end_time = time;
            },
            //获取当前时间
            getCurentTime(){ 
                var now = new Date();
                
                var year = now.getFullYear();       //年
                var month = now.getMonth() + 1;     //月
                var day = now.getDate();            //日
                
                var hh = now.getHours();            //时
                var mm = now.getMinutes();          //分
                var ss = now.getSeconds();           //秒
                
                var clock = year + "-";
                
                if(month < 10)
                    clock += "0";
                
                clock += month + "-";
                
                if(day < 10)
                    clock += "0";
                    
                clock += day + " ";
                
                if(hh < 10)
                    clock += "0";
                    
                clock += hh + ":";
                if (mm < 10) clock += '0'; 
                clock += mm + ":"; 
                
                if (ss < 10) clock += '0'; 
                clock += ss; 
                return(clock); 
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
