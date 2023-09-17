<template>
     <div
        v-if="show"
        class="modal show display"
        v-cloak
        tabindex="-1"
        aria-labelledby="ShowEventModal"
        aria-hidden="true"
        role="dialog"
        style="display: block"
        @click.self="closeModal"
    >
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">詳細</h5>
                    {{ event }}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        @click="closeModal"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="modal-body">
                    <div class="p-2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <p>タイトル</p>
                                    <input
                                        type="text"
                                        class="form-control w-100 modal-title"
                                        v-model="event.title"
                                        placeholder="Add title ..."
                                        ref="eventTitle"
                                        autofocus
                                    />
                                </div>
                            </li>

                            <li class="list-group-item">
                                <schedule-category-select
                                    :schedule_categories="schedule_categories"
                                    @change="handleScheduleCategoryChange"
                                    :scheduleCategoryId="scheduleCategoryId"
                                />
                            </li>

                            <li class="list-group-item">
                                <driver-select
                                    :drivers="drivers"
                                    @change="handleDriverChange"
                                    :driverId="driverId"
                                />
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <input
                                        type="checkbox"
                                        id="all_day"
                                        v-model="event.all_day"
                                        checked="checked"
                                    />終日
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <p>開始</p>
                                    <input
                                        type="date"
                                        class="form-control w-100 modal-title"
                                        v-model="event.start_date"
                                        ref="eventStartDate"
                                        autofocus
                                    />
                                    <input
                                        v-if="!event.all_day"
                                        type="time"
                                        class="form-control w-100 modal-title"
                                        v-model="event.start_time"
                                        ref="eventStartTime"
                                        autofocus
                                    />
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <p>終了</p>    
                                    <input
                                        type="date"
                                        class="form-control w-100 modal-title"
                                        v-model="event.end_date"
                                        ref="eventEndDate"
                                        autofocus
                                    />
                                    <input
                                        v-if="!event.all_day"
                                        type="time"
                                        class="form-control w-100 modal-title"
                                        v-model="event.end_time"
                                        ref="eventEndTime"
                                        autofocus
                                    />
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="deleteEvent"
                        data-dismiss="modal"
                    >
                        削除
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="updateEvent"
                    >
                        更新
                    </button>
                </div>
            </div>
        </div>

        <div v-cloak></div>
    </div>
</template>

<script>
import { stringifyStyle } from "@vue/shared";
import axios from "axios";
import DriverSelect from "./Select/DriverSelect.vue";
import ScheduleCategorySelect from "./Select/ScheduleCategorySelect.vue";

export default {
    props: ["show", "currentEvent"],
    components: {
        ScheduleCategorySelect,
        DriverSelect,
    },
    data() {
        return {
            event: {},
            
        };
    },

    mounted() {
        this.getScheduleCategories();
        this.getDrivers();
    },

    methods: {
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
        closeModal() {
            this.$emit("close");  
        },
        updateEvent() {
            let all_day = this.event.all_day;

            //終日のときにtimeの値がundifinedになるのを防ぐため
            if(all_day){
                this.event.start_time = "";
                this.event.end_time = "";
            }

            let start = this.event.start_date + " " + this.event.start_time;
            let end = this.event.end_date + " " + this.event.end_time;

            if (start >= end) {
                alert("終了日は開始日より後に設定してください。");
                return;
            }

            //終日をチェックしてないとき、時間フォームを空のまま登録できないようにする。
            if(!all_day && this.event.start_time === undefined){
                alert("終日にチェックするか、時間を指定してください。");
                return;
            }

            if(!all_day && this.event.start_time === ""){
                alert("終日にチェックするか、時間を指定してください。");
                return;
            }
            
            if(!all_day && this.event.end_time === undefined){
                alert("終日にチェックするか、時間を指定してください。");
                return;
            }

            if(!all_day && this.event.end_time === ""){
                alert("終日にチェックするか、時間を指定してください。");
                return;
            }

            console.log(this.scheduleCategoryId);
            axios
                .put("/api/event/" + this.event.id, {
                    id: this.event.id,
                    title: this.event.title,
                    start: start,
                    end: end,
                    schedule_category_id: this.scheduleCategoryId,
                    driver_id: this.driverId,
                    all_day: this.event.all_day,
                })
                .then(({ data }) => {
                    this.closeModal();
                    this.$emit("event-updated");
                })
                .catch((error) => {
                    this.$emit("error");
                });
        },
        deleteEvent() {
            axios
                .delete("/api/event/" + this.event.id, this.event)
                .then(({ data }) => {
                    this.closeModal();
                    this.$emit("event-deleted");
                })
                .catch((error) => {
                    this.$emit("error");
                });
        },
        handleScheduleCategoryChange(event) {
            this.scheduleCategoryId = event.target.value;
        },
        handleDriverChange(event, display_name) {
            this.driverId = event.target.value;

        },
       
    },
      // 注意！
    // watchを使わないと、eventが編集できない。
    watch: {
        currentEvent(currentEvent) {
            console.log(currentEvent.all_day);
            if (currentEvent.all_day == 0) {
                console.log(currentEvent.start.slice(0, 10));
                let start_date = currentEvent.start.slice(0, 10);
                let start_time = currentEvent.start.slice(11, 16);
                let end_date = currentEvent.end.slice(0, 10);
                let end_time = currentEvent.end.slice(11, 16);
                var Event = {
                    id: currentEvent.id,
                    title: currentEvent.title,
                    start_date: start_date,
                    start_time: start_time,
                    end_date: end_date,
                    end_time: end_time,
                    driver_id: currentEvent.driver_id,
                    all_day: false,
                };
            }
            if (currentEvent.all_day == 1) {
                var Event = {
                    id: currentEvent.id,
                    title: currentEvent.title,
                    start_date: currentEvent.start,
                    end_date: currentEvent.end,
                    driver_id: currentEvent.driver_id,
                    all_day: true,
                };
            }   
        
            // ※ JSON.parse(JSON.stringify(currentEvent));
            // 検索結果のスケジュールからモーダルを起動させた場合、スケジュールに合わせて、
            // 検索結果上の予定も変更されてしまうため。
            this.event = JSON.parse(JSON.stringify(Event));
            this.scheduleCategoryId = currentEvent.schedule_category_id;
            this.driverId = currentEvent.driver_id;
        },
    },

 
};
</script>
