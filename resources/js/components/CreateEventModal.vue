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
                        class="btn-close btn btn-light"
                        data-bs-dismiss="modal"
                        @click="closeModal"
                        aria-label="Close"
                    >×</button>
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
                                    <p class=error>{{ titleError }}</p>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <schedule-category-select
                                    :schedule_categories="schedule_categories"
                                    @change="handleScheduleCategoryChange"
                                    :scheduleCategoryId="scheduleCategoryId"
                                />
                                <p class=error>{{ scheduleCategoryError }}</p>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <input
                                        type="checkbox"
                                        v-model="event.display_driver_name"
                                        checked="checked"
                                    />ドライバー名をタイトルに表示
                                </div>
                            </li>

                            <li class="list-group-item">
                                <driver-select
                                    :drivers="drivers"
                                    @change="handleDriverChange"
                                />
                                <p class=error>{{ driverError }}</p>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <input
                                        type="checkbox"
                                        id="all_day"
                                        v-model="event.all_day"
                                        checked="checked"
                                    />終日
                                    <p class=error>{{ dateTimeError }}</p>
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
                                    <p class=error>{{ dateError }}</p>
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

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <p>品目</p>
                                    <input
                                        type="text"
                                        class="form-control w-100 modal-title"
                                        v-model="event.item"
                                        placeholder="Add item ..."
                                        ref="eventItem"
                                        autofocus
                                    />
                                    <p class=error>{{ itemError }}</p>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <p>積み込み先</p>
                                    <input
                                        type="text"
                                        class="form-control w-100 modal-title"
                                        v-model="event.pickup_location"
                                        placeholder="Add pickup location ..."
                                        ref="eventPickupLocation"
                                        autofocus
                                    />
                                    <p class=error>{{ pickupLocationError }}</p>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <p>荷下ろし先</p>
                                    <input
                                        type="text"
                                        class="form-control w-100 modal-title"
                                        v-model="event.dropoff_location"
                                        placeholder="Add dropoff location ..."
                                        ref="eventDropoffLocation"
                                        autofocus
                                    />
                                    <p class=error>{{ dropoffLocationError }}</p>
                                </div>
                            </li>

                            <li class="list-group-item" v-if="selected_file">
                                <div class="input-group input-group-seamless">
                                    <p>{{ selected_file.name }}</p>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        @click="removeSelectedFile"
                                        aria-label="Close"
                                    >×</button>
                                </div>
                            </li>

                            <li class="list-group-item" v-else>
                                <div class="input-group input-group-seamless">
                                    <p>添付ファイルを選択</p>
                                    <input
                                        @change="selectedFileForUpload"
                                        type="file"
                                        name="file"
                                    />
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <p>詳細</p>
                                    <textarea
                                        type="text"
                                        class="form-control w-100 modal-title"
                                        v-model="event.description"
                                        placeholder="Add Description ..."
                                        ref="eventDescription"
                                        autofocus
                                    ></textarea>
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
                        @click="saveEventWithFile"
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
import ScheduleCategorySelect from "./Select/ScheduleCategorySelect.vue";
import DriverSelect from "./Select/DriverSelect.vue";

export default {
    props: ["show",
            "start",
            "end",
            "schedule_categories",
            "scheduleCategoryId"],
    components: {
        ScheduleCategorySelect,
        DriverSelect,
    },
    data() {
        return {
            event: {
                title: null,
                schedule_category_id: "nobody",
                display_driver_name: true,
                driver_id: "nobody",
                start_date: "",
                start_time: "",
                end_date: "",
                end_time: "",
                all_day: true,
                item: "",
                pickup_location: "",
                dropoff_location: "",
                file_path: "",
                description: "",
            },
            schedule_categories: [],
            selected_file: "",
            file_path: "",
            titleError: "",
            scheduleCategoryError: "",
            driverError: "",
            itemError: "",
            pickupLocationError: "",
            dropoffLocationError: "",
            dateError: "",
            dateTimeError: "",
        }
    },

    mounted() {
        this.getDrivers();
        this.getScheduleCategories();
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
                    console.log(response.data.data);
                    this.drivers = response.data.data;
                })
                .catch((error) => {});
        },
        closeModal() {
            this.event.title = null;
            this.event.start_date = null;
            this.event.start_time = "";
            this.event.end_date = null;
            this.event.end_time = "";
            this.event.all_day = true;
            this.event.schedule_category_id = "nobody";
            this.event.display_driver_name = true;
            this.event.driver_id = "nobody";
            this.event.item = "";
            this.event.pickup_location = "";
            this.event.dropoff_location = "";
            this.event.file_path = "";
            this.event.description = "";
            this.titleError = "";
            this.categoryError = "";
            this.driverError = "";
            this.itemError = "";
            this.pickupLocationError = "";
            this.dropoffLocationError = "";
            this.scheduleCategoryError = "",
            this.driverError = "",
            this.dateError = "",
            this.dateTimeError = "",
           this.$emit("close");
        },

        selectedFileForUpload(e) {
            // 選択された File の情報を保存しておく
            let files = e.target.files;
            this.selected_file = files[0];
            console.log(this.selected_file.name);
        },

        removeSelectedFile() {
            this.selected_file = "" 
        },

        async uploadSelectdFile(){
            let formData = new FormData();
            formData.append("file", this.selected_file);

            await axios
                .post("/api/upload-file", formData)
                .then((response) => {
                    console.log(response.data);
                    this.event.file_path = response.data;
                })
                .catch((error) => {
                    console.log("error");
                });
        },

        saveEvent() {
            let all_day = this.event.all_day;
            let start = this.event.start_date + " " + this.event.start_time;
            let end = this.event.end_date + " " + this.event.end_time;

            if (start >= end) {
                this.dateError = "終了日は開始日より後に設定してください。";
            }

            //終日をチェックしてないとき、時間フォームを空のまま登録できないようにする。
            if(!all_day && this.event.start_time === undefined){
                this.dateTimeError = "終日にチェックするか、時間を指定してください。";
            }

            if(!all_day && this.event.start_time === ""){
                this.dateTimeError= "終日にチェックするか、時間を指定してください。";
            }
            
            if(!all_day && this.event.end_time === undefined){
                this.dateTimeError= "終日にチェックするか、時間を指定してください。";
            }

            if(!all_day && this.event.end_time === ""){
                this.dateTimeError= "終日にチェックするか、時間を指定してください。";
            }

            axios
                .post("/api/event", {
                    title: this.event.title,
                    start: start,
                    end: end,
                    schedule_category_id: this.event.schedule_category_id,
                    display_driver_name: this.event.display_driver_name,
                    driver_id: this.event.driver_id,
                    all_day: this.event.all_day,
                    item: this.event.item,
                    pickup_location: this.event.pickup_location,
                    dropoff_location: this.event.dropoff_location,
                    file_path: this.event.file_path,
                    description: this.event.description,
                })
                .then(({ data }) => {
                    this.closeModal();
                    this.$emit("event-created");
                })
                .catch((error) => {
                    console.log(error);
                   
                    if(error.response.data.errors.title){
                        this.titleError = error.response.data.errors.title[0];
                    }
                    if(error.response.data.errors.driver_id){
                        this.driverError = error.response.data.errors.driver_id[0];
                    }
                    if(error.response.data.errors.schedule_category_id){
                        this.scheduleCategoryError = error.response.data.errors.schedule_category_id[0];
                    }
                    if(error.response.data.errors.item){
                        this.itemError = error.response.data.errors.item[0];
                    }
                    if( error.response.data.errors.pickup_location){
                        this.pickupLocationError = error.response.data.errors.pickup_location[0];
                    }
                    if( error.response.data.errors.dropoff_location){
                        this.dropoffLocationError = error.response.data.errors.dropoff_location[0];
                    }             
                    this.$emit("error");
                });
        },

        async saveEventWithFile() {
            //file_pathを取得した後にsaveEventを発動させる
            await this.uploadSelectdFile();
            this.saveEvent();
        },

        handleScheduleCategoryChange(event) {
            this.event.schedule_category_id = event.target.value;
        },

        handleDriverChange(event, display_name) {
            this.event.driver_id = event.target.value;

             //「ドライバー名をタイトルに表示」にチェックが付いてたらタイトルに表示名を表示
            //注意：display_nameの条件がないと冒頭にundefindがついてしまう。
            if (this.event.display_driver_name && display_name) {
                this.event.title = this.event.title
                    ? display_name + this.event.title
                    : display_name;
            }
        },

    },

    watch: {
        start(start) {
            this.event.start_date = start;
        },
        end(end) {
            this.event.end_date = end;
        },
        scheduleCategoryId(scheduleCategoryId) {
            this.event.schedule_category_id = scheduleCategoryId;
        },
    },
};
</script>

<style>
.error {
    color:red;
}

</style>