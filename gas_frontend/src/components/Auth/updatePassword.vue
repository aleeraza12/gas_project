<template>
  <div class="main-container">
    <v-card class="elevation-0">
      <v-card-text class="pa-0">
        <div class="d-flex">
          <div class="grey-side" v-show="!$vuetify.breakpoint.smAndDown">
            <div style="position: absolute">
              <img src="../../assets/images/sidePic.png" width="650" />
            </div>
            <div style="position: relative; margin-top: 15rem;margin-right: 5rem;">
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
                width="400px"
                max-width="400px"
                min-width="400px"
                style="max-height: 30vh"
              />
            </div>
            <div
              style="position: relative; margin-top: 3rem; margin-right: 3rem"
              v-show="$vuetify.breakpoint.smAndDown"
            >
              <img src="../../assets/images/side2.png" />
            </div>
            <div
              class="sign-in-content d-flex align-start justify-start"
              :style="$vuetify.breakpoint.smAndDown ? ' margin-top: 9rem' : ''"
            >
              Update Password
            </div>
            <div
              class="sign-in-subcontent d-flex align-start justify-start"
              :class="$vuetify.breakpoint.smAndDown ? 'ml-5' : ''"
            >
              Create a new password for your account
            </div>
            <v-form v-model="valid">
              <div>
                <v-text-field
                  outlined
                  :append-icon="
                    show ? 'mdi-eye-outline' : 'mdi-eye-off-outline'
                  "
                  :type="show ? 'text' : 'password'"
                  @click:append="show = !show"
                  label="Password"
                  dense
                  placeholder="Password"
                  hide-details
                  class="password-feild mt-3"
                  :class="$vuetify.breakpoint.smAndDown ? 'ml-10' : 'ml-16'"
                  :style="
                    $vuetify.breakpoint.smAndDown ? 'width:80%' : 'width:50%'
                  "
                  v-model="password"
                  :rules="nameRules"
                ></v-text-field>
              </div>
              <div>
                <v-text-field
                  outlined
                  :append-icon="
                    show1 ? 'mdi-eye-outline' : 'mdi-eye-off-outline'
                  "
                  :type="show1 ? 'text' : 'confirm_password'"
                  @click:append="show1 = !show1"
                  label="Confirm Password"
                  dense
                  placeholder="Confirm Password"
                  hide-details
                  class="password-feild mt-3"
                  :class="$vuetify.breakpoint.smAndDown ? 'ml-10' : 'ml-16'"
                  v-model="confirm_password"
                  :style="
                    $vuetify.breakpoint.smAndDown ? 'width:80%' : 'width:50%'
                  "
                  :rules="nameRules"
                ></v-text-field>
              </div>
              <div
                class="mt-10"
                :class="$vuetify.breakpoint.smAndDown ? 'ml-n10' : 'ml-16'"
              >
                <v-btn
                  block
                  :disabled="!valid"
                  :loading="loading"
                  class="elevation-0 btn-login"
                  @click="updatePassword()"
                  :class="$vuetify.breakpoint.smAndDown ? 'small' : 'large'"
                  dense
                >
                  Reset Password
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
import { mapGetters } from "vuex";

export default {
  data: () => ({
    valid: false,
    snackbarMsg: "",
    snackbar: false,
    snackbarColor: "",
    nameRules: [(v) => !!v || "This field is required"],
    loading: false,
    show: false,
    show1: false,
    password: "",
    email: "",
    confirm_password: "",
  }),
  components: {},
  computed: {
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getRecoveryMail"]),
  },
  created() {},
  methods: {
    goToLogin() {
      this.$router.push("/mail-sent");
    },
    updatePassword() {
      this.loading = true;
      if (this.password !== this.confirm_password) {
        this.snackbar = true;
        this.snackbarColor = "red";
        this.snackbarMsg = "Password and confirm password didn't matched";
        this.loading = false;
      } else {
        let url = this.$store.state.url;
        let body = {
          email: this.getRecoveryMail,
          password: this.password,
        };
        axios
          .post(url + "update_password", body)
          .then((response) => {
            this.snackbar = true;
            this.loading = false;
            if (response.data.status == 200) {
              this.snackbar = true;
              this.snackbarColor = "success";
              this.snackbarMsg = "Password updated successfully";
              setTimeout(() => {
                this.$router.push("/reset-message");
              }, 1000);
            }
          })
          .catch(() => {
            this.snackbar = true;
            this.snackbarColor = "red";
            this.loading = false;
            this.snackbarMsg = "Something went wrong";
          });
      }
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
  width: 60%;
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
  margin-left: 23rem;
  cursor: pointer;
}
.btn-login {
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 200px !important;
  cursor: pointer;
  border-radius: 20px !important;
  margin-left: 7rem;
}
</style>
