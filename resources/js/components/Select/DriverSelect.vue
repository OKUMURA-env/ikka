<template>
    <div class="input-group input-group-seamless">
        <p>ドライバー</p>
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
            event: {
                driver_id: "",
            },
            selectedDriverId:this.driverId || 'nobody',
        };
    },

    methods: {
        onChange(event) {             
            this.$emit("change", event);
            
         },
    },
    computed: {
    },

};
</script>