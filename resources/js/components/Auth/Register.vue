<template>
    <div class="register-page">
      <div class="register-box">
        <div class="register-logo">
          <a href="../../index2.html"><b>株式会社</b>一荷</a>
        </div>
        <div class="card">
          <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>
            <form @submit.prevent="register">
              <div class="input-group mb-3">
                <input
                  type="text"
                  class="form-control"
                  name="name"
                  v-model="user.name"
                  placeholder="Full name"
                />
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input
                  type="email"
                  class="form-control"
                  name="email"
                  v-model="user.email"
                  placeholder="Email"
                />
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input
                  type="password"
                  class="form-control"
                  name="password"
                  v-model="user.password"
                  placeholder="Password"
                />
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input
                  type="password"
                  class="form-control"
                  name="password_confirmation"
                  v-model="user.password_confirmation"
                  placeholder="Retype password"
                />
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input
                      type="checkbox"
                      id="agreeTerms"
                      name="terms"
                      value="agree"
                    />
                    <label for="agreeTerms">
                      I agree to the <a href="#">terms</a>
                    </label>
                  </div>
                </div>
  
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">
                    Register
                  </button>
                </div>
              </div>
            </form>
            <router-link to="login" class="text-center">
              I already have a membership
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </template>
    
  <script>
  export default {
    name: "register",
    data() {
      return {
        user: {
          name: "",
          email: "",
          password: "",
          password_confirmation: "",
        },
      };
    },
    methods: {
      async register() {
        console.log("ok");
        try {
          // Register the user
          await axios.post("/api/register", this.user);
          console.log(this.user);
          // Attempt to login
          await this.signIn();
        } catch (error) {
          console.error("Registration failed:", error);
          alert("Registration failed");
        }
      },
      async signIn() {
        try {
          await axios.get("/sanctum/csrf-cookie");
          const response = await axios.post("/api/login", {
            email: this.user.email,
            password: this.user.password,
          });
  
          localStorage.setItem("authToken", response.data.access_token);
  
          this.$router.push({ name: "calendar" });
        } catch (error) {
          console.error("Login failed:!", error);
          alert("Login failed");
        }
      },
    },
  };
  </script>
    
  <style scoped>
  /* ここに Register.vue に適用するスタイルを記述します */
  </style>
    