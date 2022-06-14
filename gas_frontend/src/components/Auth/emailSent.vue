<template>
  <div class="main-container">
    <v-card>
      <v-card-text class="pa-0">
        <div class="d-flex">
          <div class="grey-side"></div>
          <div class="login-screen">
            <div
              class="d-flex align-start justify-start pointer mt-5"
              @click="goToLogin()"
            >
              <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
            </div>
            <div class="inner-box"></div>
            <div class="sign-in-content d-flex align-start justify-start">
              Recovery Email Sent
            </div>
            <div class="sign-in-subcontent d-flex align-start justify-start">
              Kindly check your email for the password reset code that has been
              sent to you
            </div>
            <div
              class="mt-5 resend-text d-flex align-start justify-start ml-12"
              @click="resend()"
            >
              Didn’t receive any email? <b class="ml-2">Resend</b>
            </div>
            <div class=" ml-12 position-relative mt-3 d-flex align-start justify-start" style="max-width: 300px">
              <v-otp-input
                v-model="otp"
                :disabled="loading"
                @finish="onFinish"
                dense
              ></v-otp-input>
              <v-overlay absolute :value="loading">
                <v-progress-circular
                  indeterminate
                  color="primary"
                ></v-progress-circular>
              </v-overlay>
            </div>
            <div class="text--caption d-flex align-start jutsiy-start ml-12 mt-2">Type or copy/paste.</div>
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
import { mapGetters } from "vuex";

export default {
  data: () => ({
    valid: false,
    email: "",
    loading: false,
    snackbarMsg: "",
    snackbar: false,
    snackbarColor: "",
    otp: "",
    text: "",
    expectedOtp: "133707",
  }),
  components: {},
  created() {},
  computed: {
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getRecoveryMail"]),
  },
  methods: {
    goToLogin() {
      this.$router.push("/password-recover");
    },
    resend() {
      this.$router.push({
        name: "PasswordRecover",
      });
    },
    onFinish() {
      console.log(this.email);
      this.loading = true;
      let url = this.$store.state.url;
      let body = {
        otp: this.otp,
        email: this.getRecoveryMail,
      };
      console.log(body);
      axios
        .post(url + "verify_otp", body)
        .then((response) => {
          this.snackbar = true;
          this.loading = false;
          if (response.data.status == 200) {
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snackbarMsg = "OTP verified";
            setTimeout(() => {
              this.$router.push({
                name: "Update Password",
              });
            }, 1000);
          } else if (response.data.status == 400) {
            this.snackbar = true;
            this.snackbarColor = "red";
            this.snackbarMsg = "Wrong OTP";
          }
        })
        .catch(() => {
          this.snackbar = true;
          this.snackbarColor = "red";
          this.loading = false;
          this.snackbarMsg = "Something went wrong";
        });
    },
    //setTimeout(() => {
    //  this.loading = false;
    //  this.snackbarColor = rsp === this.expectedOtp ? "success" : "warning";
    //  this.text = `Processed OTP with "${rsp}" (${this.snackbarColor})`;
    //  this.snackbar = true;
    //}, 3500);
  },
};
</script>
<style scoped>
.grey-side {
  height: 100vh;
  width: 746px;
  left: 0px;
  top: 0px;
  border-radius: 0px;
  background-color: #ebebea;
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
  height: 250px;
  width: 300px;
  background-color: #d2d2d2;
  margin-top: 4rem;
  margin-left: 3rem;
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
  margin-top: 1rem;
  margin-left: 3rem;
}
.sign-in-subcontent {
  font-weight: 400;
  font-size: 14px;
  color: black;
  margin-top: 1rem;
  margin-left:3rem;
}
.username-feild {
  width: 400px;
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
  background-color: #464646 !important;
  color: #fff;
  min-width: 400px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
.resend-text {
  margin-right: 5rem;
  cursor: pointer;
}
</style>
