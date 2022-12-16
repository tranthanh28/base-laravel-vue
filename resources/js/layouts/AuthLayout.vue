<template>
        <div class="bg-light d-flex flex-column page-container">
            <div>
                <NavbarAuth></NavbarAuth>
                <div class="d-flex swap">
<!--                    class="d-flex flex-column position-relative"-->
                    <LeftMenu />
                    <main style="flex-grow: 2;">
                        <router-view></router-view>
                    </main>
                </div>
            </div>
        </div>
</template>
<script>
import NavbarAuth from "../components/AuthHeader";
import LeftMenu from "../components/LeftMenu";

export default {
    name: 'app',
    components: {
        NavbarAuth,
        LeftMenu,
    }
}
</script>
<style scoped>
.swap {
    margin-top: 70px;
}
</style>
