<template>
   <AdminLayout>
    <h3>ドライバー一覧</h3>
    <router-link v-bind:to="{ name: 'driver.create'}">
        <div class="text-right">
            <button type="button" class="btn btn-secondary">登録</button>
        </div>
    </router-link>
    <table class="table caption-top">
        <thead>
            <tr>
                <th scope="col">名前</th>
                <th scope="col">メールアドレス</th>
                <th scope="col">スケジュール表示名</th>
                <th scope="col">その他</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="driver in drivers">
                    <td>{{ driver.name }}</td>
                    <td>{{ driver.email }}</td>
                    <td>{{ driver.display_name }}</td>
                    <td>{{ driver.other }}</td>
                    <td>
                        <router-link
                            v-bind:to="{
                                name: 'driver.edit',
                                params: { driverId: driver.id },
                            }"
                        >
                            <button class="btn btn-success">編集</button>
                        </router-link>
                    </td>
                    <td>
                        <button  v-on:click="deleteDriver(driver.id)" class="btn btn-danger">
                            削除
                        </button>
                    </td>
                   
                </tr>
        </tbody>
    </table>

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
            drivers: {},
        };
    },
    mounted() {
        this.getDrivers();
    },
    methods: {
        getDrivers() {
            axios
                .get("/api/drivers")
                .then((response) => {
                    console.log(response);
                    this.drivers = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deleteDriver(id) {
            axios
                .delete("/api/drivers/" + id, this.driver)
                .then((response) => {
                    this.getDrivers();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
}

</script>
  