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
        <div class="mt-10 ml-3 d-flex align-start justify-start">
          <b>Sales Recepit Form</b>
        </div>
        <div class="mt-2 ml-3 d-flex align-start justify-start">
          Enter the following details to cretae Recepit
        </div>
        <div style="width: 400px" class="pa-8 mt-10">
          <v-form v-model="valid">
            <div>
              <v-select
                :items="getAllCustomerTypes"
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
                class="username-feild mt-5"
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
                class="username-feild mt-5"
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
                  class="city-feild mt-5 mr-3"
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
                  class="city-feild mt-5"
                  v-model="total_amount"
                ></v-text-field>
              </div>
            </div>
            <div class="mt-5">
              <v-select
                v-model="payment_mode"
                :items="getAllPaymentModes"
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
                class="elevation-0 btn-create mt-10"
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
            height: 250px;
            width: 300px;
            background-color: #ebebea;
            margin-top: 13rem;
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
                @click="addPromo()"
                :disabled="!valid1"
                :loading="loading1"
                class="elevation-0 btn-create-1"
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
import { eventBus } from "@/main";
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
    customer_type: "",
    discount_code: "",
    payment_mode: "",
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    loading: false,
    loading1: false,
    status: "unpaid",
    sale_id: null,
    emitData: "",
    loggedinUser: JSON.parse(localStorage.getItem("user")),
  }),
  components: {},
  created() {
    eventBus.$on("updateSale", (data) => {
      this.assembleData(data);
      this.emitData = data;
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
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters([
      "getCustomers",
      "getAllPaymentModes",
      "getAllCustomerTypes",
    ]),
  },
  mounted() {
    this.$store.dispatch("getCustomersListing");
    this.$store.dispatch("getPaymentMethods");
    this.$store.dispatch("getCustomerTypes");
  },
  watch: {
    getCustomers() {
      console.log(this.getCustomers);
      for (let j = 0; j < this.getCustomers.length; j++) {
        let customer = {
          name: this.getCustomers[j].name,
          id: this.getCustomers[j].id,
        };
        this.customer_names.push(customer);
      }
      let updateAblecustomer = {
        name: this.emitData.customer_name,
        id: this.emitData.customer_id,
      };
      this.customer_name = updateAblecustomer;
    },
  },
  methods: {
    assembleData(data) {
      this.gas_quantity = data.gas_quantity;
      this.total_amount = data.total_amount;
      this.price = data.price;
      this.customer_id = data.customer_id;
      this.state = data.state;
      this.customer_type = data.customer_type;
      this.customer_phone_number = data.customer_phone_number;
      this.discount_code = data.discount_code;
      this.payment_mode = data.payment_mode;
      this.sale_id = data.id;
    },
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
        sale_id: this.sale_id,
        users_id: this.loggedinUser.id,
      };
      console.log(requestBody);
      let apiName = "";
      this.sale_id == null
        ? (apiName = "sale/create")
        : (apiName = "sale/update");
      RequestService.post(apiName, requestBody)
        .then((res) => {
          console.log("status in purchase", res.data.status);
          if (res.data.status == 201) {
            this.snacbarMessage = "Your sale(s) added successfully";
          } else if (res.data.status == 200) {
            this.snacbarMessage = "Your sale(s) updated successfully";
          }
          this.snackbar = true;
          this.snackbarColor = "success";
          this.loading = false;
          setTimeout(() => {
            this.$router.push("/sales");
          }, 1000);
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
.btn-create {
  background-color: #464646 !important;
  color: #fff;
  min-width: 230px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
.btn-create-1 {
  background-color: #464646 !important;
  color: #fff;
  min-width: 200px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>
