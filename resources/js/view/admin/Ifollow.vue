<template>
    <div class="swap-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title-box d-flex justify-content-between">
                    <h4 class="page-title">Kiểm tra link trên hệ thống</h4>
                    <el-breadcrumb>
                        <el-breadcrumb-item :to="{ path: '/dashboard' }">Dashboard</el-breadcrumb-item>
                        <el-breadcrumb-item>Check Url</el-breadcrumb-item>
                    </el-breadcrumb>
                </div>
            </div>
        </div>
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
            <div v-if="data">
                <el-alert
                    type="success"
                    show-icon>
                    Link {{ urlSuccess }} đã về hệ thống!
                </el-alert>
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                    </div>
                    <div>
                        Website: {{ domain }}
                    </div>
                    <div>
                        Số lượng tin từ website này đã lấy về hệ thống: {{ infoDomain.hits.total }}
                    </div>
                    <div>
                        Số lượng alert từ website này: {{ infoDomain.aggregations.domain_alerted.doc_count }}
                    </div>
                    <div>
                        Đã có trong danh sách trực tiếp: {{ hasWebsite ? "Có" : "Không" }}
                    </div>
                    <div>
                        Đã có trong danh sách google api: {{ hasGoogleApi ? "Có" : "Không" }}
                    </div>
                </el-card>
                <el-card v-for="(item, index) in data" class="box-card" :key="item.id">
                    <div slot="header" class="clearfix">
                    </div>
                    <div>
                        ID ES: {{ item._id }}
                    </div>
                    <div>
                        Brand Id: {{ item._source.web_brand_id }}
                    </div>
                    <div>
                        Object Id: {{ item._source.web_object_id }}
                    </div>
                    <div>
                        Web key work: {{ item._source.web_keyword }}
                    </div>
                    <div>
                        Parent object id: {{ item._source.web_parent_object_id }}
                    </div>
                    <div>
                        Thời gian tạo: {{ item._source.web_created | moment }}
                    </div>
                    <div>
                        Thời gian sửa: {{ item._source.web_content_updated }}
                    </div>
                    <div>
                        Cảnh báo: {{ getAlert(item._source.web_status_3) }}
                    </div>
                    <div>
                        Trạng thái: {{ getStatus(item._source.web_state) }}
                    </div>

                </el-card>
            </div>
            <el-card v-else-if="message" class="box-card">
                <div slot="header" class="clearfix">
                    <span>Thông báo</span>
                </div>
                <div>
                    <el-alert
                        :title="message"
                        type="error"
                        show-icon
                    >
                    </el-alert>
                </div>
            </el-card>

        </div>
    </div>
</template>
<script>
import moment from 'moment';
import {mapGetters} from 'vuex'
import AuthMinxin from "../../mixins/auth-mixin";

export default {
    mixins: [AuthMinxin],
    data() {
        return {
            url: '',
            urlSuccess: '',
            data: '',
            message: '',
            domain: '',
            infoDomain: '',
            hasWebsite: false,
            hasGoogleApi: false,
        }
    },
    computed: {
        web_created() {
            if (this.data)
                return moment.unix(this.data[0]._source.web_created).format('YYYY-MM-DD HH:mm:ss');
        },
    },
    filters: {
        moment: function (date) {
            return moment.unix(date).format('YYYY-MM-DD HH:mm:ss');
        }
    },
    methods: {
        getStatus(status) {
            if (status === 1) {
                return 'tích cực'
            } else if (status === 2) {
                return "tiêu cực"
            } else {
                return 'trung tính'
            }
        },
        getAlert(alert) {
            if (alert === 1) {
                return 'đã cảnh báo'
            } else {
                return 'chưa cảnh báo'
            }
        },
        checkUrl() {
            this.startLoading()
            this.resetData()
            axios.post('/api/admin/check-url', {"url": this.url}).then((response) => {
                this.stopLoading()
                this.urlSuccess = response.data.url
                this.domain = response.data.domain
                this.infoDomain = response.data.infoDomain
                this.hasWebsite = response.data.hasWebsite
                this.hasGoogleApi = response.data.hasGoogleApi
                this.data = response.data.data.hits.hits
            }).catch((errors) => {
                this.stopLoading()
                if (errors.response) {
                    if (errors.response.status === 404) {
                        this.message = errors.response.data.data
                    } else if (errors.response.status === 422) {
                        this.message = "Vui lòng nhập đúng đường link!"
                    } else if (errors.response.status == 403) {
                        this.logout()
                        this.message = 'Bạn không có quyền thực hiện thao tác này. Liên hệ admin để có thêm thông tin!!!'
                    } else {
                        this.message = "Đã có lỗi xảy ra!"
                    }
                }
            })
        },
        resetData() {
            this.data = ''
            this.message = ''
            this.urlSuccess = ''
            this.domain = ''
            this.infoDomain = ''
        }
    }
}
</script>
<style scoped>
.box-card {
    margin-top: 20px;
    margin-bottom: 20px;
}

.button-search {
    margin-left: 10px;
    margin-right: 10px;
}
</style>
