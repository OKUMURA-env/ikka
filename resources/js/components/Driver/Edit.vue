<template>
   <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">ドライバー編集</div>
            <div class="panel-body">
                <form @submit.prevent="updateDriver">
                    <div class="form-group">
                        <label class="control-label">名前</label>
                        <input class="form-control" 
                               type="text"
                        />
                    </div>

                    <div class="form-group">
                        <label class="control-label">メールアドレス</label>
                        <input class="form-control" 
                               type="text"
                        />
                    </div>

                    <div class="form-group">
                        <label class="control-label">スケジュール表示名</label>
                        <input class="form-control" 
                               type="text"
                         />
                    </div>

                    <div class="form-group">
                        <label class="control-label">その他</label>
                        <textarea
                            class="form-control"
                            cols="30"
                            rows="10"
                        ></textarea>
                    </div>

                    <button class="btn btn-default">更新</button>
                </form>
            </div>
        </div>
    </div>
</template>  
<script>
export default {
    data() {

    },
    mounted() {

    },
    methods: {

    },
}

</script>
  