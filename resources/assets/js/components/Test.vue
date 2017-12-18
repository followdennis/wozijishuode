<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">组件案例2</div>

                    <div class="panel-body">
                        我是一个测试
                        {{msg}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
                msg:'hei hei  ',
                code:200
            }
        }
    }
</script>
