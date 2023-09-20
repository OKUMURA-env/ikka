<template>
    <div
        v-if="show"
        class="modal show display"
        v-cloak
        tabindex="-1"
        aria-labelledby="ShowModal"
        aria-hidden="true"
        role="dialog"
        style="display: block"
        @click.self="closeModal"
    >
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">カテゴリー詳細</h5>
                    {{ schedule_category }}
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
                                        v-model="schedule_category.title"
                                        placeholder="Add title ..."
                                        ref="scheduleCategoryTitle"
                                        autofocus
                                    />
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <p>カラー</p>
                                    <input
                                        type="color"
                                        class="form-control w-100 modal-title"
                                        v-model="schedule_category.color"
                                        ref="scheduleCategoryColor"
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
                        @click="deleteScheduleCategory(scheduleCategoryId)"
                        data-dismiss="modal"
                    >
                        削除
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="updateScheduleCategory(scheduleCategoryId)"
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
    props: ["show","scheduleCategoryId","currentScheduleCategory"],
    data() {
        return {
            event: {},
            schedule_category: {},
        };
    },

    methods: {
        closeModal() {
            this.$emit("close");
        },
        updateScheduleCategory(scheduleCategoryId) {
            axios
                .put("/api/schedule-categories/" + scheduleCategoryId, {
                    id: scheduleCategoryId,
                    title: this.schedule_category.title,
                    color: this.schedule_category.color
                })
                .then(({ data }) => {
                    this.closeModal();
                    this.$emit("schedule-category-updated");
                })
                .catch((error) => {
                    this.$emit("error");
                });
        },
        deleteScheduleCategory(scheduleCategoryId) {
            axios
                .delete("/api/schedule-categories/" + scheduleCategoryId ,this.schedule_category )
                .then(({ data }) => {
                    this.closeModal();
                    this.$emit("schedule-category-deleted");
                    
                })
                .catch((error) => {
                    this.$emit("error");
                });

            
            
        },
    },
    // 注意！
    // watchを使わないと、ScheduleCategoryが編集できない。
    watch: {
        currentScheduleCategory(currentScheduleCategory) {
            console.log(currentScheduleCategory);
            
            // ※ JSON.parse(JSON.stringify(currentScheduleCategory));
            // 検索結果のスケジュールからモーダルを起動させた場合、スケジュールに合わせて、
            // 検索結果上の予定も変更されてしまうため。
            this.schedule_category = JSON.parse(JSON.stringify(currentScheduleCategory));
        },
    },
};
</script>
