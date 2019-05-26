<template>
    <div class="row table_list">
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.query" placeholder="请输入关键词"></el-input>
                </el-form-item>
                <el-select v-model="filters.plan_id"
                           filterable
                         
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
                    <el-button type="primary" v-on:click="getBuyList">查询</el-button>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="handleAdd" >新增</el-button>
                </el-form-item>
            </el-form>
        </el-col>
        <el-table
            border
            show-summary
            :summary-method="getSummaries"
            :data="buylist"
            style="width: 100%">
            <el-table-column type="expand">
            <template slot-scope="props">
                <el-table
                
                :data="props.row.sold_list"
                style="width: 100%">
                <el-table-column
                    prop="id"
                    label="ID"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="count"
                    label="售出数量"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="sold_money"
                    label="售出总额"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="sold_price"
                    label="售出单价"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="price_diff"
                    label="差价"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="profit_margin"
                    label="利润率(%)"
                    width="180">
                </el-table-column>
                <el-table-column
                    prop="gross_profit"
                    label="纯利润">
                </el-table-column>
                <el-table-column
                    prop="sold_time"
                    label="卖出时间">
                </el-table-column>
                <el-table-column
                   
                    label="操作" >
                    <template slot-scope="scope">
                        <el-button
                            size="small"
                            type="warning"
                            @click="handleEditSold(scope.$index,scope.row)"
                            >
                            编辑
                        </el-button>
                        <el-button
                                size="small"
                                type="danger"
                            >删除</el-button>
                    </template>
                </el-table-column>
                </el-table>
            </template>
            </el-table-column>
            <el-table-column
            label="ID"
            prop="id">
            </el-table-column>
        
            <el-table-column
            label="币种"
            prop="coin_name">
            </el-table-column>
            <el-table-column
            label="购入数量"
            prop="count">
            </el-table-column>
            <el-table-column
            label="总金额"
            prop="total_money">
            </el-table-column>
            <el-table-column
            label="购入单价"
            prop="unit_price">
            </el-table-column>

            <el-table-column
            label="市场价格"
            prop="market_price">
            </el-table-column>
            <el-table-column
            label="买入时间"
            prop="buy_time">
            </el-table-column>
            <el-table-column
            label="可售数量"
           >
                <template slot-scope="scope">
                        <span v-html="scope.row.left_count_html"></span>
                    </template>
            </el-table-column>
             <el-table-column
            label="卖出数量"
            prop="sold_count">
            </el-table-column>
             <el-table-column
            label="卖出总额"
            prop="sold_money">
            </el-table-column>
              <el-table-column
            label="利润率(%)"
            prop="sold_profit_rate">
            </el-table-column>
            <el-table-column
            label="总利润"
            prop="sold_profit">
            </el-table-column>

            <el-table-column
            label="操作"
            >
            <template slot-scope="scope">
                    <el-button
                            size="small"
                            type="primary"
                            @click="handleEdit(scope.$index, scope.row)">编辑</el-button>

                    <el-button
                        size="small"
                        type="warning"
                        @click="handleAddSold(scope.$index,scope.row)"
                        >
                        卖出
                    </el-button>
                    <el-button
                            size="small"
                            type="danger"
                           >删除</el-button>
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
        <add-buy ref="addBuy" @eventFromChild="getBuyList"></add-buy>
        <add-sold ref="addSold" @eventFromChild="getBuyList"></add-sold>
    </div>
</template>
<script>
    import ElButton from "../../../../../node_modules/element-ui/packages/button/src/button";
    import addBuy from "./addBuy.vue";
    import addSold from "./addSold.vue";
    export default {
        props:[
          'plan_id'
        ],
        components: {
            ElButton,
            addBuy,
            addSold
        },
        mounted() {
            this.filters.plan_id =this.plan_id == 0 ? '':this.plan_id;
           
            this.getBuyList();
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
               
                page:{
                    total:0,
                    perPage:10,
                    currentPage:1,
                    lastPage:0,
                    from:0,
                    to:0
                },
                importanceList:[],
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
                buylist: [],

                loading:false,
                time_count:null,
                dialogVisible: false,
                type:0  //0 新增 1 编辑
            }
        },
        methods:{
            
            getBuyList(){

                    let params = {
                        page:this.page.currentPage,
                        perPage:this.page.perPage
                    }
                    axios.get('/back/buy/lists',{params:params}).then(res => {
                        console.log(res.data);
                        if( res.status == 200){
                           let data = res.data.items.map( item => {
                                let left_count = null;
                                if( item.left_count == item.count){
                                    item.left_count_html = '<font color="red">未售出</font>';
                                } else if( item.left_count == 0){
                                    item.left_count_html = '<font color="green">已售完</font>';
                                } else {
                                    item.left_count_html = item.left_count;
                                }
                            
                                return item;
                            });
                           console.log(111,res.data.total);
                            this.buylist = data;
                            this.page.total = res.data.total;
                            this.page.from = res.data.from;
                            this.page.to = res.data.to;
                            this.loading = false;
                        } else {
                            console.log(res);
                            // this.$message({
                            //     type: 'error',
                            //     message: '删除失败!',
                            //     duration:2000
                            // });
                        }
                    })
            },
            handleAdd:function(){
               
                this.$refs.addBuy.handleAdd(0);
            },
            handleEdit(index,row){

                this.$refs.addBuy.handleEdit(index,row);
            },
            //新增卖出
            handleAddSold(index,row){
                this.$refs.addSold.handleAdd(index,row);
            },
            //编辑卖出
            handleEditSold(index,row){
                this.$refs.addSold.handleEdit(index,row);
            },
            //统计
            getSummaries(param){
                const { columns, data } = param;

                const sums = [];
                columns.forEach((column, index) => {
                    if (index === 0) {
                        sums[index] = '汇总';
                        return;
                    }
                    if( index === 1 || index === 3 || index === 5 || index === 6 || index === 9 || index === 11){
                        sums['index'] = '';
                        return;
                    }
                    const values = data.map(item => Number(item[column.property]));
                    if (!values.every(value => isNaN(value))) {
                        sums[index] = values.reduce((prev, curr) => {
                            const value = Number(curr);
                            if (!isNaN(value)) {
                                return prev + curr;
                            } else {
                                return prev;
                            }
                        }, 0);
                        sums[index] += ' 元';
                    } else {
                        sums[index] = '';
                    }
                });

                return sums;
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
                            // that.loadData();
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
                this.getBuyList();
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val} ${this.page.perPage}`);
                this.page.currentPage = val;
                this.getBuyList();
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
    .demo-table-expand {
    font-size: 0;
  }
  .demo-table-expand label {
    width: 90px;
    color: #99a9bf;
  }
  .demo-table-expand .el-form-item {
    margin-right: 0;
    margin-bottom: 0;
    width: 50%;
  }
</style>