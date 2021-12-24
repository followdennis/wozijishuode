<template>
    <el-dialog
            :title="title"
            :visible.sync="dialogVisible"
            width="30%"
            :before-close="handleClose"
            center
    >

        <el-form ref="saveForm" :model="saveForm" :rules="rules" label-width="80px">
             <el-form-item label="币种" >
                <el-select v-model="saveForm.coin_type"
                           placeholder="请选择">
                    <el-option
                        v-for="item in coinTypeList"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value"

                    >
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="购买数量" prop="count">
                <el-input v-model="saveForm.count"></el-input>
            </el-form-item>
           
            <el-form-item label="购买总额" prop="total_money">
                <el-input v-model="saveForm.total_money"></el-input>
            </el-form-item>
            <el-form-item label="购买单价" prop="unit_price">
                <el-input v-model="saveForm.unit_price"></el-input>
            </el-form-item>
            
            <el-form-item label="市场价" prop="market_price">
                <el-input v-model="saveForm.market_price"></el-input>
            </el-form-item>
             <el-form-item label="可售数量" prop="left_count">
                <el-input v-model="saveForm.left_count"></el-input>
            </el-form-item>
           
            <el-form-item label="小记" prop="remark">
                <el-input type="textarea" :rows="6" v-model="saveForm.remark"></el-input>
            </el-form-item>
           
            <el-form-item label="开始时间">
                <el-col :span="10">
                    <el-date-picker
                            type="datetime"
                            placeholder="选择日期"
                            v-model="saveForm.buy_time"
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
           
            this.getCoinTypeList();
            
        },
        computed:{
            
        },
        created() {
           
        },
        watch:{
            'saveForm.count'(val,oldVal){
                //来自新增页
                if( this.type == 0){
                    console.log( val,oldVal);
                    this.saveForm.left_count = val;
                }
            },
            'saveForm.left_count'(val,old){
                if( this.type == 0){
                    this.saveForm.count = val;
                }
            }
        },
        data(){
            return {
                msg: '开始',
                saveForm:{
                    id:0,
                    count:0,//购买数量
                    total_money:0,//购买总额
                    unit_price:0,//购买单价
                    market_price:0,//购买时市场价
                    left_count:0,//可售数量
                    coin_type:0,
                    buy_time:null,
                    remark:null
                },
                title:"提示",
                coinTypeList:[],
                rules:{
                
                    count:[
                        {required:true,message:'输入数量',trigger:'blur'},
                        //两位正小数，最多6位
                        { pattern: /^\d{1,6}(?=\.{0,1}\d{1,4}$|$)/ , message: '请输入正确的数量',trigger:'blur'}
                    ],
                    total_money:[
                        {required:true,message:'请输入总额',trigger:'blur'},
                        //两位正小数，最多6位
                        { pattern: /^\d{1,6}(?=\.{0,1}\d{1,2}$|$)/ , message: '请输入正确的总额',trigger:'blur'}
                    ],
                    unit_price:[
                        {required:true,message:'请输入购买单价',trigger:'blur'},
                        //两位正小数，最多6位
                        { pattern: /^\d{1,6}(?=\.{0,1}\d{1,4}$|$)/ , message: '请输入正确的单价',trigger:'blur'}
                    ],
                    market_price:[
                        {required:true,message:'请输入市场价',trigger:'blur'},
                        //两位正小数，最多6位
                        { pattern: /^\d{1,6}(?=\.{0,1}\d{1,4}$|$)/ , message: '请输入正确的市场价',trigger:'blur'}
                    ],
                    left_count:[
                        {required:true,message:'输入数量',trigger:'blur'},
                        //两位正小数，最多6位
                        { pattern: /^\d{1,6}(?=\.{0,1}\d{1,4}$|$)/ , message: '请输入正确的数量',trigger:'blur'}
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
            handleAdd:function(type){
                const current_time = this.getCurentTime();
                this.type = 0;//新增标记
                this.title = "新增购买";
                this.dialogVisible = true;
               
                this.saveForm = {
                    count:null,//购买数量
                    total_money:null,//购买总额
                    unit_price:null,//购买单价
                    market_price:null,//购买时市场价
                    left_count:null,//可售数量
                    coin_type:1,
                    buy_time:current_time,
                    remark:null
                };
            },
            getCoinTypeList(){
              let that = this;
              axios.get('/back/coin/type').then( res =>{
                        if( res.status == 200){
                        
                            that.coinTypeList = res.data.map(item => {
                                return {
                                    value:item.id,
                                    label:item.coin_name + "(" + item.alias + ")"
                                }
                            });
                        }
                    })
            },
            handleEdit(index,row){
                this.title="编辑购买";
                this.dialogVisible = true;
                this.type = 1;
                let that = this;
                console.log('plan_id',row.plan_id);
             
                console.log('show',row);

                this.saveForm = {
                    id:row.id,
                    count:String(row.count),//购买数量
                    total_money:String(row.total_money),//购买总额
                    unit_price:String(row.unit_price),//购买单价
                    market_price:String(row.market_price),//购买时市场价
                    left_count:String(row.left_count),//可售数量
                    coin_type:row.coin_type.id,
                    buy_time:row.buy_time,
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
                            axios.post('/back/buy/add',this.saveForm).then((res)=>{
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
                            axios.post('/back/buy/edit',this.saveForm).then((res)=>{
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
