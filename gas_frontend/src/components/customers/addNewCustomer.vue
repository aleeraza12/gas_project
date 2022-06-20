<template>
  <div class="main-container">
    <div
      @click="goToCustomerListings()"
      class="d-flex align-start justify-start pointer"
    >
      <v-icon>mdi-chevron-left</v-icon>
      <span>Back</span>
    </div>
    <div class="mt-3">
      <div class="d-flex align-start justify-start">
        <b>{{ customerText }} Customer</b>
      </div>
      <div class="d-flex align-start justify-start fonts mt-1">
        <div class="mt-6">
          <div class="d-flex align-start justify-start">
            <b>New Customer</b>
          </div>
          <div class="d-flex align-start justify-start fonts mt-6">
            Enter the following details to create a customer profile
          </div>
          <v-form v-model="valid" class="mt-6">
            <div>
              <v-text-field
                v-model="name"
                label="Enter Name"
                placeholder="Enter Name"
                outlined
                :rules="nameRules"
                dense
                hide-details
                class="mt-6"
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
                class="mt-6"
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
                class="mt-6"
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
                class="mt-6"
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
                  class="city-feild mt-6 mr-3"
                  v-model="city"
                ></v-text-field>
              </div>
              <div class="mt-6">
                <v-select
                  :items="getAllStates"
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

            <div class="mt-6" style="width: 300px">
              <v-select
                :items="getAllCustomerTypes"
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
            <div class="mt-6 mb-5">
              <v-btn
                block
                large
                class="elevation-0 btn-create"
                :loading="loading"
                @click="createCustomer()"
                :disabled="!valid"
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
          class="mt-6"
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
    </div>
  </div>
</template>
<script>
import RequestService from "../../RequestService";
import { eventBus } from "@/main";
import { mapGetters } from "vuex";
export default {
  data: () => ({
    nameRules: [(v) => !!v || "This field is required"],
    name: "",
    email: "",
    phone_number: "",
    customerText: "New",
    city: "",
    state: "",
    customer_type: "",
    customer_id: null,
    address: "",
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    loading: false,
    valid: false,
    company_id: null,
  }),
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getAllCustomerTypes", "getAllStates"]),
  },
  created() {
    eventBus.$on("updateCustomer", (data) => {
      this.assembleData(data);
    });
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
    this.$store.dispatch("getCustomerTypes");
    this.$store.dispatch("getAllStates");
  },
  methods: {
    goToCustomerListings() {
      this.$router.go(-1);
    },
    assembleData(data) {
      this.name = data.name;
      this.email = data.email;
      this.phone_number = data.phone_number;
      this.city = data.city;
      this.state = data.state;
      this.customer_type = data.customer_type;
      this.address = data.address;
      this.customer_id = data.id;
      this.customerText = "Update";
      this.company_id = data.company_id;
    },
    createCustomer() {
      this.loading = true;
      let requestBody = {
        name: this.name,
        email: this.email,
        phone_number: this.phone_number,
        city: this.city,
        state: this.state,
        customer_type: this.customer_type,
        address: this.address,
        customer_id: this.customer_id,
      };
      if (this.company_id != null) {
        requestBody.company_id = this.company_id;
      }
      console.log(requestBody);
      RequestService.post("customer/create", requestBody)
        .then((res) => {
          console.log("status in customer", res.data.status);
          if (res.data.status == 201) {
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your customer(s) added successfully";
            this.loading = false;
            setTimeout(() => {
              this.$router.push("/customers");
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
  /*background-color: #464646 !important;
  color: #fff;
  min-width: 300px !important;
  border-radius: 8px !important;
  cursor: pointer;*/
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 300px !important;
  border-radius: 20px !important;
  cursor: pointer;
  /*margin-right: 8rem;*/
}
.pointer {
  cursor: pointer;
}
</style>
