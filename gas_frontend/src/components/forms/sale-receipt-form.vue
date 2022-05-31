<template>
  <div class="main-container">
    <div class="d-flex">
      <div>
        <div class="mt-4 ml-3 d-flex align-start justify-start">
          <v-btn small dense outlined> back</v-btn>
        </div>
        <div class="mt-5 ml-3 d-flex align-start justify-start">
          <b>Sales Recepit Form</b>
        </div>
        <div class="mt-2 ml-3 d-flex align-start justify-start">
          Enter the following details to cretae Recepit
        </div>
        <div style="width: 400px" class="pa-8">
          <v-form v-model="valid">
            <div>
              <v-select
                :items="customer_types"
                v-model="customer_type"
                label="Customer Type"
                :rules="nameRules"
                outlined
                dense
                small
              ></v-select>
            </div>
            <div>
              <v-text-field
                label="Customer Name"
                v-model="customer_name"
                outlined
                dense
                :rules="nameRules"
                placeholder="Enter Customer Name"
                hide-details
                class="username-feild"
              ></v-text-field>
            </div>
            <div>
              <v-text-field
                label="Phone Number"
                outlined
                dense
                placeholder="Enter Phone Number"
                hide-details
                class="username-feild mt-2"
                :rules="nameRules"
                v-model="customer_phone_number"
              ></v-text-field>
            </div>
            <div>
              <v-text-field
                label="Enter Price"
                :rules="nameRules"
                outlined
                dense
                placeholder="Enter Price"
                hide-details
                class="username-feild mt-2"
                v-model="price"
              ></v-text-field>
            </div>
            <div class="d-flex">
              <div>
                <v-text-field
                  label="Gas Quantity"
                  :rules="nameRules"
                  outlined
                  dense
                  placeholder="Enter Gas Quantity"
                  hide-details
                  class="city-feild mt-2 mr-3"
                  v-model="gas_quantity"
                ></v-text-field>
              </div>
              <div>
                <v-text-field
                  label="Total Amount"
                  outlined
                  :rules="nameRules"
                  dense
                  placeholder="Enter Amount"
                  hide-details
                  class="city-feild mt-2"
                  v-model="total_amount"
                ></v-text-field>
              </div>
            </div>
            <div class="mt-3">
              <v-select
                :items="payment_modes"
                v-model="payment_mode"
                label="Payment Methods"
                :rules="nameRules"
                outlined
                dense
                small
              ></v-select>
            </div>
            <div class="">
              <v-btn
                class="elevation-0 btn-create"
                @click="createSale()"
                :disabled="!valid"
                :loading="loading"
                dense
              >
                Submit
              </v-btn>
            </div>
          </v-form>
        </div>
      </div>
      <div>
        <div
          style="
            height: 300px;
            width: 300px;
            background-color: #ebebea;
            margin-top: 10rem;
          "
          class="pa-10 ml-16"
        >
          <v-form v-model="valid">
            <div class="pa-2">
              <v-text-field
                label="Enter Discount code"
                outlined
                dense
                placeholder="Enter Discount Code"
                hide-details
                class="username-feild mt-10"
                v-model="discount_code"
              ></v-text-field>
            </div>
            <div class="">
              <v-btn
                small
                class="elevation-0 btn-create"
                @click="createSale()"
                dense
              >
                Submit
              </v-btn>
            </div>
          </v-form>
        </div>
      </div>
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
    valid: false,
    show: false,
    show1: false,
    gas_quantity: "",
    price: "",
    nameRules: [(v) => !!v || "This field is required"],
    total_amount: "",
    customer_name: "",
    customer_phone_number: "",
    customer_types: ["Distributor", "Retailer"],
    payment_modes: ["Cash", "Prepad"],
    customer_type: "",
    discount_code: "",
    payment_mode: "",
    status: "",
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    loading: false,
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
  methods: {
    createSale() {
      this.loading = true;
      let requestBody = {
        gas_quantity: this.gas_quantity,
        total_amount: this.total_amount,
        price: this.price,
        customer_name: this.customer_name,
        customer_type: this.customer_type,
        customer_phone_number: this.customer_phone_number,
        discount_code: this.discount_code,
        payment_mode: this.payment_mode,
      };
      console.log(requestBody);
      RequestService.post("sale/create", requestBody)
        .then((res) => {
          console.log("status in purchase", res.data.status);
          if (res.data.status == 201) {
            console.log("this is inside");
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your sale(s) added successfully";
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
.btn-create {
  background-color: #464646 !important;
  color: #fff;
  min-width: 230px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>
