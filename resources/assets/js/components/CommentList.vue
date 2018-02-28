<template>
    <div class="comment">
        <div class="comment-count"><em>{{ comment_count }}&nbsp;</em>条评论</div>
        <div class="comment-input">
            <form id="leave_comments" method="post">
                <div class="comment-input-area">
                    <textarea placeholder="写下您的评论" v-model="addForm.comment"></textarea>
                </div>
                <div class="comment-input-button">
                    <div class="input-submit" @click="handleSubmit">评论</div>
                </div>
            </form>
        </div>
        <ul>
            <li class="comment-item" v-for="item in page.items">
                <a class="avatar-wrap">
                    <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64">
                </a>
                <div class="comment-content">
                    <div class="comment-user-info">
                        <a href="#" class="comment-user-name">{{ item.user_name }}</a>
                        <span class="comment-time">{{ item.created_at }}</span>
                    </div>
                    <p>{{ item.comment }}</p>
                    <div class="comment-footer">
                        <span class="comment-reply" @click="comment(item)" >回复</span>
                        <span class="comment-expend-reply" @click="item.has_more && openMore(item)">{{ item.comment_count }}条评论</span>
                        <span title="举报" class="comment-report comment-float-right" @click="handleTipOffs(item)"><i class="fa fa-info-circle"></i></span>
                        <span title="点赞" class=" comment-float-right" :id="'like-tips-'+item.comment_id" v-bind:class="{ 'comment-like':!item.liked,'clicked-like':item.liked}" @click="handleLike(item)">{{ item.like }} <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                        <span title="删除" v-show="item.del_flag" class="comment-del comment-float-right" @click="handleDel(item)"> <i class="fa fa-times" aria-hidden="true"></i></span>
                    </div>
                    <comment-input v-if="item.reply_flag" v-bind:article_id="item.article_id" v-bind:comment_id="item.comment_id" v-bind:top_comment_id="item.comment_id" @child_info="handleMiddleSubmit"></comment-input>
                    <div class="c_comment_input_0"></div>
                    <comment-more v-if="item.open" v-bind:is_login="is_login" v-bind:parent_items="page.items" v-bind:article_id="item.article_id" v-bind:parent_id="item.comment_id" v-bind:top_parent_id="item.comment_id"></comment-more>
                </div>
            </li>
        </ul>
    </div>

</template>
<style>
    .clicked-like{
        color: #ff443a;
        cursor: pointer;
        font-size: 16px;
    }
</style>
<script>
    import CommentMore from './CommentMore';
    import CommentInput from './CommentInput';
    export default {
        components: {
            CommentMore: CommentMore,
            CommentInput:CommentInput
        },
        mounted() {
            console.log('Component mounted.');
            this.loadData();
        },
        props:{
            article_id:{
                type:String,
                required:true
            },
            comment_count:{
                type:String,
                required:true
            },
            is_login:{
                type:String,
                required:true
            }
        },
        data(){
            return {
                page:{
                    total:0,
                    currentPage:1,
                    hasMore:false,
                    from:1,
                    to:1,
                    items:[]
                },
                addForm:{
                    comment:'',
                    comment_id:0,
                    top_comment_id:0,
                    article_id:''
                }

            }
        },
        methods:{
            loadData:function(){
                let params = {
                    page:this.page.currentPage,
                    article_id:this.article_id,
                    parent_id:0,
                    top_parent_id:0
                }
                this.loading = true;
                axios.get('/comment/lists',{params:params}).then((response)=>{
                    var data = response.data;
                    for(var i = 0; i< data.items.length;i++ ){
                       data.items[i].reply_flag = false;
                       data.items[i].liked = false;
                    }
                    this.page.items = data.items;

                    this.loading = false;
                }).catch(function(error){
                    console.log(error);
                });
            },
            //展开评论
            openMore:function(item){
                item.open = !item.open;
            },
            //加载更多
            loadMore:function(){

            },
            //展示评论表单
            comment:function(item){
                item.reply_flag = !item.reply_flag;
                for(var i = 0; i<this.page.items.length;i++){
                    if(item.comment_id == this.page.items[i].comment_id){
                        continue;
                    }else{
                        this.page.items[i].reply_flag = false;
                    }
                }
            },
            CheckInputArea:function(){
                alert('0jbk');
            },
            handleSubmit:function(){

                if(this.is_login == 0){
                    this.handleLoginCheck();
                }else{
                    this.addForm.article_id = this.article_id;
                    let para = Object.assign({}, this.addForm);
                    axios.post('/comment/add',para).then((res)=>{
                        this.addLoading = false;
                        var response = res.data;
                        console.log(res);
                        if(response.state){
//                            this.$message({
//                                message:response.msg,
//                                type:'success'
//                            });
                            layer.msg('评论成功', {
                                icon: 1,
                                time: 1000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){

                            });
                            this.addForm.comment = '';
                            console.log(res);
                        }else{
                            console.log(res);
                              layer.msg('评论失败', {icon: 5});

                        }
                        this.addFormVisible = false;
                        this.loadData();
                        //错误处理

                    }).catch()
                }

            },
            handleMiddleSubmit:function(data){
                if(this.is_login == 0){
                    this.handleLoginCheck();
                }else{
                    var _this = this;
                    this.addForm.article_id = this.article_id;
                    let para = Object.assign({}, data);
                    axios.post('/comment/add',para).then((res)=>{
                        this.addLoading = false;
                        var response = res.data;
                        console.log(res);
                        if(response.state){
//                            this.$message({
//                                message:response.msg,
//                                type:'success'
//                            });
                            layer.msg('评论成功', {
                                icon: 1,
                                time: 1000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){

                            });
                            this.loadData();
                            this.addForm.comment = '';
                            console.log(res);
                        }else{
                            console.log(res);
                            layer.msg('评论失败', {icon: 5});

                        }
                        this.addFormVisible = false;

                        //错误处理

                    }).catch()
                }
            },
            //删除评论
            handleDel:function(item){
                var _this = this;
                layer.msg('确定删除？', {
                    time: 0 //不自动关闭
                    ,btn: ['确定', '取消']
                    ,yes: function(index){
                        layer.close(index);
                        var url = '/comment/del';
                        let params = {
                            comment_id:item.comment_id,
                            top_parent_id:item.top_parent_id
                        }
                        axios.get(url, {
                            params: params
                        }).then(function (res) {
                            var response = res.data;
                            if(response.state == 1){
                                layer.msg('删除成功', {
                                    icon: 1,
                                    time: 1000 //2秒关闭（如果不配置，默认是3秒）
                                }, function(){

                                });
                                _this.loadData();
                            }else{
                                layer.msg('删除失败', {icon: 5});
                            }
                        }).catch(function (error) {
                            console.log(error);
                        });

                    }
                });
            },
            //举报处理
            handleTipOffs(item){
                layer.prompt({title: '请输入举报原因', formType: 2}, function(pass, index){
                    console.log(pass);
                    layer.close(index);
                });
            },
            handleLike:function(item){
               if(this.is_login == 0){
                    this.handleLoginCheck();
               }else{
                   let params = {
                       comment_id:item.comment_id,
                       article_id:item.article_id,
                   }
                   if(item.liked == false){
                       var url = '/comment/like';
                       axios.get(url, {
                           params: params
                       }).then(function (res) {
                           var response = res.data;
                           if(response.state == 1){
                               item.liked = true;
                               item.like = item.like+1;
                               layer.tips('+1','#like-tips-'+item.comment_id, {
                                   tips: [1, '#fb4c4c'],
                                   time:1500
                               });
                           }else if(response.state == 2){
                               item.liked = true;
                               layer.tips('您已经赞过了哦', '#like-tips-'+item.comment_id, {
                                   tips: [1, '#fb4c4c'],
                                   time: 1500
                               });
                           }else{
                               layer.msg('点赞失败', {icon: 5});
                           }
                       }).catch(function (error) {
                           console.log(error);
                       });
                   }else{
                       layer.tips('您已经赞过了哦', '#like-tips-'+item.comment_id, {
                           tips: [1, '#fb4c4c'],
                           time: 1500
                       });
                   }
               }
            },
            //判断登陆
            handleLoginCheck:function(){
                var msg = '登陆';
                layer.open({
                    type: 2,
                    title: '请先'+msg,
                    shadeClose: true,
                    skin:'my-skin',
                    btn: ['确定','取消'], //按钮
                    yes:function(index, layero){
                        var formData = layer.getChildFrame('body');
                        var form = formData.find('#doSubmit').serialize();
                        var login_flag = formData.find('input[name="is_login"]').val();
                        var url = '';

                        if(login_flag == 1){
                            url = "/login";
                            msg = '登陆';
                        }else if(login_flag == 0){
                            url = "/register";
                            msg = '登陆';
                        }

                        $.ajax({
                            url: url,
                            data: form,
                            type: "post",
                            dataType: "json",
                            async: false,
                            success: function (data) {
                                if(data.state == 1){
                                    layer.msg(msg+'成功', {
                                        icon: 1,
                                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                                    }, function(){
                                        window.parent.location.reload();
                                        layer.close(index);
                                    });
                                }else{
                                    layer.msg(msg+'失败。。', {icon: 5});
                                }
                            },
                            error: function(data) {
                                var error_msg = '';
                                $.each(data.responseJSON.errors, function (index, obj) {
                                    error_msg += error_msg + index+" : "+obj[0] + "<br/>";
                                    return false;
                                });
                                layer.msg(error_msg, {icon: 5});
                            }
                        })
                    },
                    shade: 0.8,
                    area: ['400px', '500px'],
                    content: '/login?layer=1', //iframe的url
                    cancel: function(index){ //或者使用btn2
                        layer.closeAll();
                    },
                    end:function(index){
//                    layer.closeAll();
                    }
                });
            }
        }
    }
</script>