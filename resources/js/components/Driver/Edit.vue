<template>
   <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">ドライバー編集</div>
            <div class="panel-body">
                <form @submit.prevent="updateDriver">
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

                    <button type="submit" class="btn btn-default">更新</button>
                </form>
            </div>
        </div>
    </div>
</template>  
<script>
export default {
    props: ["driverId"],
    data() {
        return {
            driver: {},
        };

    },
    mounted() {
        this.getSelectedDriver();
    },
    methods: {
        getSelectedDriver(){
            axios
                .get("/api/drivers/" + this.driverId, this.driverId)
                .then((response) => {
                    this.driver = response.data;
                    console.log(this.driver)
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        updateDriver() {
            axios
                .put("/api/drivers/" + this.driverId, {
                    id: this.driverId,
                    name: this.driver.name,
                    email:this.driver.email,
                    display_name: this.driver.display_name,
                    other: this.driver.other,
                })
                .then((res) => {
                    console.log(res);
                    this.$router.push({ name: "driver.list" });
                })
                .catch((error) => {
                    console.log(error);
                });
        },

    },
}

</script>
  