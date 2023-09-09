<template>
    <div class="login-page" style="min-height: 496.797px">
      <div class="login-box">
        <div class="login-logo">
          <a href="../../index2.html"><b>株式会社</b>一荷</a>
        </div>
  
        <div class="card">
          <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form @submit.prevent="login">
              <div class="input-group mb-3">
                <input 
                  type="text" 
                  name="email" 
                  class="form-control" 
                  v-model="user.email" 
                  placeholder="Email..." 
                  autocomplete="true"/>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-id-card"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input
                  type="password"
                  name="password"
                  v-model="user.password"
                  class="form-control"
                  placeholder="Password"
                  autocomplete="true"
                />
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <!-- <div class="icheck-primary">
                    <input type="checkbox" id="remember" />
                    <label for="remember"> Remember Me </label>
                  </div> -->
                </div>
  
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">
                    Login
                  </button>
                </div>
              </div>
            </form>
  
            <!-- <p class="mb-1">
              <a href="forgot-password.html">I forgot my password</a>
            </p>
            <p class="mb-0">
              <router-link to="register" class="text-center">
                Register a new membership
              </router-link>
            </p> -->
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
    export default {
      data() {
        return {
          user: {
            email: "",
            password: "",
          }
        }
      },
      methods: {
        async login() {
          if(!this.user.password || !this.user.email){
            alert('ログインIDとパスワードを入力してください。');
            return;
          }
          await axios
            .get("/sanctum/csrf-cookie");
          try {
            await axios
              .post("/api/login", this.user)
              .then((response => {
                console.log(response.data.access_token);
                  // Save the authToken in localStorage
                  localStorage.setItem("authToken", response.data.access_token);
                  console.log(this.user);
                  this.$router.replace({ name: "calendar" });
              }))
          } catch(response) {
            alert(response.response.data.message);
          }
        },
        // closeControlSidebar() {
        //   const body = document.querySelector("body");
        //   if (body.classList.contains("control-sidebar-slide-open")) {
        //     body.classList.remove("control-sidebar-slide-open");
        //   }
        // },
      },
      mounted() {
        // this.closeControlSidebar();
      }
    }
  </script>
  