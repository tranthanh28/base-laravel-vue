<template>
    <div class="swap-content">
        <div class="col-xs-12">
            <div class="page-title-box d-flex justify-content-between">
                <h4 class="page-title">User Management</h4>
                <el-breadcrumb>
                    <el-breadcrumb-item :to="{ path: '/dashboard' }">Dashboard</el-breadcrumb-item>
                    <el-breadcrumb-item>User Management</el-breadcrumb-item>
                </el-breadcrumb>
            </div>
        </div>

        <div>
            <div>
                <h2>Users list</h2>
                <div v-if="data">
                    <el-tabs v-model="activeName" @tab-click="handleClickTab">
                        <el-tab-pane label="All" name="3"></el-tab-pane>
                        <el-tab-pane label="Active" name="1"></el-tab-pane>
                        <el-tab-pane label="Inactive" name="0"></el-tab-pane>
                    </el-tabs>
                    <el-table
                        :data="data"
                        highlight-current-row
                        style="width: 100%">
                        <el-table-column
                            type="index"
                            width="50">
                        </el-table-column>
                        <el-table-column
                            prop="email"
                            label="Email"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="name"
                            label="Name"
                        >
                        </el-table-column>
                        <el-table-column
                            label="Status">
                            <template slot-scope="scope">
                                <el-tag
                                    :type="scope.row.status ? 'primary' : 'danger'"
                                    disable-transitions>{{ scope.row.status ? "active" : "inactive" }}
                                </el-tag>

                            </template>
                        </el-table-column>
                        <el-table-column>
                            <template slot-scope="scope">
                                <el-button
                                    size="mini"
                                    type="primary"
                                    @click="handleEdit(scope.row)">Edit
                                </el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                    <el-pagination
                        background
                        layout="prev, pager, next"
                        @current-change="handleCurrentChange"
                        :current-page.sync="currentPage"
                        :page-size="perPage"
                        :total="totalPages">
                    </el-pagination>
                </div>
            </div>
            <el-dialog title="Edit User" :visible.sync="dialogFormVisible">
                <DialogUser :form="form" :status-clone="statusClone" @editUser="handleEditUser"></DialogUser>
            </el-dialog>
        </div>

    </div>
</template>
<script>
import DialogUser from "../../components/management/DialogUser";

export default {
    name: 'Users',
    components: {
        DialogUser,
    },
    data() {
        return {
            //Pagination
            page: this.$route.query.page ?? 1,
            totalPages: 0,
            perPage: 10,
            currentPage: 1,

            data: '',

            //tab
            activeName: this.$route.query.status ?? '3',
            currentTab: this.$route.query.status ?? '3',

            //dialog
            currentUser: {},
            form: {
                id: '',
                name: '',
                email: '',
                status: false
            },
            statusClone: false,
            formLabelWidth: '120px',
            dialogFormVisible: false,
        }
    },
    created() {
        this.getListUsers(this.page, this.currentTab)
    },
    methods: {
        handleClickTab(tab) {
            this.currentTab = tab.name
            this.$router.push({path: '/manage/users', query: {page: 1, status: this.currentTab}});
            this.getListUsers(1, this.currentTab)
        },
        handleEdit(row) {
            this.currentUser = row
            this.dialogFormVisible = true
            this.form.id = row.id
            this.form.name = row.name
            this.form.email = row.email
            this.form.status = row.status === 1
            this.statusClone = this.form.status
        },
        handleEditUser() {
            this.startLoading()
            let dataEdit = {
                status: this.form.status ? 1 : 0
            }
            axios.put(`/api/admin/users/${this.form.id}`, dataEdit).then(response => {
                this.stopLoading()
                this.currentUser.status = dataEdit.status
                this.dialogFormVisible = false
                this.$notify({
                    title: 'Success',
                    message: 'update successfully',
                    type: 'success'
                });
            }).catch(error => {
                this.stopLoading()
                this.dialogFormVisible = false
                this.handleErrorNotPermission(error)
            })
        },
        handleCurrentChange(val) {
            this.$router.push({path: '/manage/users', query: {page: val, status: this.currentTab}});
            this.getListUsers(val, this.currentTab)
        },
        getListUsers(page = 1, status = 3) {
            this.startLoading()
            axios.get(`/api/admin/users?page=${page}&status=${status}`).then((response) => {
                this.stopLoading()
                this.data = response.data.data.data
                this.totalPages = response.data.data.total
                this.perPage = response.data.data.per_page
                this.currentPage = response.data.data.current_page
            }).catch((errors) => {
                this.stopLoading()
                this.handleErrorNotPermission(errors)
            })
        },
    }
}
</script>
<style>

</style>
