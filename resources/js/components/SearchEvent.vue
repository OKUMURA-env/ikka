<template>
    <div v-if="show" @click.self="closeModal">
        <div class="container mt-3">
            <div class="row">
                <div class="col-12 col-sm-6 ml-0 mr-auto">
                    <div class="card mt-3">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div
                                        class="input-group input-group-seamless"
                                    >
                                        <input type="text" 
                                                v-model="keyword"
                                                placeholder="キーワード" />
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div
                                        class="input-group input-group-seamless"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            @click="resetForm"
                                        >
                                            リセット
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        {{ searchedEvents }}
                        <table>
                            <tr v-for="event in searchedEvents" :key="event.id">
                                <td v-text="event.id"></td>
                                <td v-text="event.title"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["show"],
    components: {},
    data() {
        return {
            all_events:[],
            searched_events:{},
            keyword: "",
        };
    },
    mounted() {
        this.getEvents();
    },

    methods: {
        getEvents() {
            axios
                .get("/api/search-event", {})
                .then((response) => {
                    // カレンダーに読み込み
                    this.all_events = response.data;
                })
                .catch(() => {
                    // バリデーションエラーなど
                    alert("登録に失敗しました");
                });
        },

        resetForm() {
            this.keyword = "";
        },
    },

    computed: {
        searchedEvents: function () {
            var searched_events = [];
            for (var i in this.all_events) {
                var event = this.all_events[i];
                if(this.keyword && event.title?.includes(this.keyword)){
                    searched_events.push(event);
                }
            }
            return searched_events;
        },

    },
};
</script>
