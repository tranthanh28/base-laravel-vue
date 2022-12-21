<template>
    <div>
        <el-form :model="form">
            <el-form-item label="Name" :label-width="formLabelWidth">
                <el-input v-model="form.name" autocomplete="off" disabled></el-input>
            </el-form-item>
            <el-form-item label="Email" :label-width="formLabelWidth">
                <el-input v-model="form.email" autocomplete="off" disabled></el-input>
            </el-form-item>
            <el-form-item label="Active" :label-width="formLabelWidth">
                <el-switch v-model="form.status"></el-switch>
            </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer d-flex justify-content-center">
                <el-button type="primary" @click="handleEditUser()"
                           :disabled="statusClone===form.status">Submit</el-button>
            </span>
    </div>
</template>
<script>
export default {
    name: 'Dialog-User',
    props: {
        form: {
            type: Object,
            default() {
                return {
                    id: '',
                    name: '',
                    email: '',
                    status: false
                }
            }
        },
        statusClone: {
            type: Boolean,
            required: true,
        }
    },
    data() {
        return {
            formLabelWidth: '120px'
        }
    },
    methods: {
        handleEditUser() {
            this.$emit('editUser')
        }
    }

}
</script>
<style scoped></style>
