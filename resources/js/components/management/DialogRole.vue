<template>
    <div>
        <el-form :model="form" :rules="rules" ref="ruleForm">
            <el-form-item label="Name" :label-width="formLabelWidth" prop="name">
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
    </div>
</template>
<script>
export default {
    name: 'Dialog-Role',
    props: {
        form: {
            type: Object,
            default() {
                return {
                    id: '',
                    name: '',
                    email: '',
                    status: false,
                }
            }
        },
        permissions: {
            type: Array,
            required: true,
        },
        users: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            formLabelWidth: '120px',
            rules: {
                name: [
                    {required: true, message: 'Please input name', trigger: 'blur'},
                ],
            }
        }
    },
    methods: {
        submit() {
            this.$refs['ruleForm'].validate((valid) => {
                if (valid) {
                    this.$emit('submit')
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        }
    }

}
</script>
<style scoped></style>
