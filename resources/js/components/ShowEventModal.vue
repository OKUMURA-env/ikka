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
                                <div class="input-group input-group-seamless">
                                    <p>開始</p>
                                    <input
                                        type="date"
                                        class="form-control w-100 modal-title"
                                        v-model="event.start_date"
                                        ref="eventStartDate"
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

export default {
    props: ["show", "currentEvent"],
    data() {
        return {
            event: {},
            
        };
    },

    methods: {
        closeModal() {
            this.$emit("close");  
        },
        updateEvent() {
            console.log(this.event.id);
            axios
                .put("/api/event/" + this.event.id, {
                    id: this.event.id,
                    title: this.event.title,
                    start: this.event.start_date,
                    end: this.event.end_date,
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
       
    },
      // 注意！
    // watchを使わないと、eventが編集できない。
    watch: {
        currentEvent(currentEvent) {
            // ※ JSON.parse(JSON.stringify(currentEvent));
            // 検索結果のスケジュールからモーダルを起動させた場合、スケジュールに合わせて、
            // 検索結果上の予定も変更されてしまうため。
            this.event = JSON.parse(JSON.stringify(currentEvent));
        },
    },

 
};
</script>
