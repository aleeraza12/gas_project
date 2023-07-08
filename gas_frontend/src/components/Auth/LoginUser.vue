<template>
  <div class="main-container">
    <v-card class="elevation-0">
      <v-card-text class="pa-0">
        <div class="d-flex">
          <div class="grey-side" v-show="!$vuetify.breakpoint.smAndDown">
            <div style="position: absolute">
              <img src="../../assets/images/sidePic.png" style="height: auto" />
            </div>
            <div
              style="position: relative; margin-top: 15rem; margin-right: 5rem"
            >
              <img src="../../assets/images/side2.png" />
            </div>
            <div style="position: relative" class="mt-10">
              <span
                style="
                  font-size: 35px;
                  color: #fff;
                  margin-right: 3rem;
                  font-weight: 600;
                "
                >Welcome Back!</span
              >
            </div>
            <div
              class="mt-5"
              style="
                position: relative;
                font-size: 24px;
                color: #fff;
                margin-right: 3rem;
              "
            >
              <span>Sign in to access your dashboard</span>
            </div>
          </div>

          <!-- For laptop -->
          <div
            class="login-screen"
            :class="$vuetify.breakpoint.smAndDown ? 'ml-0' : ''"
          >
            <div
              style="position: absolute"
              v-show="$vuetify.breakpoint.smAndDown"
            >
              <img
                src="../../assets/images/sidePic.png"
                width="212%"
                max-width="212%"
                min-width="212%"
                style="max-height: 35vh; max-width: 212%"
              />
            </div>
            <div
              style="position: relative; margin-top: 20%; margin-left: 5%"
              v-show="$vuetify.breakpoint.smAndDown"
            >
              <img src="../../assets/images/side2.png" />
            </div>
            <div
              class="sign-in-content d-flex align-start justify-start"
              :class="$vuetify.breakpoint.smAndDown ? 'ml-10' : ''"
              :style="
                $vuetify.breakpoint.smAndDown
                  ? 'margin-top: 35%'
                  : ' margin-top: 6rem'
              "
            >
              Sign In
            </div>
            <div
              class="sign-in-subcontent d-flex align-start justify-start"
              :class="$vuetify.breakpoint.smAndDown ? 'ml-10' : ''"
            >
              Enter your username and password
            </div>
            <v-form v-model="valid">
              <div>
                <v-text-field
                  label="Email"
                  outlined
                  dense
                  placeholder="Email"
                  hide-details
                  :rules="emailRules"
                  class="username-feild mt-6"
                  :class="$vuetify.breakpoint.smAndDown ? 'ml-10' : 'ml-16'"
                  :style="
                    $vuetify.breakpoint.smAndDown ? 'width:85%' : 'width:60%'
                  "
                  v-model="email"
                ></v-text-field>
              </div>
              <div>
                <v-text-field
                  outlined
                  :append-icon="
                    show ? 'mdi-eye-outline' : 'mdi-eye-off-outline'
                  "
                  :type="show ? 'text' : 'password'"
                  @click:append="show = !show"
                  :rules="[rules.required]"
                  label="Password"
                  dense
                  placeholder="Password"
                  hide-details
                  class="password-feild mt-3"
                  :class="$vuetify.breakpoint.smAndDown ? 'ml-10' : 'ml-16'"
                  :style="
                    $vuetify.breakpoint.smAndDown ? 'width:85%' : 'width:60%'
                  "
                  v-model="password"
                ></v-text-field>
              </div>
              <div class="d-flex mt-3">
                <div
                  class="regster"
                  @click="$router.push('signup')"
                  :class="$vuetify.breakpoint.smAndDown ? 'ml-15' : ''"
                >
                  Register
                </div>
                <div
                  @click="forgetPassword()"
                  class="forget-passowrd"
                  :style="
                    $vuetify.breakpoint.smAndDown
                      ? ' margin-left: 10rem;'
                      : ' margin-left: 16rem;'
                  "
                >
                  Forgot Password?
                </div>
              </div>
              <div class="forget-passowrd mt-3"></div>
              <div class="mt-10 d-flex align-start justify-start">
                <v-btn
                  small
                  class="elevation-0 btn-login"
                  @click="login()"
                  :loading="loading"
                  dense
                  :style="
                    $vuetify.breakpoint.smAndDown
                      ? 'margin-left: 40%'
                      : 'margin-left: 10rem'
                  "
                  :class="$vuetify.breakpoint.smAndDown ? 'x-small' : 'small'"
                >
                  Sign In
                </v-btn>
              </div>
            </v-form>
          </div>
        </div>
      </v-card-text>
    </v-card>
    <v-snackbar
      v-model="snackbar"
      :timeout="2000"
      :value="true"
      absolute
      class="mt-5"
      :color="snackbarColor"
      shaped
      :right="true"
      :top="true"
      text
    >
      <v-icon class="pr-3" :color="snackbarColor">{{ getIcon }} </v-icon>
      {{ snackbarMsg }}
    </v-snackbar>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    valid: false,
    show: false,
    username: "",
    password: "",
    snackbarMsg: "",
    snackbar: false,
    snackbarColor: "",
    loading: false,
    start_date: new Date().toISOString().substr(0, 10),
    end_date: new Date().toISOString().substr(0, 10),
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+/.test(v) || "E-mail must be valid",
    ],
    rules: {
      required: (value) => !!value || "Required.",
    },
    email: null,
  }),
  components: {},
  created() {},
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    //...mapGetters(["getAdminInfo"]),
  },
  watch: {
    email() {
      this.email && this.password
        ? (this.btnDisable = false)
        : (this.btnDisable = true);
    },
    password() {
      this.email && this.password
        ? (this.btnDisable = false)
        : (this.btnDisable = true);
    },
  },
  mounted() {},
  methods: {
    login() {
      this.loading = true;
      let url = this.$store.state.url;
      let body = {
        email: this.email,
        password: this.password,
      };
      axios
        .post(url + "login", body)
        .then((response) => {
          this.snackbar = true;
          if (response.data.status == 200) {
            this.snackbarColor = "primary";
            this.snackbarMsg = "Login successfully";
            this.loading = false;
            localStorage.setItem("token", response.data.data.token);
            localStorage.setItem(
              "user",
              JSON.stringify(response.data.data.user)
            );
            let requestBody = {
              start_date: this.start_date,
              end_date: this.end_date.concat(" 23:59:00"),
            };
            this.$store.dispatch("getSalesListings", requestBody);
            let vm = this;
            setTimeout(function () {
              vm.$router.push("/dashboard");
            }, 1200);
          } else if (response.data.status == 400) {
            this.loading = false;
            this.snackbarColor = "red";
            this.snackbarMsg = response.data.data;
          }
        })
        .catch(() => {
          this.snackbar = true;
          this.snackbarColor = "red";
          this.snackbarMsg = "Something went wrong";
          this.loading = false;
        });
    },

    //login() {
    //  this.$router.push({
    //    name: "Dashboard",
    //  });
    //},
    forgetPassword() {
      this.$router.push({
        name: "PasswordRecover",
      });
    },
  },
};
</script>
<style scoped>
.grey-side {
  width: 746px;
  left: 0px;
  top: 0px;
  border-radius: 0px;
}
.login-screen {
  height: 100vh;
  width: 746px;
  left: 0px;
  top: 0px;
  border-radius: 0px;
  background-color: #fff;
}
.inner-box {
  height: 300px;
  width: 300px;
  background-color: #d2d2d2;
  margin-top: 6rem;
  margin-left: 10rem;
}
.content-welcome {
  font-weight: 600;
  font-size: 18px;
  color: black;
  margin-top: 2rem;
  margin-left: 15rem;
}
.sub-content-welcome {
  font-weight: 300;
  font-size: 14px;
  color: black;
  margin-top: 0.5rem;
  margin-left: 13rem;
}
.sign-in-content {
  font-weight: 600;
  font-size: 18px;
  color: black;
  margin-left: 4.5rem;
}
.sign-in-subcontent {
  font-weight: 400;
  font-size: 14px;
  color: black;
  margin-top: 1rem;
  margin-left: 4.5rem;
}
.username-feild {
  border-color: #d6d6d6;
  border-radius: 8px;
}
.password-feild {
  border-color: #d6d6d6;
  border-radius: 8px;
}
.forget-passowrd {
  font-size: 12px;
  color: black;
  font-weight: 500;
  cursor: pointer;
}
.regster {
  font-size: 12px;
  color: black;
  font-weight: 500;
  margin-left: 4rem;
  cursor: pointer;
}
.btn-login {
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 30% !important;
  border-radius: 20px !important;
  cursor: pointer;
}
@media (min-width: 2000px) and (max-width: 3000px) {
  .card-width {
    min-width: 400px !important;
  }
}
</style>
