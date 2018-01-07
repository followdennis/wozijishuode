<template>
    <div class="row table_list">
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.query" placeholder="请输入关键词"></el-input>
                </el-form-item>
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
                @selection-change="selsChange" >
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column
                    type="index"
                    label="ID"
                    width="60">
            </el-table-column>
            <el-table-column
                    prop="question"
                    label="问题"
                    >
            </el-table-column>
            <el-table-column
                    prop="description"
                    label="描述"
            >
            </el-table-column>
            <el-table-column
                    prop="sort"
                    label="排序"
                    width="80">
            </el-table-column>
            <el-table-column
                    prop="createdAt"
                    label="创建时间"
                    width="150" >
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="200"
            >
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
            <el-col :span="24" class="toolbar" style="margin:4px;">
                <el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0">批量删除</el-button>
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
        <!--新增界面-->
        <el-dialog title="新增" v-model="addFormVisible" :close-on-click-modal="false">
            <el-form :model="addForm" label-width="80px" :rules="addFormRules" ref="addForm">
                <el-form-item label="问题" prop="question">
                    <el-col :span="22">
                        <el-input v-model="addForm.question" auto-complete="off"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item label="描述" prop="description">
                    <el-col :span="22">
                        <el-input v-model="addForm.description" auto-complete="off"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item label="排序">
                    <el-input-number v-model="addForm.sort" :min="0" :max="200"></el-input-number>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="addFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="addSubmit" :loading="addLoading">提交</el-button>
            </div>
        </el-dialog>
        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="80px" :rules="editFormRules" ref="editForm">
                <el-form-item label="问题" prop="question">
                    <el-col :span="22">
                        <el-input v-model="editForm.question" auto-complete="off"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item label="描述" prop="description">
                    <el-col :span="22">
                        <el-input v-model="editForm.description" auto-complete="off"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item label="排序值" prop="sort">
                    <el-input-number v-model="editForm.sort" :min="0" :max="200"></el-input-number>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
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
                filters:{
                    query:''
                },
                sels:[],

                addFormVisible: false,//新增界面是否显示
                addLoading: false,
                addFormRules: {
                    question: [
                        { required: true, message: '请输入问题', trigger: 'blur' }
                    ]
                },
                //新增界面数据
                addForm: {
                    question: '',
                    description:'',
                    sort: 0
                },
                editFormVisible:false,
                editLoading:false,
                editFormRules: {
                    question: [
                        { required: true, message: '请输入问题', trigger: 'blur' }
                    ]
                },
                //编辑界面数据
                editForm: {
                    id: 0,
                    question: '',
                    description:'',
                    sort: 0,
                }
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
                    query:this.filters.query
                }
                this.loading = true;
                axios.get('/back/diary/questions/lists',{params:params}).then((response)=>{
                    var data = response.data;
                    this.tableData = data.items;
                    this.page.total = data.total;
                    this.page.from = data.from;
                    this.page.to =data.to;
                    this.loading = false;
                }).catch(function(error){
                    console.log(error);
                });
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
            handleAdd:function(){
                this.addFormVisible = true;
                this.addForm = {
                    question: '',
                    sort: 0,
                };
            },
            addSubmit:function(){
                this.$refs.addForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.addLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.addForm);
                            axios.post('/back/diary/question/add',para).then((res)=>{
                                this.addLoading = false;
                                var response = res.data;
                                if(response.state){
                                    this.$message({
                                        message:response.msg,
                                        type:'success'
                                    });
                                }else{
                                    this.$message({
                                        message:response.msg,
                                        type:'error'
                                    });
                                }
                                this.$refs['addForm'].resetFields();
                                this.addFormVisible = false;
                                this.loadData();
                            })
                        }).catch();
                    }
                });
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                this.editFormVisible = true;
                this.editForm = Object.assign({}, row);
            },
            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.editForm);
                            console.log(para);
                            axios.post('/back/diary/question/edit',para).then((res)=>{
                                this.editLoading = false;
                                //NProgress.done();
                                var response = res.data;
                                if(response.state){
                                    this.$message({
                                        message:response.msg,
                                        type:'success'
                                    });
                                }else{
                                    this.$message({
                                        message:response.msg,
                                        type:'error'
                                    });
                                }
                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.loadData();
                            })
                        });
                    }
                });
            },
            batchRemove:function(){
                var ids = this.sels.map(item => item.id);
                this.$confirm('确认删除？','删除后将无法恢复',{}).then(()=>{
                    this.loading = true;
                    axios.post('/back/diary/question/del',{id:ids}).then((res)=>{
                        this.loading = false;
                        let response = res.data;
                        if(response.state){
                            this.$message({
                                message:response.msg,
                                type:'success'
                            })
                            this.loadData();
                        }else{
                            this.$message({
                                message:response.msg,
                                type:'error'
                            })
                        }
                    }).catch(()=>{
                        console.log('请求出错');
                    })
                }).catch(()=>{
                    console.log('取消批量删除');
                })

            },
            handleDelete:function(index,row){
                var array = [];
                array.push(row.id);
                this.$confirm('确认删除?','删除后将无法恢复',{}).then(()=>{
                    this.loading = true;
                    console.log(array);
                    axios.post('/back/diary/question/del',{id:array}).then((res)=>{
                        this.loading = false;
                        let response = res.data;
                        if(response.state){
                            this.loadData();
                            this.$message({
                                message:response.msg,
                                type:'success'
                            })
                        }else{
                            this.$message({
                                message:response.msg,
                                type:'error'
                            })
                        }
                    }).catch(()=>{
                        console.log('删除报错');
                    })
                }).catch(()=>{
                    console.log('取消');
                })

            }
        }
    }
</script>
