<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div>
                <label><input v-model="email" placeholder="email"></label>
            </div>
            <div>
                <label><input v-model="password" placeholder="password"></label>
            </div>  
            <br>
            <button type="submit">Login</button>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            email : "",
            password : "",

        };
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie')
                .then((res) => {
                    axios.post('/api/login', {
                        email: this.email,
                        password: this.password,
                    })
                    .then((res) => {
                        console.log(res.data.token);
                        if( res.status == 200 ) {
                            console.log(res.data.token);
                            localStorage.setItem('token', res.data.token);
                            this.$router.push("/calendar");
                            console.log(res.data.token);
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    })
                })
                .catch((err) => {
                //
                })
        }
    }
};
</script>