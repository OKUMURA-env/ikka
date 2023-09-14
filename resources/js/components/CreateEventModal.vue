<template>
   <div
        v-if="show"
        class="modal show display"
        v-cloak
        tabindex="-1"
        aria-labelledby="CreateEventModal"
        aria-hidden="true"
        role="dialog"
        style="display: block"
        @click.self="closeModal"
    >
    <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">新規登録</h5>
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
                                <driver-select
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
                        class="btn btn-secondary"
                        @click="closeModal"
                        data-dismiss="modal"
                    >
                        閉じる
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="saveEvent"
                    >
                        登録
                    </button>
                </div>

            </div>
        </div>
    <div v-cloak></div>
   
</div>
</template>

<script>
import DriverSelect from "./Select/DriverSelect.vue";

export default {
    props: ["show"],
    components: {
        DriverSelect,
    },
    data() {
        return {
            event: {
                title: null,
                start_date: "",
                start_time: "",
                end_date: "",
                end_time: "",
                all_day: true,
            },
        }
    },

    mounted() {
        
    },

    methods: {
        closeModal() {
            this.event.title = null;
            this.event.start_date = null;
            this.event.start_time = "";
            this.event.end_date = null;
            this.event.end_time = "";
            this.event.all_day = true;
           this.$emit("close");
        },
        saveEvent() {
            let all_day = this.event.all_day;
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

            axios
                .post("/api/event", {
                    title: this.event.title,
                    start: start,
                    end: end,
                    all_day: this.event.all_day,
                })
                .then(({ data }) => {
                    this.closeModal();
                    this.$emit("event-created");
                })
                .catch((error) => {
                    this.$emit("error");
                });
        },

    },

    

};
</script>