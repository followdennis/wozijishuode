<template>
    <ul>
        <li class="comment-item" v-for="item in page.items">
            <a class="avatar-wrap">
                <img src="//upload.jianshu.io/users/upload_avatars/8415343/485bd37f-6e41-4445-9a85-71b6baec3728.jpg?imageMogr2/auto-orient/strip|imageView2/1/w/64/h/64">
            </a>
            <div class="comment-content">
                <div class="comment-user-info">
                    <a href="#" target="_blank" class="comment-user-name">{{ item.user_name }}</a>
                    <span class="comment-time">{{ item.created_at }}</span>
                </div>
                <p>{{ item.comment }}</p>
                <div class="comment-footer">
                    <span class="comment-reply">回复</span>
                    <span class="comment-expend-reply" @click="openMore(item)">{{ item.comment_count }}条评论</span>
                    <span title="举报" class="comment-report comment-float-right"><i class="fa fa-info-circle"></i></span>
                    <span title="点赞" class="comment-like comment-float-right ">{{ item.like }} <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                    <span title="删除" v-show="item.del_flag" class="comment-del comment-float-right "> <i class="fa fa-times" aria-hidden="true"></i></span>
                </div>
                <div class="c_comment_input_0"></div>
                <comment-more v-if="item.open" v-bind:article_id="item.article_id" v-bind:parent_id="item.comment_id" v-bind:top_parent_id="item.comment_id"></comment-more>
            </div>
        </li>
    </ul>
</template>
<script>
    import CommentMore from './CommentMore';
    export default {
        components: {
            CommentMore: CommentMore
        },
        mounted() {
            console.log('Component mounted.');
            this.loadData();
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
                    article_id:'V3jZ7EDNpYB9DLxW',
                    parent_id:0,
                    top_parent_id:0
                }
                this.loading = true;
                axios.get('/comment/lists',{params:params}).then((response)=>{
                    var data = response.data;
                    this.page.items = data.items;

                    console.log(this.items);
                    this.loading = false;
                }).catch(function(error){
                    console.log(error);
                });
            },
            openMore:function(item){
                item.open = !item.open;
            }
        }

    }
</script>