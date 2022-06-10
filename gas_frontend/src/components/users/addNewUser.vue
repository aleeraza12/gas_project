<template>
  <div class="main-container">
    <div
      class="d-flex align-start justify-start pointer"
      @click="goToUserListings()"
    >
      <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
    </div>
    <div class="mt-3">
      <div class="d-flex align-start justify-start">
        <b>{{ userText }} User</b>
      </div>
      <div class="d-flex align-start justify-start fonts mt-1">
        Enter the following details to create a user profile
      </div>
      <v-form v-model="valid" class="mt-5">
        <div>
          <v-text-field
            v-model="created_by"
            label="Created By"
            :rules="nameRules"
            outlined
            disabled
            dense
            hide-details
            class="mt-3"
            style="width: 300px"
          ></v-text-field>
        </div>
        <div>
          <v-text-field
            v-model="name"
            label="Enter User Name"
            :rules="nameRules"
            outlined
            dense
            hide-details
            class="mt-3"
            style="width: 300px"
          ></v-text-field>
        </div>
        <div>
          <v-text-field
            v-model="password"
            label="Enter Password"
            :rules="nameRules"
            outlined
            dense
            hide-details
            class="mt-3"
            style="width: 300px"
          ></v-text-field>
        </div>
        <div>
          <v-text-field
            v-model="designation"
            :rules="nameRules"
            label="Enter Desgination/Role"
            outlined
            dense
            hide-details
            class="mt-3"
            style="width: 300px"
          ></v-text-field>
        </div>
        <div class="mt-3" style="width: 300px">
          <v-select
            :items="statuses"
            :rules="nameRules"
            v-model="status"
            label="Status"
            outlined
            dense
            small
            hide-details
          >
          </v-select>
        </div>
        <div class="mt-3" style="width: 300px">
          <v-select
            :items="getAllUserTypes"
            :rules="nameRules"
            v-model="user_type"
            label="User Type"
            outlined
            hide-details
            small
            dense
          >
          </v-select>
        </div>
        <div class="d-flex justify-start align-start mt-3">
          <b>Access Granted</b>
        </div>
        <div class="d-flex fonts">
          <v-row>
            <v-col cols="9" sm="3" md="3">
              <v-checkbox
                dense
                v-model="permissions"
                label="Dashboard"
                color="black"
                value="Dashboard"
                hide-details
              ></v-checkbox>
              <v-checkbox
                dense
                v-model="permissions"
                label="Sales"
                color="black"
                value="Sales"
                hide-details
              ></v-checkbox>
            </v-col>
            <v-col cols="9" sm="3" md="3">
              <v-checkbox
                dense
                v-model="permissions"
                label="Orders"
                color="black"
                value="Orders"
                hide-details
              ></v-checkbox>
              <v-checkbox
                dense
                v-model="permissions"
                label="Purchases"
                color="black"
                value="Purchases"
                hide-details
              ></v-checkbox>
            </v-col>
            <v-col cols="9" sm="3" md="3">
              <v-checkbox
                dense
                v-model="permissions"
                label="Customers"
                color="black"
                value="Customers"
                hide-details
              ></v-checkbox>
              <v-checkbox
                dense
                v-model="permissions"
                label="Users"
                color="black"
                value="Users"
                hide-details
              ></v-checkbox>
            </v-col>
            <v-col cols="9" sm="" md="3">
              <v-checkbox
                dense
                v-model="permissions"
                label="Wallet"
                color="black"
                value="Wallet"
                hide-details
              ></v-checkbox>
              <v-checkbox
                dense
                v-model="permissions"
                label="Reconciliation"
                color="black"
                value="Reconciliation"
                hide-details
              ></v-checkbox>
            </v-col>
          </v-row>
          <!--<v-radio-group v-model="permission1" row dense>
            <v-radio label="Dashboard" value="Dashboard"></v-radio>
            <v-radio label="Sales" value="Sales"></v-radio>
            <v-radio label="Orders" value="Orders"></v-radio>
            <v-radio label="Purchases" value="Purchases"></v-radio>
          </v-radio-group>-->
        </div>
        <!--<div class="d-flex fonts">
          <v-radio-group v-model="permission2" row dense>
            <v-radio label="Customers" value="Customers"></v-radio>
            <v-radio label="Users" value="Users"></v-radio>
            <v-radio label="Wallet" value="Wallet"></v-radio>
            <v-radio label="Reconciliation" value="Reconciliation"></v-radio>
          </v-radio-group>
        </div>-->
        <div class="mt-5 mb-5 ml-16">
          <v-btn
            block
            large
            class="elevation-0 btn-create"
            :loading="loading"
            :disabled="!valid"
            @click="createUser()"
            dense
          >
            Save
          </v-btn>
        </div>
      </v-form>
    </div>
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
      {{ snacbarMessage }}
    </v-snackbar>
  </div>
</template>
<script>
import RequestService from "../../RequestService";
import { eventBus } from "@/main";
import { mapGetters } from "vuex";
export default {
  data: () => ({
    statuses: ["Active", "Inactive"],
    nameRules: [(v) => !!v || "This field is required"],
    user_type: "",
    designation: "",
    loggedInUser: JSON.parse(localStorage.getItem("user")),
    name: "",
    created_by: "",
    userText: "Add New",
    users_id: null,
    phone_number: "",
    status: "",
    customer_type: "",
    password: "",
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    loading: false,
    valid: false,
    permissions: [],
  }),
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getAllUserTypes"]),
  },
  created() {
    eventBus.$on("updateUser", (data) => {
      console.log("emt receved", data);
      this.assembleData(data);
    });
    eventBus.$on("validationFailed", (err) => {
      console.log("emt receved");
      this.snackbar = true;
      this.snackbarColor = "red";
      let errorArray = [];
      for (let item in err.response.data.errors) {
        errorArray.push(item);
      }
      let error = err.response.data.errors[errorArray[0]];
      console.log(error);
      this.snacbarMessage = error[0];
    });
  },
  mounted() {
    this.$store.dispatch("getUserTypes");
    this.created_by = this.loggedInUser.company_name;
  },
  methods: {
    assembleData(data) {
      this.name = data.name;
      this.created_by = data.created_by;
      this.user_type = data.user_type;
      //this.password = data.password;
      this.designation = data.designation;
      this.status = data.status;
      this.permissions = data.permissions;
      this.users_id = data.id;
      this.userText = "Update";
    },
    goToUserListings() {
      this.$router.go(-1);
    },
    createUser() {
      this.loading = true;
      let requestBody = {
        name: this.name,
        created_by: this.created_by,
        user_type: this.user_type,
        password: this.password,
        designation: this.designation,
        status: this.status,
        permissions: this.permissions,
        users_id: this.users_id,
      };
      console.log(requestBody);
      RequestService.post("user/create", requestBody)
        .then((res) => {
          console.log("status in user", res.data.status);
          if (res.data.status == 201) {
            console.log("this is inside");
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "New user(s) added successfully";
            this.loading = false;
            setTimeout(() => {
              this.$router.push("/users");
            }, 1000);
          }
        })
        .catch(() => {
          //this.snackbar = true;
          //this.snackbarColor = "red";
          //this.snacbarMessage = " Something went wrong";
          this.loading = false;
          setTimeout(() => {
            this.$router.go(-1);
          }, 1000);
        });
    },
  },
};
</script>
<style scoped>
.fonts {
  font-size: 12px;
}
.btn-create {
  background-color: #464646 !important;
  color: #fff;
  min-width: 300px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
.pointer {
  cursor: pointer;
}
</style>
