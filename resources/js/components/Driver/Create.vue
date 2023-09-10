<template>
   <AdminLayout>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">ドライバー登録</div>
            <div class="panel-body">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <label class="control-label">名前</label>
                        <input class="form-control" 
                               type="text"
                               v-model="driver.name" 
                        />
                    </div>

                    <div class="form-group">
                        <label class="control-label">メールアドレス</label>
                        <input class="form-control" 
                               type="text"
                               v-model="driver.email" 
                        />
                    </div>

                    <div class="form-group">
                        <label class="control-label">スケジュール表示名</label>
                        <input class="form-control" 
                               type="text"
                               v-model="driver.display_name"
                         />
                    </div>

                    <div class="form-group">
                        <label class="control-label">その他</label>
                        <textarea
                            class="form-control"
                            cols="30"
                            rows="10"
                            v-model="driver.other"
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-default">登録</button>
                </form>
            </div>
        </div>
    </div>

   </AdminLayout>
</template>  
<script>
import AdminLayout from "../Layouts/AdminLayout.vue"

export default {
    components: {
        AdminLayout,
    },
    data() {
        return {
            driver: {
                name: null,
                email: null,
                display_name: null,
                other: null,
            },
        };

    },
    mounted() {

    },
    methods: {
        submit() {
            axios
                .post("/api/drivers", this.driver)
                .then((res) => {
                    this.$router.push({ name: "driver.list" });
                })
                .catch((error) => {
                    console.log(error);
                });
        },

    },
}

</script>
  