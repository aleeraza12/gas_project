<template>
  <div class="main-container">
    <div class="d-flex align-start justify-start">
      <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
    </div>
    <div class="mt-3">
      <div class="d-flex align-start justify-start"><b>New Customer</b></div>
      <div class="d-flex align-start justify-start fonts mt-1">
        Enter the following details to create a customer profile
      </div>
      <v-form v-model="valid" class="mt-5">
        <div>
          <v-text-field
            v-model="name"
            label="Enter Name"
            placeholder="Enter Name"
            outlined
            :rules="nameRules"
            dense
            hide-details
            class="mt-1"
            style="width: 300px"
          ></v-text-field>
        </div>
        <div>
          <v-text-field
            v-model="phone_number"
            :rules="nameRules"
            label="Enter Phone Number"
            placeholder="Enter Phone Number"
            outlined
            dense
            hide-details
            class="mt-1"
            style="width: 300px"
          ></v-text-field>
        </div>
        <div>
          <v-text-field
            v-model="email"
            label="Enter Email Address"
            :rules="nameRules"
            placeholder="Enter Email Address"
            outlined
            dense
            hide-details
            class="mt-1"
            style="width: 300px"
          ></v-text-field>
        </div>
        <div>
          <v-text-field
            v-model="address"
            label="Enter Street"
            :rules="nameRules"
            placeholder="Enter Street"
            outlined
            dense
            hide-details
            class="mt-1"
            style="width: 300px"
          ></v-text-field>
        </div>
        <div class="d-flex" style="width: 300px">
          <div>
            <v-text-field
              label="City"
              outlined
              :rules="nameRules"
              dense
              placeholder="Enter City"
              hide-details
              class="city-feild mt-2 mr-3"
              v-model="city"
            ></v-text-field>
          </div>
          <div class="mt-2">
            <v-select
              :items="states"
              :rules="nameRules"
              label="State"
              placeholder="Enter State"
              outlined
              small
              dense
              v-model="state"
              hide-details
            >
            </v-select>
          </div>
        </div>

        <div class="mt-3" style="width: 300px">
          <v-select
            :items="customer_types"
            v-model="customer_type"
            label="Customer Type"
            :rules="nameRules"
            placeholder="Select One"
            outlined
            hide-details
            small
            dense
          >
          </v-select>
        </div>
        <div class="mt-5 mb-5">
          <v-btn
            block
            large
            class="elevation-0 btn-create"
            :disabled="!valid"
            :loading="loading"
            @click="createCustomer()"
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
export default {
  data: () => ({
    nameRules: [(v) => !!v || "This field is required"],
    states: ["Foo", "Bar", "Fizz", "Buzz"],
    customer_types: ["Distributor", "Retailer"],
    name: "",
    email: "",
    phone_number: "",
    city: "",
    state: "",
    customer_type: "",
    address: "",
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    loading: false,
    valid: false,
  }),
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    //...mapGetters(["getAdminInfo"]),
  },
  methods: {
    createCustomer() {
      let requestBody = {
        name: this.name,
        email: this.email,
        phone_number: this.phone_number,
        city: this.city,
        state: this.state,
        customer_type: this.customer_type,
        address: this.address,
      };
      console.log(requestBody);
      RequestService.post("customer/create", requestBody)
        .then((res) => {
          console.log("status in customer", res.data.status);
          if (res.data.status == 201) {
            console.log("this is inside");
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your customer(s) added successfully";
            this.loading = false;
          }
        })
        .catch(() => {
          this.snackbar = true;
          this.snackbarColor = "red";
          this.snacbarMessage = " Something went wrong";
          this.loading = false;
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
</style>
