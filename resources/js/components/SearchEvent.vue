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
                                            v-model="selectedScheduleCategoryId"
                                        >
                                            <option value="allScheduleCategory">
                                                すべてのカテゴリー
                                            </option>
                                            <option
                                                v-for="schedule_category in schedule_categories"
                                                v-bind:value="
                                                    schedule_category.id
                                                "
                                                v-bind:key="
                                                    schedule_category.id
                                                "
                                            >
                                                {{ schedule_category.title }}
                                            </option>
                                        </select>
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
                    </div>
                </div>
            </div>
        </div>
       
        <div class="container mt-3" 
             v-for="event in searchedEvents" 
             :key="event.id"
             v-on:click="copyEventModalOpen(event.id)"
             >
            <div class="row">
                <div class="col-12 col-sm-6 ml-0 mr-auto">
                    <div class="card">
                        <div class="card-body">
                            <table>
                                <tr>
                                    <div>
                                        <td>id : {{ event.id }}</td>
                                    </div>
                                    <div>
                                        <td>タイトル : {{ event.title }}</td>
                                    </div>
                                    <div>
                                        <td>ドライバー : {{ event.driver_name }}</td>
                                    </div>
                                    <div>
                                        <td>カテゴリー : {{ event.schedule_category_title }}</td>
                                    </div>
                                   
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <copy-event-modal 
                :show="copy_event_modal_open"
                @close="copy_event_modal_open = false" 
                     />
    </div>
</template>

<script>
import CopyEventModal from "./CopyEventModal.vue";

export default {
    props: ["show"],
    components: {
        CopyEventModal,
    },
    data() {
        return {
            copy_event_modal_open: false,
            all_events:[],
            searched_events:{},
            schedule_categories: "",
            drivers: "",
            keyword: "",
            selectedScheduleCategoryId: "allScheduleCategory",
            selectedDriverId: "allDriver",
        };
    },
    mounted() {
        this.getEvents();
        this.getDrivers();
        this.getScheduleCategories();
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
        getScheduleCategories() {
            axios
                .get("/api/schedule-categories")
                .then((response) => {
                    this.schedule_categories =
                        response.data.data;
                })
                .catch((error) => {});
        },
        getDrivers() {
            axios
                .get("/api/drivers")
                .then((response) => {
                    this.drivers = response.data.data;
                })
                .catch((error) => {});
        },

        resetForm() {
            this.keyword = "";
            this.selectedScheduleCategoryId = "allScheduleCategory";
            this.selectedDriverId = "allDriver";
        },

        copyEventModalOpen(id) {
            console.log("ok");
            console.log(id);
            this.copy_event_modal_open = true;
        }
    },

    computed: {
        searchedEvents: function () {
            var searched_events = [];
            for (var i in this.all_events) {
                var event = this.all_events[i];
                if(!this.keyword && this.selectedDriverId == "allDriver" && this.selectedScheduleCategoryId == "allScheduleCategory"){
                    return searched_events;
                }else{
                    if(this.selectedScheduleCategoryId == "allScheduleCategory" || this.selectedScheduleCategoryId == event.schedule_category_id){
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
            }
            return searched_events;
        },

    },
};
</script>
