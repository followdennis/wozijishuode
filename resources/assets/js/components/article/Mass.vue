<template>
    <div class="row table_list">
        <el-table
                :data="tableData"
                border
                style="width: 100%"
                v-loading="loading"
                element-loading-text="加载中..."
                element-loading-spinner="el-icon-loading"
                element-loading-background="rgba(0, 0, 0, 0.8)">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="名称"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="title"
                    label="标题"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="content"
                    label="正文">
                <template slot-scope="scope">
                    <div v-html="scope.row.content"></div>
                </template>
            </el-table-column>
            <el-table-column
                    label="操作">
                <template slot-scope="scope">
                    <el-button
                            size="small"
                            type="primary"
                            @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button
                            size="small"
                            type="danger"
                            @click="handleDelete(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="block">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="page.currentPage"
                    :page-sizes="[2,10, 20, 50, 100]"
                    :page-size="page.perPage"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="page.total">
            </el-pagination>

        </div>
    </div>
</template>
<style scoped="scope">
    .table_list{
        margin:0px;
    }
</style>
<script>
    export default {
        mounted() {
            this.loadData();
            console.log('Component mounted.')
        },
        data(){
            return {
                msg:'hei hei  ',
                code:200,
                tableData: [],
                page:{
                    total:0,
                    perPage:10,
                    currentPage:1,
                    lastPage:0,
                    from:0,
                    to:0
                },
                loading:false,
                //搜索条件
                criteria:'',
            }
        },

        methods:{
            rowClick:function(){
                alert('abc');
            },
            sortChange:function(){

            },
            loadData:function(){
                let params = {
                    page:this.page.currentPage,
                    perPage:this.page.perPage,
                    query:this.criteria
                }
                this.loading = true;
                axios.get('/back/articles/mass/list',{params:params}).then((response)=>{
                    var data = response.data;
                    this.tableData = data.items;
                    this.page.total = data.total;
                    this.loading = false;
                }).catch(function(error){
                    console.log(error);
                });

            },
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
                this.page.perPage = val;
                this.loadData(this.criteria,this.page.currentPage,this.page.perPage);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val} ${this.page.perPage}`);
                this.page.currentPage = val;
                this.loadData(this.criteria,this.page.currentPage,this.page.perPage);
            },
            add:function(){
                alert('add');
            },
            deletenames:function(){
                alert('delete');
            },
            search:function(){
                this.loadData(this.criteria, this.currentPage, this.pagesize);
            },
            handleEdit:function(){
                this.$prompt('请输入新名称','提示',{
                    confirmButtonTest:'确定',
                    cancelButtonText:'取消',
                }).then(( value ) =>{
                    if( value == '' || value == null){
                        return ''
                    }
                    alert('edit');
                    axios.post('/api/get_list/edit',{'id':row.id,'name':row.name}).then(function(res){
                        if(res.data.status == 1){

                        }else{

                        }
                    }).catch(()=>{
                        console.log('failed');
                    })

                });
            },
            handleDelete:function(index,row){
                var array = [];
                array.push(row.id);

                axios.post('/api/get_list/del',{array:array}).then((response) =>{
                    var res = response.data;
                    if(res.status == 1){
                        alert(res.msg);
                    }else{
                        alert(res.msg);
                    }
                    this.loadData(this.criteria,this.page.currentPage,this.page.perPage);
                }).catch(function(error){
                    console.log(error);
                });

            }
        }
    }
</script>
