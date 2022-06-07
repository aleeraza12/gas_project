<template>
  <div class="main-container">
    <v-card class="elevation-0">
      <v-card-text class="pa-0">
        <div class="d-flex">
          <div class="grey-side">
            <div class="inner-box"></div>
            <div class="content-welcome d-flex align-start justify-start">
              Hello!
            </div>
            <div class="sub-content-welcome d-flex align-start justify-start">
              Welcome to GAS360 where you are guaranteed <br />
              access to clean cooking LPG fuel
            </div>
          </div>
          <div class="create-screen">
            <div class="sign-in-content d-flex align-start justify-start">
              Welcome
            </div>
            <div class="sign-in-subcontent d-flex align-start justify-start">
              Create your account to get started
            </div>
            <v-form v-model="valid">
              <div>
                <v-text-field
                  label="Owners Full Name"
                  outlined
                  dense
                  placeholder="Owners Full Name"
                  hide-details
                  :rules="nameRules"
                  class="username-feild mt-2 ml-16"
                  v-model="owners_name"
                ></v-text-field>
              </div>
              <div>
                <v-text-field
                  label="Company Name"
                  outlined
                  dense
                  placeholder="Company Name"
                  :rules="nameRules"
                  hide-details
                  class="username-feild mt-2 ml-16"
                  v-model="company_name"
                ></v-text-field>
              </div>
              <div>
                <v-text-field
                  label="Compnay Email Address"
                  outlined
                  dense
                  placeholder="Email Address"
                  hide-details
                  class="username-feild mt-2 ml-16"
                  v-model="email_address"
                  :rules="emailRules"
                ></v-text-field>
              </div>
              <div>
                <v-text-field
                  label="Company Phone Number"
                  outlined
                  dense
                  placeholder="Phone Number"
                  :rules="nameRules"
                  hide-details
                  class="username-feild mt-2 ml-16"
                  v-model="phone_number"
                ></v-text-field>
              </div>
              <div>
                <v-text-field
                  label="Address"
                  outlined
                  dense
                  :rules="nameRules"
                  placeholder="Address"
                  hide-details
                  class="username-feild mt-2 ml-16"
                  v-model="address"
                ></v-text-field>
              </div>
              <div class="d-flex">
                <div>
                  <v-text-field
                    label="City"
                    outlined
                    dense
                    placeholder="City"
                    :rules="nameRules"
                    hide-details
                    class="city-feild mt-2 ml-16"
                    v-model="city"
                  ></v-text-field>
                </div>
                <div class="mt-2 ml-2" style="width: 240px">
                  <v-select
                    v-model="state"
                    :items="getAllStates"
                    :rules="nameRules"
                    label="State"
                    outlined
                    dense
                  ></v-select>
                </div>
              </div>
              <div class="ml-16 mt-0" style="width: 400px; position: absolute">
                <v-select
                  v-model="plant"
                  :items="plants"
                  :rules="nameRules"
                  label="Select Plants"
                  outlined
                  dense
                  small
                ></v-select>
              </div>
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
                  :rules="nameRules"
                  hide-details
                  class="password-feild mt-13 ml-16"
                  v-model="password"
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
                  label="Confirm Password"
                  :rules="nameRules"
                  dense
                  placeholder="Confirm Password"
                  hide-details
                  class="password-feild mt-2 ml-16"
                  v-model="confirm_password"
                ></v-text-field>
              </div>
              <div class="mt-3 d-flex justify-start align-start">
                <span class="forget-password" @click="$router.push('login')"
                  >Already have an account? Login</span
                >
              </div>
              <div class="mt-5 ml-16">
                <v-btn
                  block
                  large
                  class="elevation-0 btn-create"
                  :loading="loading"
                  :disabled="!valid"
                  @click="createAccount()"
                  dense
                >
                  Create Account
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
    show: false,
    show1: false,
    owners_name: "",
    company_name: "",
    email_address: "",
    phone_number: "",
    address: "",
    password: "",
    snackbarMsg: "",
    snackbar: false,
    snackbarColor: "",
    confirm_password: "",
    city: "",
    state: "",
    plant: "",
    plants: ["plant 1", "plant 2", "plant 3", "plant 4", "plant 5"],
    nameRules: [(v) => !!v || "This field is required"],
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+/.test(v) || "E-mail must be valid",
    ],
    loading: false,
  }),
  components: {},
  created() {},
  mounted() {
    this.getAllStatesData();
  },
  computed: {
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getAllStates"]),
  },
  methods: {
    getAllStatesData() {
      let requestBody = {};
      let url = this.$store.state.url;
      axios.post(url + "states/read_all", requestBody).then((response) => {
        if (response.data.status == 200) {
          let states = [];
          for (let j = 0; j < response.data.response.length; j++) {
            states.push(response.data.response[j].state_name);
          }
          this.$store.commit("SET_STATES", states);
        }
      });
    },
    createAccount() {
      this.loading = true;
      if (this.password !== this.confirm_password) {
        this.snackbar = true;
        this.snackbarColor = "red";
        this.snackbarMsg = "Password and confirm password didn't matched";
        this.loading = false;
      } else {
        let url = this.$store.state.url;
        let requestBody = {
          owner_name: this.owners_name,
          company_email: this.email_address,
          company_name: this.company_name,
          company_phone_number: this.phone_number,
          city: this.city,
          state: this.state,
          gas_plant_type: this.plant,
          address: this.address,
          password: this.password,
        };
        axios
          .post(url + "company/create", requestBody)
          .then((response) => {
            this.snackbar = true;
            if (response.data.status == 201) {
              this.snackbarColor = "success";
              this.snackbarMsg = "Company created successfully";
              setTimeout(() => {
                this.$router.push("/login");
              }, 1500);
              this.loading = false;
            } else if (response.data[1] == 400) {
              this.snackbarColor = "red";
              this.snackbarMsg = response.data[0];
              this.loading = false;
            } else {
              this.snackbarColor = "red";
              this.snackbarMsg = "Something went wrong";
              this.loading = false;
            }
          })
          .catch((err) => {

            this.snackbar = true;
            this.snackbarColor = "red";
            this.loading = false;
            if (err.response.status == 422) {
              let errorArray = [];
              for (let item in err.response.data.errors) {
                errorArray.push(item);
              }
              let error = err.response.data.errors[errorArray[0]];
              this.snackbarMsg = error[0];
            } else {
              this.snackbarMsg = "Something went wrong";
            }
          });
      }
    },
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
.create-screen {
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
.forget-password {
  font-size: 12px;
  color: black;
  font-weight: 500;
  margin-left: 4rem;
  cursor: pointer;
}
.content-welcome {
  font-weight: 600;
  font-size: 18px;
  color: black;
  margin-top: 2rem;
  margin-left: 18rem;
}
.sub-content-welcome {
  font-weight: 300;
  font-size: 14px;
  color: black;
  margin-top: 0.5rem;
  margin-left: 10rem;
}
.sign-in-content {
  font-weight: 600;
  font-size: 16px;
  color: black;
  margin-top: 1rem;
  margin-left: 4.5rem;
}
.sign-in-subcontent {
  font-weight: 400;
  font-size: 12px;
  color: black;
  margin-top: 0.5rem;
  margin-left: 4.5rem;
}
.username-feild {
  width: 400px;
  border-color: #d6d6d6;
  border-radius: 8px;
}
.city-feild {
  width: 150px;
  border-color: #d6d6d6;
  border-radius: 8px;
}
.password-feild {
  width: 400px;
  border-color: #d6d6d6;
  border-radius: 8px;
}
.btn-create {
  background-color: #464646 !important;
  color: #fff;
  min-width: 400px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>
