<template>
  <div class="main-container">
    <v-card class="elevation-0">
      <v-card-text class="pa-0">
        <div class="d-flex">
          <div class="grey-side" v-show="!$vuetify.breakpoint.smAndDown">
            <div style="position: absolute">
              <img src="../../assets/images/sidePic.png" width="630" />
            </div>
            <div
              style="position: relative; margin-top: 15rem; margin-right: 5rem"
            >
              <img src="../../assets/images/side2.png" />
            </div>
          </div>
          <div class="login-screen">
            <div
              class="d-flex align-start justify-start pointer mt-5"
              @click="goToLogin()"
            >
              <v-icon color="#2e3995">mdi-chevron-left</v-icon>
              <span style="color: #2e3995">Back</span>
            </div>
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
              :style="
                $vuetify.breakpoint.smAndDown
                  ? 'margin-left: 8%;margin-top: 40%'
                  : ''
              "
            >
              Password Recovery
            </div>
            <div
              class="sign-in-subcontent d-flex align-start justify-start"
              :style="$vuetify.breakpoint.smAndDown ? 'margin-left: 8%' : ''"
            >
              Please enter the email adress linked to your account
            </div>
            <v-form v-model="valid">
              <div>
                <v-text-field
                  label="Email Address"
                  outlined
                  dense
                  :rules="nameRules"
                  placeholder="Email Address"
                  hide-details
                  class="username-feild mt-6"
                  :class="$vuetify.breakpoint.smAndDown ? 'ml-10' : 'ml-16'"
                  :style="
                    $vuetify.breakpoint.smAndDown ? 'width:80%' : 'width:60%'
                  "
                  v-model="email"
                ></v-text-field>
              </div>
              <div class="mt-10">
                <v-btn
                  block
                  large
                  :loading="loading"
                  :disabled="!valid || loading"
                  class="elevation-0 btn-login"
                  @click="sendMail(), (loader = 'loading2')"
                  :style="
                    $vuetify.breakpoint.smAndDown
                      ? 'margin-left:8rem'
                      : 'margin-left:10rem'
                  "
                  dense
                >
                  Confirm

                  <template v-slot:loader>
                    <span>Sending mail...</span>
                  </template>
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
    loading: false,
    nameRules: [(v) => !!v || "This field is required"],
    email: "",
    loading2: false,
    snackbarMsg: "",
    snackbar: false,
    snackbarColor: "",
  }),
  components: {},
  created() {},
  computed: {
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
  },
  methods: {
    goToLogin() {
      this.$router.push("/login");
    },
    sendMail() {
      this.loading = true;
      let url = this.$store.state.url;
      let body = {
        email: this.email,
      };
      axios
        .post(url + "sendbasicemail", body)
        .then((response) => {
          this.snackbar = true;
          if (response.data.status == 200) {
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snackbarMsg = "Please check you mail to reset your password";
            this.$store.commit("SET_RECOVERY_EMAIL", this.email);
            setTimeout(() => {
              this.$router.push({
                name: "MailSent",
              });
            }, 1500);
          } else if (response.data.status == 400) {
            this.snackbar = true;
            this.loading = false;
            this.snackbarColor = "red";
            this.snackbarMsg = response.data.response;
          }
        })
        .catch((err) => {
          console.log("errr", err);
          this.snackbar = true;
          this.snackbarColor = "red";
          this.loading = false;
          this.snackbarMsg = "Something went wrong";
        });
    },
  },
};
</script>
<style scoped>
.grey-side {
  /* height: 100vh; */
  width: 746px;
  left: 0px;
  top: 0px;
  border-radius: 0px;
  /* background-color: #ebebea; */
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
  margin-top: 6rem;
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
  width: 400px;
  border-color: #d6d6d6;
  border-radius: 8px;
}
.forget-passowrd {
  font-size: 12px;
  color: black;
  font-weight: 500;
  margin-left: 23rem;
}
.btn-login {
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 30% !important;
  cursor: pointer;
  border-radius: 20px !important;
  margin-left: 10rem;
}
.pointer {
  cursor: pointer;
}
</style>
