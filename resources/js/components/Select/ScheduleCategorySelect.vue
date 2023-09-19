<template>
    <div class="input-group input-group-seamless">
        <p>カテゴリー</p>
        <select class="form-control" 
                v-model="selectedScheduleCategoryId"
                @change = "onChange">
            <option disabled value="nobody">未選択</option>
            <option
                v-for="schedule_category in schedule_categories"
                v-bind:value = "schedule_category.id"
                v-bind:key = "schedule_category.id"
            >
                {{ schedule_category.title }}
            </option>
        </select>
        <div>選択項目: {{ selectedScheduleCategoryId }}</div>
    </div>
</template>

<script>
import { stringifyStyle } from "@vue/shared";
import axios from "axios";

export default {
    props: ["schedule_categories","scheduleCategoryId"],
    data() {
        return {
            event: {
                schedule_category_id: "",
            },
            selectedScheduleCategoryId:this.scheduleCategoryId || 'nobody',
        };
    },

    methods: {
        onChange(event) {
          this.$emit("change", event);
         }
    },
};
</script>
