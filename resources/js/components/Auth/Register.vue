<template>
    <div>
        <h2>ユーザー登録</h2>
        <form @submit.prevent="register">
            <div>
                <label><input v-model="name" placeholder="name"></label>
            </div>
            <div>
                <label><input v-model="email" placeholder="email"></label>
            </div>
            <div>
                <label><input v-model="password" placeholder="password"></label>
            </div>
            <div>
                <label><input v-model="password_confirm" placeholder="password"></label>
            </div>    
            <br>
            <button type="submit">登録</button>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name : "",
            email : "",
            password : "",
            password_confirm : "",

        };
    },
    methods: {
        register() {
            axios.get('/sanctum/csrf-cookie')
                .then((res) => {
                    axios.post('/api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirm: this.password_confirm,
                    })
                    .then((res) => {
                        console.log(res.status);
                        if( res.status == 200 ) {
                            this.$router.push("/login");
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