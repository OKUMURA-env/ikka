<template>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">エクスポート</div>
            <div class="panel-body">

                <div class="input-group input-group-seamless">
                    <label for="schedule_category">期間</label>
                    <VueDatePicker 
                                v-model="date"
                                range
                                multi-calendars>
                    </VueDatePicker>
                </div>

                <div class="input-group input-group-seamless">
                    <label for="schedule_category">カテゴリー</label>
                    <select
                        class="form-control"
                        v-model="selectedScheduleCategoryId"
                    >
                        <option value="allScheduleCategory">
                            すべてのカテゴリー
                        </option>
                        <option
                            v-for="schedule_category in schedule_categories"
                            v-bind:value="schedule_category.id"
                            v-bind:key="schedule_category.id"
                        >
                            {{ schedule_category.title }}
                        </option>
                    </select>
                </div>

                <div class="input-group input-group-seamless">
                    <label for="driver">ドライバー</label>
                    <select class="form-control" v-model="selectedDriverId">
                        <option value="allDriver">すべてのドライバー</option>
                        <option
                            v-for="driver in drivers"
                            v-bind:value="driver.id"
                            v-bind:key="driver.id"
                        >
                            {{ driver.name }}
                        </option>
                    </select>
                </div>

                <div class="input-group input-group-seamless">
                    <input
                        type="checkbox"
                        :checked="isAllSelected"
                        @click="selectAll"
                        ref="allSelect"
                    />全選択
                </div>
                <div class="input-group input-group-seamless">
                    <input
                        type="checkbox"
                        id="all_day"
                        ref="eventTitle"
                        v-model="event.title"
                    />タイトル
                </div>
                <div class="input-group input-group-seamless">
                    <input
                        type="checkbox"
                        v-model="event.schedule_category_id"
                    />カテゴリー
                </div>
                <div class="input-group input-group-seamless">
                    <input
                        type="checkbox"
                        v-model="event.driver_id"
                    />ドライバー
                </div>
                <div class="input-group input-group-seamless">
                    <input type="checkbox" v-model="event.all_day" />終日
                </div>
                <div class="input-group input-group-seamless">
                    <input type="checkbox" v-model="event.start" />開始日
                </div>
                <div class="input-group input-group-seamless">
                    <input type="checkbox" v-model="event.end" />終了日
                </div>
                <div class="input-group input-group-seamless">
                    <input type="checkbox" v-model="event.item" />品目
                </div>
                <div class="input-group input-group-seamless">
                    <input
                        type="checkbox"
                        v-model="event.pickup_location"
                    />積み込み先
                </div>
                <div class="input-group input-group-seamless">
                    <input
                        type="checkbox"
                        v-model="event.dropoff_location"
                    />荷下ろし先
                </div>
                <div class="input-group input-group-seamless">
                    <input type="checkbox" v-model="event.file_path" />添付先
                </div>
                <div class="input-group input-group-seamless">
                    <input type="checkbox" v-model="event.description" />詳細
                </div>
                <button class="btn btn-success" @click="eventExport">
                    エクスポート
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { config } from "@fullcalendar/core/internal";

export default {
    components: {
      
    },
    data() {
        return {
            event: {
                title: false,
                schedule_category_id: false,
                driver_id: false,
                start: false,
                end: false,
                all_day: false,
                item: false,
                pickup_location: false,
                dropoff_location: false,
                file_path: false,
                description: false,
            },
            selectedDriverId: "allDriver",
            selectedScheduleCategoryId:"allScheduleCategory",
            drivers: "",
            schedule_categories: "",
            isAllSelected: false,
            select_date_modal_open: false,
            date:"",
        };
    },
    mounted() {
        this.getDrivers();
        this.getScheduleCategories();
    },
    methods: {
        getScheduleCategories() {
            //
        },

        getDrivers() {
            //
        },
        selectAll() {
            //
           
        },
        eventExport() {
            //
        },
        formReset(){
           //

        }
    },
};
</script>
