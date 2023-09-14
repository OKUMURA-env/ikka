<template>
    <div class="input-group input-group-seamless">
        <label for="driver">ドライバー</label>
        <select class="form-control" 
                v-model="selectedDriverId"
                @change = "onChange">
            <option disabled value="nobody">未選択</option>
            <option
                v-for="driver in drivers"
                v-bind:value = "driver.id"
                v-bind:key = "driver.id"
            >
                {{ driver.name }}
            </option>
        </select>
        <div>選択項目: {{ selectedDriverId }}</div>
    </div>
</template>

<script>
import { stringifyStyle } from "@vue/shared";
import axios from "axios";

export default {
    props: ["drivers","driverId"],
    data() {
        return {
            selectedDriverId:this.driverId || 'nobody',
        };
    },

    methods: {
        onChange(event) {
            if (this.SelectedDriverId !== 'nobody') {
            const display_name = this.selectedDriverScheduleDisplayName;
            console.log(display_name);              
            this.$emit("change", event, display_name);
            }
         },
    },
    computed: {
       
    },

};
</script>