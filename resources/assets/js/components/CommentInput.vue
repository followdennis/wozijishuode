<template>
    <div class="inner_comment_box">
        <div class="comment-input">
            <form id="leave_comments" method="post">
                <div class="comment-input-area">
                    <textarea placeholder="写下您的评论"  v-model="addForm.comment"></textarea>
                </div>
                <div class="comment-input-button">
                    <div class="input-submit" @click="handleSubmit">评论</div>
                </div>
            </form>
        </div>
    </div>
</template>
<style>
    .inner_comment_box{
        padding:5px 0;
    }
</style>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props:{
            article_id:{
                type:String,
                required:true
            },
            comment_id:{
                type:Number,
                required:true
            },
            top_comment_id:{
                type:Number,
                required:true
            },
        },
        data(){
            return {
                addForm:{
                    comment:'',
                    article_id:'',
                    comment_id:0,
                    top_comment_id:0
                }
            }
        },
        methods:{
            handleSubmit:function(){
                this.addForm.article_id = this.article_id;
                this.addForm.comment_id = this.comment_id;
                this.addForm.top_comment_id = this.top_comment_id;
                this.$emit("child_info",this.addForm);
                this.addForm.comment = '';
            }

        }
    }
</script>
