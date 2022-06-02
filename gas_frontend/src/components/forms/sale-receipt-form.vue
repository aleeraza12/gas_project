<template>
  <div class="main-container">
    <div class="d-flex">
      <div>
        <div
          class="d-flex align-start justify-start"
          @click="goToSalesListingPage()"
        >
          <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
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
                hide-details
              ></v-select>
            </div>
            <div>
              <!--<v-text-field
                label="Customer Name"
                v-model="customer_name"
                outlined
                dense
                :rules="nameRules"
                placeholder="Enter Customer Name"
                hide-details
                class="username-feild mt-3"
              ></v-text-field>-->
              <v-select
                :items="
                  Object.keys(customer_names).map((key) => ({
                    text: customer_names[key].name,
                    value: customer_names[key],
                  }))
                "
                label="Customer Name"
                v-model="customer_name"
                :rules="nameRules"
                outlined
                class="username-feild mt-3"
                dense
                small
                hide-details
              ></v-select>
            </div>
            <div>
              <v-text-field
                label="Phone Number"
                outlined
                dense
                placeholder="Enter Phone Number"
                hide-details
                class="username-feild mt-3"
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
                class="username-feild mt-3"
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
                  class="city-feild mt-3 mr-3"
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
                  class="city-feild mt-3"
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
                hide-details
              ></v-select>
            </div>
            <div class="">
              <v-btn
                class="elevation-0 btn-create mt-3"
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
          <v-form v-model="valid1">
            <div class="pa-2">
              <v-text-field
                label="Enter Discount code"
                outlined
                dense
                placeholder="Enter Discount Code"
                hide-details
                class="username-feild mt-10"
                v-model="discount_code"
                :rules="nameRules"
              ></v-text-field>
            </div>
            <div class="mt-5">
              <v-btn
                small
                class="elevation-0 btn-create"
                @click="addPromo()"
                :disabled="!valid1"
                :loading="loading1"
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
import { mapGetters } from "vuex";
export default {
  data: () => ({
    valid: false,
    valid1: false,
    show: false,
    show1: false,
    gas_quantity: "",
    price: "",
    nameRules: [(v) => !!v || "This field is required"],
    total_amount: "",
    customer_name: "",
    customer_names: [],
    customer_phone_number: "",
    customer_types: ["Distributor", "Retailer"],
    payment_modes: ["Cash", "Prepaid"],
    customer_type: "",
    discount_code: "",
    payment_mode: "",
    status: "",
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    loading: false,
    loading1: false,
    status:"unpaid"
  }),
  components: {},
  created() {},
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getCustomers"]),
  },
  mounted() {
    this.$store.dispatch("getCustomersListing");
  },
  watch: {
    getCustomers() {
      //for (let m = 0; m < this.getCustomers.length; m++)
      this.customer_names = this.getCustomers;
    },
  },
  methods: {
    addPromo() {
      this.snackbar = true;
      this.snackbarColor = "success";
      this.snacbarMessage = "Your promo(s) will be added with your sales";
    },
    goToSalesListingPage() {
      this.$router.go(-1);
    },
    createSale() {
      this.loading = true;
      let requestBody = {
        gas_quantity: this.gas_quantity,
        total_amount: this.total_amount,
        price: this.price,
        customer_id: this.customer_name.id,
        customer_type: this.customer_type,
        customer_phone_number: this.customer_phone_number,
        discount_code: this.discount_code,
        payment_mode: this.payment_mode,
        status: this.status,
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
            setTimeout(() => {
              this.$router.push("/sales");
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
.btn-create {
  background-color: #464646 !important;
  color: #fff;
  min-width: 230px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>
