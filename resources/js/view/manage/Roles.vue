<template>
    <div class="swap-content">
        <div class="col-xs-12">
            <div class="page-title-box d-flex justify-content-between">
                <h4 class="page-title">Roles Management</h4>
                <el-breadcrumb>
                    <el-breadcrumb-item :to="{ path: '/dashboard' }">Dashboard</el-breadcrumb-item>
                    <el-breadcrumb-item>Roles Management</el-breadcrumb-item>
                </el-breadcrumb>
            </div>
        </div>

        <div v-if="data">
            <div>
                <div class="d-flex justify-content-end">
                    <el-button type="primary" @click="handleCreate">Create Role</el-button>
                </div>
                <div>
                    <el-table
                        :data="data"
                        highlight-current-row
                        style="width: 100%">
                        <el-table-column
                            type="index"
                            width="50">
                        </el-table-column>
                        <el-table-column
                            prop="name"
                            label="Name"
                            width="100"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="permissions"
                            label="Permissions"
                        >
                            <template slot-scope="scope">
                                <div class="tag-group">
                                    <el-tag
                                        v-for="item in scope.row.permissions"
                                        type="success"
                                        :key="item.id">
                                        {{ item.name }}
                                    </el-tag>
                                </div>
                                <!--                                {{ handleData(scope.row.permissions) }}-->
                            </template>
                        </el-table-column>
                        <el-table-column
                            label="Users">
                            <template slot-scope="scope">
                                <div class="tag-group">
                                    <el-tag
                                        v-for="user in scope.row.users"
                                        :key="user.id">
                                        {{ user.name }}
                                    </el-tag>
                                </div>

                                <!--                                {{ handleData(scope.row.users) }}-->
                            </template>
                        </el-table-column>
                        <el-table-column width="180">
                            <template slot-scope="scope">
                                <el-button
                                    size="mini"
                                    type="success"
                                    @click="handleEdit(scope.row)">Edit
                                </el-button>
                                <el-button
                                    size="mini"
                                    type="danger"
                                    @click="confirmDelete(scope.row)">Delete
                                </el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>

            <el-dialog :title="titleDialog" :visible.sync="dialogFormVisible">
                <el-form :model="form">
                    <el-form-item label="Name" :label-width="formLabelWidth">
                        <el-input v-model="form.name" autocomplete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Permissions" :label-width="formLabelWidth">
                        <el-select v-model="form.permissions" multiple placeholder="Select" style="width: 100%;">
                            <el-option
                                v-for="item in permissions"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="Users" :label-width="formLabelWidth">
                        <el-select v-model="form.users" multiple placeholder="Select" style="width: 100%">
                            <el-option
                                v-for="item in users"
                                :key="item.id"
                                :label="item.email"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-form>
                <span slot="footer" class="dialog-footer d-flex justify-content-center">
                <el-button type="primary" @click="submit()">Submit</el-button>
            </span>
            </el-dialog>

        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
            value1: [],
            data: '',
            permissions: [],
            users: [],

            //dialog
            titleDialog: '',
            currentRole: {},
            form: {
                id: '',
                name: '',
                permissions: [],
                users: [],
            },
            statusClone: false,
            formLabelWidth: '120px',
            dialogFormVisible: false,
        }
    },
    created() {
        this.getListRoles()
    },
    methods: {
        handleCreate() {
            this.titleDialog = 'Create Role'
            this.currentRole = {}
            this.dialogFormVisible = true
            this.form.id = null
            this.form.name = ''
            this.form.permissions = []
            this.form.users = []
        },
        handleData(data) {
            return data.reduce((str, item) => {
                return str + item.name + ", "
            }, '')
        },
        handleEdit(row) {
            this.titleDialog = 'Edit Role'
            this.currentRole = row
            this.dialogFormVisible = true
            this.form.id = row.id
            this.form.name = row.name
            this.form.permissions = row.permissions.map(item => item.id)
            this.form.users = row.users.map(item => item.id)
        },
        submit() {
            let data = {
                name: this.form.name,
                permissions: this.form.permissions,
                users: this.form.users
            }
            this.startLoading()
            if (this.form.id) {
                this.updateRole(data)
            } else {
                this.createRole(data)
            }
        },
        updateRole(dataEdit) {
            axios.put(`/api/admin/roles/${this.form.id}`, dataEdit).then(response => {
                this.stopLoading()
                this.currentRole.name = dataEdit.name
                this.currentRole.permissions = this.permissions.filter(item => {
                    return dataEdit.permissions.includes(item.id)
                })
                this.currentRole.users = this.users.filter(item => {
                    return dataEdit.users.includes(item.id)
                })
                this.$notify({
                    title: 'Success',
                    message: 'update role successfully',
                    type: 'success'
                });
                this.dialogFormVisible = false
            }).catch(error => {
                this.stopLoading()
                this.dialogFormVisible = false
                this.handleErrorNotPermission(error)
            })
        },
        createRole(data) {
            axios.post(`/api/admin/roles`, data).then(response => {
                this.stopLoading()
                this.getListRoles()
                this.$notify({
                    title: 'Success',
                    message: 'create role successfully',
                    type: 'success'
                });
                this.dialogFormVisible = false
            }).catch(error => {
                this.stopLoading()
                this.dialogFormVisible = false
                this.handleErrorNotPermission(error)
            })
        },
        confirmDelete(row) {
            this.$confirm('Are you sure you want to delete this item?', 'Confirm', {
                distinguishCancelAndClose: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            })
                .then(() => {
                    this.handleDelete(row)
                })
                .catch(action => {
                });
        },
        handleDelete(row) {
            this.startLoading()
            axios.delete(`/api/admin/roles/${row.id}`).then(response => {
                this.stopLoading()
                this.getListRoles()
                this.$notify({
                    title: 'Success',
                    message: 'delete role successfully',
                    type: 'success'
                });
            }).catch(error => {
                this.stopLoading()
                this.handleErrorNotPermission(error)
            })
        },
        getListRoles() {
            this.startLoading()
            axios.get(`/api/admin/roles`).then(response => {
                this.stopLoading()
                this.data = response.data.data.roles
                this.permissions = response.data.data.permissions
                this.users = response.data.data.users

                console.log(response)
            }).catch(error => {
                this.stopLoading()
                this.handleErrorNotPermission(error)
            })
        }
    }
}
</script>
<style scoped>
.tag-group > span {
    margin-left: 3px;
}

</style>
