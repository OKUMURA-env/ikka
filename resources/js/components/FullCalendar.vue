<template>
     <div class="card card-primary">
            <div class="card-body p-0">
              <FullCalendar :options="calendarOptions" ref="fullcalendar"  />
            </div>
          </div>
    <create-event-modal
        :show="new_event_modal_open"
        @close="resetNewEventData"  
        @event-created="newEventCreated"
    />
    <show-event-modal
         :show="show_event_details_modal"
         :currentEvent="currentEvent"
         @close="show_event_details_modal = false" 
         @event-updated="rerenderCalendar"
           />
</template>

<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from "@fullcalendar/list";
import CreateEventModal from "./CreateEventModal.vue";
import ShowEventModal from "./ShowEventModal.vue";

export default {
    components: {
        FullCalendar, // make the <FullCalendar> tag available
        CreateEventModal,
        ShowEventModal,
    },
    data() {
        return {
            new_event_modal_open: false,
            show_event_details_modal: false,
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
        rerenderCalendar() {
            this.$refs.fullcalendar.getApi().refetchEvents();
            
        },
    },
}
</script>