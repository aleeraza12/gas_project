<template>
  <div class="main-container">
    <v-row>
      <v-col md="6" lg="6" xl="6" sm="12">
        <div
          @click="goToCustomerListings()"
          class="d-flex align-start justify-start pointer"
        >
          <v-icon color="#2e3995">mdi-chevron-left</v-icon>
          <span style="color: #2e3995">Back</span>
        </div>
        <div class="mt-3">
          <div class="d-flex align-center justify-center">
            <b>Update Company Data</b>
          </div>
          <!-- for moble phone -->
          <div v-if="$vuetify.breakpoint.smAndDown">
            <div
              v-if="decodedBase64 == ''"
              class="d-flex justify-center align-center"
              style="margin-top: 3rem"
              :style="$vuetify.breakpoint.smAndDown ? 'margin-left: 0rem;' : ''"
            >
              <img
                src="../../assets/images/circle.png"
                height="150"
                style="position: absolute"
              />
              <img
                src="../../assets/images/imageicon.png"
                height="100"
                style="position: relative"
              />
            </div>
            <div v-else class="d-flex justify-center align-center">
              <v-avatar size="136px">
                <img :src="decodedBase64" alt="John" />
              </v-avatar>
            </div>
            <div style="margin-top: 2rem">
              <label for="file-input">
                <b style="text-decoration: underline" class="pointer"
                  >Change Image</b
                >
                <input
                  id="file-input"
                  type="file"
                  class="d-none"
                  @change="onFileChange"
                />
              </label>
            </div>
          </div>
          <div class="d-flex align-start justify-start fonts mt-1">
            <div class="mt-6">
              <div class="d-flex align-start justify-start">
                <!--<b>New Customer</b>-->
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
                    class="username-feild mt-2"
                    :class="
                      $vuetify.breakpoint.smAndDown ? 'ml-1 pr-1' : 'ml-16'
                    "
                    v-model="owners_name"
                  ></v-text-field>
                </div>
                <div v-if="!loggedinUser.is_super_admin">
                  <v-text-field
                    label="Company Name"
                    outlined
                    dense
                    placeholder="Company Name"
                    :rules="nameRules"
                    hide-details
                    class="username-feild mt-2"
                    :class="
                      $vuetify.breakpoint.smAndDown ? 'ml-1 pr-1' : 'ml-16'
                    "
                    v-model="company_name"
                  ></v-text-field>
                </div>
                <div>
                  <v-text-field
                    outlined
                    dense
                    depressed
                    placeholder="You can not change your email address"
                    label="You can not change your email address"
                    hide-details="auto"
                    class="username-feild mt-2"
                    :class="
                      $vuetify.breakpoint.smAndDown ? 'ml-1 pr-1' : 'ml-16'
                    "
                    v-model="email_address"
                    readonly
                  ></v-text-field>
                </div>
                <div v-if="!loggedinUser.is_super_admin">
                  <v-text-field
                    label="Company Phone Number"
                    outlined
                    dense
                    placeholder="Phone Number"
                    :rules="nameRules"
                    hide-details
                    class="username-feild mt-2"
                    :class="
                      $vuetify.breakpoint.smAndDown ? 'ml-1 pr-1' : 'ml-16'
                    "
                    v-model="phone_number"
                  ></v-text-field>
                </div>
                <div v-if="!loggedinUser.is_super_admin">
                  <v-text-field
                    label="Address"
                    outlined
                    dense
                    :rules="nameRules"
                    placeholder="Address"
                    hide-details
                    class="username-feild mt-2"
                    :class="
                      $vuetify.breakpoint.smAndDown ? 'ml-1 pr-1' : 'ml-16'
                    "
                    v-model="address"
                  ></v-text-field>
                </div>

                <div class="d-flex" v-if="!loggedinUser.is_super_admin">
                  <div v-if="!loggedinUser.is_super_admin">
                    <v-text-field
                      label="City"
                      outlined
                      dense
                      placeholder="City"
                      :rules="nameRules"
                      hide-details
                      class="city-feild mt-2"
                      :class="
                        $vuetify.breakpoint.smAndDown ? 'ml-1 pr-1' : 'ml-16'
                      "
                      v-model="city"
                    ></v-text-field>
                  </div>
                  <div
                    class="mt-2 ml-2"
                    style="width: 240px"
                    v-if="!loggedinUser.is_super_admin"
                  >
                    <v-select
                      v-if="!loggedinUser.is_super_admin"
                      v-model="state"
                      :items="getAllStates"
                      :rules="nameRules"
                      label="State"
                      class="username-feild"
                      outlined
                      dense
                    ></v-select>
                  </div>
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
                    class="password-feild mt-2"
                    :class="
                      $vuetify.breakpoint.smAndDown ? 'ml-1 pr-1' : 'ml-16'
                    "
                    v-model="password"
                  ></v-text-field>
                </div>
                <div
                  class="mt-5"
                  :class="$vuetify.breakpoint.smAndDown ? 'ml-0 pr-0' : 'ml-8'"
                >
                  <v-btn
                    block
                    large
                    class="elevation-0 btn-create"
                    :loading="loading"
                    :disabled="!valid"
                    @click="updateCompany()"
                    :class="$vuetify.breakpoint.smAndDown ? 'x-small' : 'large'"
                    :style="
                      $vuetify.breakpoint.smAndDown ? 'max-width:30px' : ''
                    "
                    dense
                  >
                    Update Account
                  </v-btn>
                </div>
              </v-form>
            </div>

            <v-snackbar
              v-model="snackbar"
              :timeout="2000"
              :value="true"
              absolute
              class="mt-6"
              :color="snackbarColor"
              shaped
              :right="true"
              :top="true"
              text
            >
              <v-icon class="pr-3" :color="snackbarColor"
                >{{ getIcon }}
              </v-icon>
              {{ snacbarMessage }}
            </v-snackbar>
          </div>
        </div>
      </v-col>
      <v-col md="6" lg="6" xl="6" v-if="!$vuetify.breakpoint.smAndDown">
        <div class="pa-5" style="background-color: #eff0fa; height: 100vh">
          <div class="d-flex justify-start align-start mt-5">
            <b>Company Profile</b>
          </div>
          <div
            v-if="decodedBase64 == ''"
            class="d-flex justify-center align-center"
            style="margin-top: 10rem"
          >
            <img
              src="../../assets/images/circle.png"
              height="150"
              style="position: absolute"
            />
            <img
              src="../../assets/images/imageicon.png"
              height="100"
              style="position: relative"
            />
          </div>
          <div v-else class="d-flex justify-center align-center">
            <v-avatar size="136px">
              <img :src="decodedBase64" alt="John" />
            </v-avatar>
          </div>
          <div style="margin-top: 2rem">
            <label for="file-input">
              <b style="text-decoration: underline" class="pointer"
                >Change Image</b
              >
              <input
                id="file-input"
                type="file"
                class="d-none"
                @change="onFileChange"
              />
            </label>
          </div>
          <div
            class="d-flex justify-start align-start mt-5 ml-2"
            v-if="!loggedinUser.is_super_admin"
          >
            <div>Owner's Name :</div>
            <div class="ml-5">
              <b>{{ loggedinUser.owner_name }},</b>
            </div>
          </div>
          <div
            class="d-flex justify-start align-start mt-2 ml-2"
            v-if="!loggedinUser.is_super_admin"
          >
            <div>Company's Name :</div>
            <div class="ml-5">
              <b>{{ loggedinUser.company_name }}</b>
            </div>
          </div>
          <div
            class="d-flex justify-start align-start mt-4 ml-2"
            v-if="!loggedinUser.is_super_admin"
          >
            <div>Phone Number :</div>
            <div class="ml-5">
              <b>{{ loggedinUser.company_phone_number }},</b>
            </div>
          </div>
          <div
            class="d-flex justify-start align-start mt-2 ml-2"
            v-if="!loggedinUser.is_super_admin"
          >
            <div>Email Address :</div>
            <div class="ml-5">
              <b>{{ loggedinUser.company_email }}</b>
            </div>
          </div>
          <div
            class="d-flex justify-start align-start mt-2 ml-2"
            v-if="!loggedinUser.is_super_admin"
          >
            <div>Address :</div>
            <div class="ml-16">
              <b>{{ loggedinUser.address }} - {{ loggedinUser.city }}</b>
            </div>
          </div>
        </div>
      </v-col>
    </v-row>
  </div>
</template>
<script>
import RequestService from "../../RequestService";
import { eventBus } from "@/main";
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
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    decodedBase64: "",
    files: "",
    fileType: "",
    id: "",
    city: "",
    state: "",
    plant: "",
    update: false,
    data: JSON.parse(localStorage.getItem("user")),
    plants: ["plant 1", "plant 2", "plant 3", "plant 4", "plant 5"],
    nameRules: [(v) => !!v || "This field is required"],
    emailRules: [
      (v) => !!v || "E-mail is required",
      (v) => /.+@.+/.test(v) || "E-mail must be valid",
    ],
    loading: false,
    loggedinUser: JSON.parse(localStorage.getItem("user")),
  }),
  computed: {
    getIcon() {
      return this.snackbarColor == "success"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getAllCustomerTypes", "getAllStates"]),
  },
  created() {
    eventBus.$on("validationFailed", (err) => {
      this.snackbar = true;
      this.snackbarColor = "red";
      let errorArray = [];
      for (let item in err.response.data.errors) {
        errorArray.push(item);
      }
      let error = err.response.data.errors[errorArray[0]];
      this.snacbarMessage = error[0];
    });
  },
  mounted() {
    this.$store.dispatch("getAllStates");
    this.assembleData();
  },
  methods: {
    goToCustomerListings() {
      this.$router.go(-1);
    },
    assembleData() {
      this.owners_name = this.data.owner_name;
      this.email_address = this.data.company_email;
      this.company_name = this.data.company_name;
      this.phone_number = this.data.company_phone_number;
      this.city = this.data.city;
      this.state = this.data.state;
      //this.plant = this.data.gas_plant_type;
      this.address = this.data.address;
      this.password = "";
      this.id = this.data.id;
      this.update = true;

      if (
        this.data.company_profile_picture &&
        this.data.company_profile_picture != null
      )
        this.decodedBase64 =
          "data:image/jpeg;base64," + this.data.company_profile_picture;
      else this.decodedBase64 = "";
    },
    updateCompany() {
      this.loading = true;
      let requestBody = {
        owner_name: this.owners_name,
        company_email: this.data.company_email,
        company_name: this.company_name,
        company_phone_number: this.phone_number,
        city: this.city,
        state: this.state,
        //gas_plant_type: this.plant,
        address: this.address,
        password: this.password,
        update_able: this.update,
        attachment: this.decodedBase64.replace("data:image/jpeg;base64,", ""),
      };
      if (this.loggedinUser.is_super_admin)
        requestBody.permissions = this.loggedinUser.permissions;
      RequestService.post("company/create", requestBody)
        .then((res) => {
          if (res.data.status == 201) {
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Company data updated successfully";
            this.loading = false;
            localStorage.setItem("user", JSON.stringify(res.data.response));
            location.reload();
            //setTimeout(() => {
            //  this.$router.push("/customers");
            //}, 1000);
          }
        })
        .catch(() => {
          //this.snackbar = true;
          //this.snackbarColor = "red";
          //this.snacbarMessage = " Something went wrong";
          this.loading = false;
          //setTimeout(() => {
          //  this.$router.go(-1);
          //}, 1000);
        });
    },

    onFileChange() {
      let file_size = document.querySelector("input[type=file]").files[0].size;
      this.validFileSize = true;
      let fileBase64;
      if (file_size > 2097152) {
        this.validFileSize = false;
      }
      if (!this.validFileSize) {
        this.snackbar = true;
        this.snackbarColor = "red";
        this.snacbarMessage = " File size should not be greater then 2 MB";
        this.loading = false;
        this.files = [];
      } else {
        let that = this;
        const file = document.querySelector("input[type=file]").files[0];
        const reader = new FileReader();
        reader.addEventListener(
          "load",
          function () {
            fileBase64 = reader.result; //extract file type
            let i = file.name.lastIndexOf(".");
            let fileType;
            if (i > 0) {
              fileType = file.name.substring(i + 1);
            }
            if (fileType == "jpg") {
              fileType = "jpeg";
            }
            if (fileType == "PNG") {
              fileType = "png";
            }
            //that.decodedBase64 = fileBase64
            that.decodedBase64 = fileBase64.replace(
              "data:image/" + fileType + ";base64,",
              "data:image/jpeg;base64,"
            );
            event.target.value = null;
          },
          false
        );
        if (file) {
          reader.readAsDataURL(file);
        }
      }
    },
  },
};
</script>
<style scoped>
.fonts {
  font-size: 12px;
}

.pointer {
  cursor: pointer;
}
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
  width: 85%;
  border-color: #d6d6d6;
  border-radius: 8px;
}
.city-feild {
  width: 150px;
  border-color: #d6d6d6;
  border-radius: 8px;
}
.password-feild {
  width: 85%;
  border-color: #d6d6d6;
  border-radius: 8px;
}
.btn-create {
  /*background-color: #464646 !important;
  color: #fff;
  min-width: 400px !important;
  border-radius: 8px !important;
  cursor: pointer;*/
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 300px !important;
  border-radius: 20px !important;
  cursor: pointer;
  margin-left: 2rem;
}
</style>
