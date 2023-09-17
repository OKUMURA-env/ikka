<template>
    <div>
        <p>
            <strong>Schedule Categories</strong>
        </p>
        <button v-on:click="createScheduleCategory()">
            作成
        </button>
        
        <div ref="ScheduleCategories" class="col-2">
            <div
                v-for="schedule_category in schedule_categories"
                :data-schedule-category-id = "schedule_category.id"
                class="external-event ui-draggable ui-draggable-handle"      
            >
                <div class="schedule-category-main">
                    {{ schedule_category.title }}
                </div>
            </div>
        </div>

    </div>

    <create-schedule-categories
        :show="create_schedule_category_modal"
        @close="create_schedule_category_modal = false"
        @rerender-schedule-categories="getScheduleCategories"
        
    />

</template>

<script>
import { stringifyStyle } from "@vue/shared";
import { Draggable } from "@fullcalendar/interaction";
import axios from "axios";
import CreateScheduleCategories from "./CreateModal.vue";

export default {
    components: {
        CreateScheduleCategories,
    },
    data() {
        return {
            event: {},      
            schedule_categories: {},  
            create_schedule_category_modal: false, 
        };
    },

    mounted() {
        this.dragObjectCreate();
        this.getScheduleCategories();
    },
    methods: {
        // 指定したクラスの要素をドラッグアンドドロップできるようにする。
        dragObjectCreate() {
            var  draggableEl = this.$refs.ScheduleCategories;
                new Draggable(draggableEl, {
                    itemSelector: ".external-event",
                    eventData: function (eventEl) {
                        return {
                            id:eventEl.dataset.scheduleCategoryId,
                            title: eventEl.innerText,
                            backgroundColor:eventEl.style.backgroundColor
                        };
                    },
                });
        },

        getScheduleCategories() {
            axios
                .get("/api/schedule-categories")
                .then((response) => {
                    this.schedule_categories = response.data.data;
                    this.$emit("schedule-category-changed");
                })
                .catch((error) => {
            
                });
            
        },

        createScheduleCategory() {
            this.create_schedule_category_modal = true;
            
        },
      
        
    },
};

</script>

