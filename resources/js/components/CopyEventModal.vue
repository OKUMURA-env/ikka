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
                   <h5 class="modal-title">複製</h5>
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
                        class="btn btn-secondary"
                        @click="closeModal"
                        data-dismiss="modal"
                   >
                       閉じる
                   </button>
                   <button
                       type="button"
                       class="btn btn-warning"
                   >
                       複製
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
      //
   },


};
</script>
