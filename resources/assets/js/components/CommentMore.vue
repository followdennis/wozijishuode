<template>
    <div>
        <div class="comment-children" v-for="item in page.items">
            <a class="avatar-wrap">
                <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64">
            </a>
            <div class="c-comment-reply">
                <div class="comment-user-info">
                    <a href="#" target="_blank" class="comment-user-name">{{ item.user_name }}</a>
                    <span class="comment-time">{{ item.created_at }}</span>
                </div>
                <p>这是条评论</p>
                <div class="comment-footer">
                    <span class="comment-reply">回复</span><span class="comment-expend-reply"></span>
                    <span title="举报" class="comment-report comment-float-right"><i class="fa fa-info-circle"></i></span>
                    <span title="点赞" class="comment-like comment-float-right ">{{ item.like }} <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        mounted() {
            console.log('Component mounted.');
            this.loadData();
        },
        props:{
            article_id:{
                type:String,
                required:true
            },
            parent_id:{
                type:Number,
                required:true
            },
            top_parent_id:{
                type:Number,
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
                }
            }
        },
        methods:{
            loadData:function(){
                let params = {
                    page:this.page.currentPage,
                    article_id:this.article_id,
                    parent_id:this.parent_id,
                    top_parent_id:this.top_parent_id
                }
                this.loading = true;
                axios.get('/comment/lists',{params:params}).then((response)=>{
                    var data = response.data;
                    this.page.items = data.items;
                    console.log(this.parent_id);
                    console.log(this.page.items);
                    this.loading = false;
                }).catch(function(error){
                    console.log(error);
                });
            },
            test:function(o){
                alert(o);
            }
        }
    }
</script>