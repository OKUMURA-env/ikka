<template>
    <AdminLayout>
    <button @click = "searchForm">Search</button>
    <search-event
        :show="search_form"
    />
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Calendar</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky-top mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Schedule Category</h4>
                            </div>
                            <div class="card-body">
                                <!-- <div id="external-events">
                  <div class="external-event bg-success">Lunch</div>
                  <div class="external-event bg-warning">Go home</div>
                  <div class="external-event bg-info">Do homework</div>
                  <div class="external-event bg-primary">Work on UI design</div>
                  <div class="external-event bg-danger">Sleep tight</div>
                  <div class="checkbox">
                    <label for="drop-remove">
                      <input type="checkbox" id="drop-remove" />
                      remove after drop
                    </label>
                  </div>
                </div> -->
                <schedule-categories/>
                            </div>
                        </div>

                        
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-body p-0">
                            <FullCalendar :options="calendarOptions" ref="fullcalendar" />
                        </div>
                    </div>
                    <create-event-modal 
                        :show="new_event_modal_open" 
                        :scheduleCategoryId="scheduleCategoryId"
                        @close="resetNewEventData"
                        @event-created="newEventCreated" />
                    <show-event-modal :show="show_event_details_modal" :currentEvent="currentEvent"
                        @close="show_event_details_modal = false" @event-updated="rerenderCalendar"
                        @event-deleted="rerenderCalendar" />
                </div>
            </div>
        </div>
    </section>
    </AdminLayout>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from "@fullcalendar/list";
import AdminLayout from "./Layouts/AdminLayout.vue"
import ScheduleCategories from "./ScheduleCategories/List.vue";
import CreateEventModal from "./CreateEventModal.vue";
import ShowEventModal from "./ShowEventModal.vue";
import SearchEvent from "./SearchEvent.vue";

export default {
    components: {
        AdminLayout,
        FullCalendar, // make the <FullCalendar> tag available
        CreateEventModal,
        ShowEventModal,
        ScheduleCategories,
        SearchEvent,
    },
    data() {
        return {
            new_event_modal_open: false,
            show_event_details_modal: false,
            search_form: false,
            calendarOptions: {
                plugins: [
                    dayGridPlugin,
                    timeGridPlugin,
                    interactionPlugin,
                    listPlugin,
                ],
                initialView: 'dayGridMonth',
                locale: "ja",
                firstDay: 1,
                headerToolbar: {
                    left: "prev,next,today",
                    center: "title",
                    right: "dayGridMonth,timeGridTwoWeek,timeGridDay,listMonth",
                },
                buttonText: {
                    today: '今月',
                    month: "月",
                    week: "週",
                    day: "日",
                    list: "予定リスト",
                },
                views: {
                    timeGridTwoWeek: {
                        type: "dayGridWeek",
                        duration: {
                            weeks: 2,
                        },
                        buttonText: "2週間",
                    },
                },
                weekends: true,
                dateClick: this.handleDateClick,
                eventClick: this.handleEventClick,
                editable: true,
                eventDrop: this.handleEventDrop,
                eventResize: this.eventResize,
                events: function (info, successCallback) {
                    axios
                        .post("api/event/event-get", {
                            start: info.startStr.valueOf(),
                            end: info.endStr.valueOf(),
                        })
                        .then((response) => {
                            // カレンダーに読み込み
                            console.log(response);
                            successCallback(response.data);
                        })
                        .catch(() => {
                            // バリデーションエラーなど
                            alert("登録に失敗しました");
                        });
                },

            }
        }
    },
    methods: {
        handleDateClick() {
            this.new_event_modal_open = true;
        },
        resetNewEventData() {
            this.new_event_modal_open = false;
        },
        newEventCreated() {
            this.rerenderCalendar();
            new Noty({
                text: `Appointment has been created.`,
                timeout: 1000,
                type: "success",
            }).show();
        },
        handleEventClick(e) {
            const event = this.createEventObject(e);
            console.log(event);
            axios
                .get("/api/event/" + event.id, event)
                .then((response) => {
                    this.currentEvent = response.data;
                    this.show_event_details_modal = true;
                })
                .catch((response) => {
                    alert("Schedule click has been failed!");
                });
        },
        createEventObject(e) {
            const event = {};
            // 注意！
            // カラムが増えると編集
            event.id = e.event.id;
            event.title = e.event.title;
            event.start = e.event.startStr;
            event.end = e.event.endStr;
            return event;
        },
        handleEventDrop(e) {
            axios
                .put("/api/event/" + e.event.id, {
                    id: e.event.id,
                    title: e.event.title,
                    start: e.event.startStr,
                    end: e.event.endStr,
                    all_day: e.event.allDay,
                })
                .then(({ data }) => {
                    this.rerenderCalendar();
                })
                .catch((error) => {
                    this.$emit("error");
                });
        },

        //イベントの期間を変更
        eventResize(e) {
            axios
                .put("/api/event/" + e.event.id, {
                    id: e.event.id,
                    title: e.event.title,
                    start: e.event.startStr,
                    end: e.event.endStr,
                    all_day: e.event.allDay,
                })
                .then(({ data }) => {
                    this.rerenderCalendar();
                })
                .catch((error) => {
                    this.$emit("error");
                });
        },
        rerenderCalendar() {
            this.$refs.fullcalendar.getApi().refetchEvents();

        },
        searchForm() {
            if(this.search_form){
                this.search_form = false;
            }
            else{
                this.search_form = true;
            }
            
        }
    },
}
</script>