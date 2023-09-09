<template>
    <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>株式会社一荷</h5>
        <a class="d-block" href="javascript:{}" @click = "logout">Logout</a>
        <form id="logout-form" action="#" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</aside>
</template>  
<script>
export default {
    data() {
     
    },
    mounted() {
        
    },
    methods: {
        async logout() {
            console.log("ok");
            try {
                await axios.post("/api/logout");
                localStorage.removeItem("authToken");
                this.$router.push({ name: "login" });
            } catch (error) {
                console.error("Error during logout:", error);
            }
        },
        
    },
}

</script>
  