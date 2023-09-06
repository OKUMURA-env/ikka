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
        rerenderCalendar() {
            console.log('ok')
            this.$refs.fullcalendar.getApi().refetchEvents();
            
        },
    },
}
</script>