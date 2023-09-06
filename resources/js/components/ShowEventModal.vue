<template>
     <div
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
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="modal-body">
                    <div class="p-2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <label for="eventTitle">タイトル</label>
                                    <input
                                        type="text"
                                        class="form-control w-100 modal-title"
                                        placeholder="Add title ..."
                                        ref="eventTitle"
                                        autofocus
                                    />
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <label for="scheduleTitle">開始</label>
                                    <input
                                        type="date"
                                        class="form-control w-100 modal-title"
                                        ref="eventStartDate"
                                        autofocus
                                    />
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div class="input-group input-group-seamless">
                                    <label for="scheduleTitle">終了</label>
                                    <input
                                        type="date"
                                        class="form-control w-100 modal-title"
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
                        data-dismiss="modal"
                    >
                        削除
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
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
    data() {
        return {
            event: {},
            
        };
    },

    methods: {
       
    },

 
};
</script>
