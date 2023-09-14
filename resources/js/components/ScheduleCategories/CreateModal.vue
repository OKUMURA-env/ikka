<template>
    <div
        v-if="show"
        class="modal show display"
        v-cloak
        tabindex="-1"
        aria-labelledby="CreateModal"
        aria-hidden="true"
        role="dialog"
        style="display: block"
        @click.self="closeModal"
    >
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">カテゴリー登録</h5>
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
                        class="btn btn-secondary"
                        @click="closeModal"
                        data-dismiss="modal"
                    >
                        閉じる
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        @click="saveScheduleCategory"
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
import axios from "axios";

export default {
    props: ["show"],
    data() {
        return {
            schedule_category: {
                title: null,
            },
            users: [],
        };
    },

    methods: {
        closeModal() {
            this.schedule_category.title = null;
            this.schedule_category.color = null;
            this.$emit("close");
        },
        saveScheduleCategory() {
            axios
                .post("/api/schedule-categories", {
                    title: this.schedule_category.title,
                    color: this.schedule_category.color,
                })
                .then(({ data }) => {
                    this.closeModal();
                    this.$emit("close");
                    this.$emit("rerender-schedule-categories");
                })
                .catch((error) => {
                    this.$emit("error");
                });
        },
    },

};
</script>