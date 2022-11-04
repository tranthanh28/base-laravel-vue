<template>
        <div class="bg-light d-flex flex-column page-container">
            <div class="d-flex align-items-stretch flex-fill">
                <LeftMenu />
                <div class="w-100 d-flex flex-column position-relative">
                    <NavbarAuth></NavbarAuth>
                    <main>
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
