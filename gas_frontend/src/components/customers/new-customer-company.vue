<template>
  <div class="main-container">
      <v-row>
          <v-col md="6" lg="6" xl="6">
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
  
          </v-col>
           <v-col md="6" lg="6" xl="6">
             <div class="pa-5" style="background-color:#F9F9F8;height:100vh">
          <div class="d-flex justify-start align-start">
                <b>Company Profile</b>
          </div>
          <div class="d-flex justify-center align-center pa-10" style="background-color:#C4C4C4;border-radius: 50%; width:40%;margin-top:5rem;margin-left: 8rem;">
            <v-icon size="80" class="pointer">mdi-image</v-icon
            ><v-icon>mdi-plus</v-icon>
          </div>
          <div class="d-flex justify-center align-center" style="cursor: pointer;margin-top:2rem">
              <b style="text-decoration:underline">Change Image</b>
          </div>
          <div class="d-flex justify-start align-start mt-5 ml-2">
             <div>Owner's Name : </div>
             <div class="ml-5"><b>Chima obi,</b></div>
          </div>
           <div class="d-flex justify-start align-start mt-2 ml-2">
             <div>Company's Name : </div>
             <div class="ml-5"><b>Lit, ENgernies</b></div>
          </div>
           <div class="d-flex justify-start align-start mt-4 ml-2">
             <div>Phone Number : </div>
             <div class="ml-5"><b>093230394940940,</b></div>
          </div>
          <div class="d-flex justify-start align-start mt-2 ml-2">
             <div>Email Address : </div>
             <div class="ml-5"><b>abc@gmail.com</b></div>
          </div>
          <div class="d-flex justify-start align-start mt-2 ml-2">
             <div>Address : </div>
             <div class="ml-16"><b>6, Coker Street, Town, Lagos State</b></div>
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
      console.log("emt receved", data);
      this.assembleData(data);
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
            setTimeout(() => {
              this.$router.push("/customers");
            }, 1000);
          }
        })
        .catch(() => {
          this.snackbar = true;
          this.snackbarColor = "red";
          this.snacbarMessage = " Something went wrong";
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
