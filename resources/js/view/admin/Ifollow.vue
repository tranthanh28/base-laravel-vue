<template>
    <div>
        <div class="d-flex justify-content-center">
            <el-input
                placeholder="url"
                prefix-icon="el-icon-search"
                v-model="url"
                style="width:500px"
            >
            </el-input>
            <el-button class="button-search" type="primary" round @click="checkUrl">Search</el-button>
        </div>
        <el-card v-if="data" class="box-card">
            <div slot="header" class="clearfix">
                <span>Link {{url}} đã về hệ thống! </span>
            </div>
            <div class="text item">
                thoi gian tao: {{data}}
            </div>
            <div class="text item">
                thoi gian sua: {{data}}
            </div>

        </el-card>
        <el-card v-else-if="message" class="box-card">
            <div slot="header" class="clearfix">
                <span>Thong bao</span>
            </div>
            <div class="text item">
                {{message}}
            </div>
        </el-card>

    </div>

</template>
<script>
export default {
    data() {
        return {
            url: '',
            data: '',
            message: '',
        }
    },
    methods: {
        checkUrl() {
            axios.post('/api/checkUrl', {"url": this.url}).then((response) => {
                console.log("response")
                console.log(response)
                this.data = response.data.data
            }).catch((errors) => {
                if(errors.response) {
                    console.log(errors.response)
                    if(errors.response.status == 404) {
                        this.message = errors.response.data.data
                    }
                }

            })
        }
    }
}
</script>
<style scoped>
.button-search {
    margin-left: 10px;
    margin-right: 10px;
}
.box-card {
    margin-top: 20px;
    margin-bottom: 20px;
}
</style>
