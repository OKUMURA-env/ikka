<template>
    <div v-if="show" @click.self="closeModal">
        <div class="container mt-3">
            <div class="row">
                <div class="col-12 col-sm-6 ml-0 mr-auto">
                    <div class="card mt-3">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div
                                        class="input-group input-group-seamless"
                                    >
                                        <input type="text" 
                                                v-model="keyword"
                                                placeholder="キーワード" />
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div
                                        class="input-group input-group-seamless"
                                    >
                                        <select
                                            class="form-control"
                                            v-model="selectedDriverId"
                                        >
                                            <option value="allDriver">
                                                すべてのドライバー
                                            </option>
                                            <option
                                                v-for="driver in drivers"
                                                v-bind:value="driver.id"
                                                v-bind:key="driver.id"
                                            >
                                                {{ driver.name }}
                                            </option>
                                        </select>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div
                                        class="input-group input-group-seamless"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            @click="resetForm"
                                        >
                                            リセット
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        {{ searched_events }}
                    </div>
                </div>
            </div>
        </div>
       
        <div class="container mt-3" v-for="event in searchedEvents" :key="event.id">
            <div class="row">
                <div class="col-12 col-sm-6 ml-0 mr-auto">
                    <div class="card">
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td v-text="event.id"></td>
                                    <td v-text="event.title"></td>
                                    <td v-text="event.driver_id"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ["show"],
    components: {},
    data() {
        return {
            all_events:[],
            searched_events:{},
            drivers: "",
            keyword: "",
            selectedDriverId: "allDriver",
        };
    },
    mounted() {
        this.getEvents();
        this.getDrivers();
    },

    methods: {
        getEvents() {
            axios
                .get("/api/search-event", {})
                .then((response) => {
                    // カレンダーに読み込み
                    this.all_events = response.data;
                })
                .catch(() => {
                    // バリデーションエラーなど
                    alert("登録に失敗しました");
                });
        },

        getDrivers() {
            axios
                .get("/api/drivers")
                .then((response) => {
                    this.drivers = response.data.drivers;
                })
                .catch((error) => {});
        },

        resetForm() {
            this.keyword = "";
            this.selectedDriverId = "allDriver";
        },
    },

    computed: {
        searchedEvents: function () {
            var searched_events = [];
            for (var i in this.all_events) {
                var event = this.all_events[i];
                if(!this.keyword && this.selectedDriverId == "allDriver"){
                    return searched_events;
                }else{
                    if(this.selectedDriverId == "allDriver" || this.selectedDriverId == event.driver_id){  
                        if(!this.keyword){
                                searched_events.push(event);
                            }
                        if(this.keyword && event.title?.includes(this.keyword)){
                            searched_events.push(event);
                        }
                    }
                }
            }
            return searched_events;
        },

    },
};
</script>
