<template>
    <div>
        <div class="w-100 d-flex flex-column position-relative bg-white">
            <Navbar></Navbar>
            <main>
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>
<script>
import Navbar from "../components/Navbar";

export default {
    name: 'app',
    components: {
        Navbar,
    }
}
</script>
