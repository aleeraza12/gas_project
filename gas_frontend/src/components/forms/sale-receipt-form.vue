<template>
  <div class="main-container">
    <div class="d-flex">
      <v-row>
        <v-col md="6" lg="6" sm="12">
          <div>
            <div
              class="d-flex align-start justify-start"
              @click="goToSalesListingPage()"
            >
              <v-icon color="#2e3995">mdi-chevron-left</v-icon>
              <span style="color: #2e3995">Back</span>
            </div>
            <div class="mt-10 ml-3 d-flex align-start justify-start">
              <b>Sales Recepit Form</b>
            </div>
            <div class="mt-2 ml-3 d-flex align-start justify-start">
              Enter the following details to create Recepit
            </div>
            <div style="width: 400px" class="pa-8 mt-10">
              <v-form v-model="valid">
                <div>
                  <v-select
                    :items="getAllCustomerTypes"
                    v-model="customer_type"
                    label="Customer Type"
                    v-on:change="getPriceForCustomer"
                    :rules="nameRules"
                    outlined
                    dense
                    small
                    hide-details
                  ></v-select>
                </div>
                <div v-if="loggedinUser.is_super_admin">
                  <v-select
                    :items="
                      Object.keys(company_names).map((key) => ({
                        text: company_names[key].name,
                        value: company_names[key],
                      }))
                    "
                    label="Select one company for sale"
                    v-model="company_name"
                    :rules="nameRules"
                    outlined
                    class="username-feild mt-3"
                    dense
                    small
                    hide-details
                  ></v-select>
                </div>
                <div>
                  <v-autocomplete
                    :items="
                      Object.keys(customer_names).map((key) => ({
                        text: customer_names[key].name,
                        value: customer_names[key],
                      }))
                    "
                    label="Search Customer Name"
                    v-model="customer_name"
                    :rules="nameRules"
                    outlined
                    class="username-feild mt-3"
                    dense
                    small
                    :search-input.sync="search"
                    hide-details
                  ></v-autocomplete>
                </div>
                <div class="d-flex align-end justify-end mt-2">
                  <v-btn small dense outlined @click="setModal()"
                    >Add Customer
                    <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
                  >
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
                <div
                  class="d-flex"
                  v-if="payment_mode == 'Credit' || payment_mode == 'credit'"
                >
                  <div>
                    <v-text-field
                      label="Amount Paid"
                      :rules="
                        payment_mode == 'Credit' || payment_mode == 'credit'
                          ? []
                          : nameRules
                      "
                      outlined
                      dense
                      placeholder="Enter amount being paid"
                      hide-details
                      class="city-feild mt-5 mr-3"
                      v-model="amount_being_paid"
                    ></v-text-field>
                  </div>
                  <div>
                    <v-text-field
                      label="Balance"
                      outlined
                      :rules="
                        payment_mode == 'Credit' || payment_mode == 'credit'
                          ? []
                          : nameRules
                      "
                      dense
                      placeholder="Enter balance"
                      hide-details
                      class="city-feild mt-5"
                      v-model="balance"
                    ></v-text-field>
                  </div>
                </div>
                <div class="">
                  <v-btn
                    class="elevation-0 btn-create mt-10 text-capitalize"
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
        </v-col>
        <v-col md="6" lg="6" sm="12">
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
                    class="elevation-0 btn-create-1 text-capitalize"
                    dense
                  >
                    Apply
                  </v-btn>
                </div>
              </v-form>
            </div>
          </div>
        </v-col>
      </v-row>
    </div>

    <v-dialog v-model="isModal" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h5 text-center align-center display-center">
          Add Customer
        </v-card-title>
        <v-form v-model="valid2" class="mt-6 ml-5">
          <div>
            <v-text-field
              v-model="name"
              label="Enter Name"
              placeholder="Enter Name"
              outlined
              :rules="nameRules"
              dense
              hide-details
              class="mt-2"
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
              class="mt-2"
              style="width: 300px"
            ></v-text-field>
          </div>
          <div>
            <v-text-field
              v-model="email"
              label="Enter Email Address (optional)"
              placeholder="Enter Email Address (optional)"
              outlined
              dense
              hide-details
              class="mt-2"
              style="width: 300px"
            ></v-text-field>
          </div>
          <div>
            <v-text-field
              v-model="address"
              label="Enter Street (optional)"
              placeholder="Enter Street (optional)"
              outlined
              dense
              hide-details
              class="mt-2"
              style="width: 300px"
            ></v-text-field>
          </div>
          <div style="width: 300px">
            <div>
              <v-text-field
                label="City (optional)"
                outlined
                dense
                placeholder="Enter City (optional)"
                hide-details
                class="city-feild mt-2"
                v-model="city"
              ></v-text-field>
            </div>
            <div class="mt-2">
              <v-select
                :items="getAllStates"
                label="State (optional)"
                placeholder="Enter State (optional)"
                outlined
                small
                dense
                v-model="state"
                hide-details
              >
              </v-select>
            </div>
          </div>

          <div class="mt-2" style="width: 300px">
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
        </v-form>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="black" small text @click="isModal = false">
            Cancel
          </v-btn>
          <v-btn
            small
            color="green darken-1"
            text
            @click="createCustomer()"
            :disabled="!valid2"
            :loading="loading2"
          >
            Add
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

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
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import axios from "axios";
import RequestService from "../../RequestService";
export default {
  data() {
    return {
      valid: false,
      valid1: false,
      valid2: false,
      show: false,
      search: null,
      show1: false,
      gas_quantity: "",
      amount_being_paid: 0,
      balance: 0,
      price: "",
      nameRules: [(v) => !!v || "This field is required"],
      total_amount: "",
      customer_name: "",
      customer_names: [],
      promo_names: [],
      isModal: false,
      customer_phone_number: "",
      customer_type: "",
      discount_code: "",
      payment_mode: "",
      snacbarMessage: "",
      snackbar: false,
      snackbarColor: "",
      loading: false,
      loading1: false,
      loading2: false,
      status: "unpaid",
      sale_id: null,
      updateable: false,
      company_id: null,
      start_date: "2022-01-01",
      end_date: new Date().toISOString().substr(0, 10),
      emitData: "",
      company_names: [],
      setDefaultPrice: true,
      company_name: "",
      loggedinUser: JSON.parse(localStorage.getItem("user")),
      previous_customer_id: "",
      previous_customer_number: "",
    };
  },
  components: {},
  created() {
    eventBus.$on("updateSale", (data) => {
      this.assembleData(data);
      this.emitData = data;
      this.updateable = true;
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
      "getPrice",
      "getCompanies",
    ]),
  },
  mounted() {
    let requestBody = {
      start_date: this.start_date,
      end_date: this.end_date.concat(" 23:59:00"),
    };
    //this is bcz we want only company user for creating sale
    if (!this.loggedinUser.is_super_admin) {
      this.$store.dispatch("getCustomersListing", requestBody);
    }
    this.$store.dispatch("getPaymentMethods");
    this.$store.dispatch("getCustomerTypes");
    setTimeout(() => {
      if (!this.updateable) this.$store.dispatch("getCurrentPrice");
    }, 1000);
    //if super admn wants to create sale than we get companes to assign a sale to specific company
    if (this.loggedinUser.is_super_admin) {
      let requestBody = {
        start_date: this.start_date,
        end_date: this.end_date.concat(" 23:59:00"),
      };
      this.$store.dispatch("getCompaniesListing", requestBody);
    }
  },
  watch: {
    customer_name(value) {
      if (value.name != undefined) {
        for (let j = 0; j < this.getCustomers.length; j++) {
          if (this.getCustomers[j].id == value.id) {
            if (this.getCustomers[j].id == this.previous_customer_id)
              this.customer_phone_number = this.previous_customer_number;
            else this.customer_phone_number = this.getCustomers[j].phone_number;
          }
        }
      }
    },
    gas_quantity() {
      if (this.setDefaultPrice)
        this.total_amount = this.gas_quantity * this.price;
    },
    price() {
      if (this.setDefaultPrice)
        this.total_amount = this.gas_quantity * this.price;
    },
    company_name(val) {
      if (val.name != undefined) {
        if (this.loggedinUser.is_super_admin) {
          this.getCompanyCustomers(this.company_name.id);
        }
      }
    },
    getCompanies() {
      this.customer_names = [];
      for (let j = 0; j < this.getCompanies.length; j++) {
        let company = {
          name: this.getCompanies[j].company_name,
          id: this.getCompanies[j].id,
        };
        this.company_names.push(company);
      }
      let updateAblecompany = {
        name: this.emitData.company_name,
        id: this.emitData.company_id,
      };
      this.company_name = updateAblecompany;
    },
    getCustomers() {
      this.customer_names = [];
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
    createCustomer() {
      this.loading2 = true;
      let requestBody = {
        name: this.name,
        phone_number: this.phone_number,
        //city: this.city,
        //state: this.state,
        //email: this.email,
        customer_type: this.customer_type,
        //address: this.address,
        customer_id: this.customer_id,
      };
      if (this.company_id != null) requestBody.company_id = this.company_id;

      if (this.email != "" && this.email !== null)
        requestBody.company_id = this.company_id;

      if (this.state != "" && this.state !== null)
        requestBody.state = this.state;

      if (this.address != "" && this.address !== null)
        requestBody.address = this.address;

      if (this.city != "" && this.city != null) requestBody.city = this.city;
      RequestService.post("customer/create", requestBody)
        .then((res) => {
          if (res.data.status == 201) {
            this.snackbar = true;
            this.snackbarColor = "success";
            this.snacbarMessage = "Your customer(s) added successfully";
            this.loading2 = false;
            this.isModal = false;

            this.$router.go(this.$router.currentRoute);
          }
        })
        .catch(() => {
          //this.snackbar = true;
          //this.snackbarColor = "red";
          //this.snacbarMessage = " Something went wrong";
          this.loading2 = false;
          setTimeout(() => {
            this.$router.go(-1);
          }, 1000);
        });
    },

    setModal() {
      this.isModal = true;
    },

    getPriceForCustomer(type) {
      this.price = "";
      if (type === "Distributor") {
        this.price = this.getPrice.distributor
          ? this.getPrice.distributor.price_per_twenty_million_ton
          : this.price;
      } else if (type === "Retailer") {
        this.price = this.getPrice.retailor
          ? this.getPrice.retailor.price_per_twenty_million_ton
          : this.price;
      } else if (type === "Household User") {
        this.price = this.getPrice.household_user
          ? this.getPrice.household_user.price_per_twenty_million_ton
          : this.price;
      }
    },
    getCompanyCustomers(id) {
      let url = this.$store.state.url;
      let requestBody = {
        company_id: id,
        user_id: this.loggedinUser.id,
        start_date: "2022-01-01",
        end_date: this.end_date.concat(" 23:59:00"),
      };
      let customAxios;
      customAxios = axios.create({
        headers: {
          Token: localStorage.getItem("token"),
        },
      });
      customAxios
        .post(url + "customer/read_all", requestBody)
        .then((response) => {
          this.$store.commit("SET_CUSTOMERS", response.data.response);
        });
    },
    assembleData(data) {
      this.setDefaultPrice = false;
      this.gas_quantity = data.gas_quantity;
      this.total_amount = data.total_amount;
      this.price = data.price;
      this.customer_id = data.customer_id;
      this.state = data.state;
      this.customer_type = data.customer_type;
      this.customer_phone_number = data.customer_phone_number;
      this.previous_customer_id = data.customer_id;
      this.previous_customer_number = data.customer_phone_number;
      this.discount_code = data.discount_code;
      this.payment_mode = data.payment_mode;
      this.amount_being_paid = data.amount_being_paid;
      this.balance = data.balance;
      this.sale_id = data.id;
      this.company_id = data.company_id;
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
        amount_being_paid: this.amount_being_paid,
        balance: this.balance,
        status: this.status,
        sale_id: this.sale_id,
        users_id:
          "user_id" in this.loggedinUser
            ? this.loggedinUser.user_id
            : this.loggedinUser.id,
      };
      if (this.company_id != null && !this.loggedinUser.is_super_admin) {
        requestBody.company_id = this.company_id;
      }
      if (this.company_name !== "" && this.loggedinUser.is_super_admin) {
        requestBody.company_id = this.company_name.id;
      }
      let apiName = "";
      this.sale_id == null
        ? (apiName = "sale/create")
        : (apiName = "sale/update");
      RequestService.post(apiName, requestBody)
        .then((res) => {
          if (res.data.status == 201) {
            this.snacbarMessage = "Your sale(s) added successfully";
            this.snackbarColor = "success";
            console.log("sale data", res.data.response);
            this.$store.commit("SET_VIEW_RECEIPT", res.data.response);
            setTimeout(() => {
              this.$router.push("/sale-invoice");
            }, 1000);
          } else if (res.data.status == 200) {
            this.snacbarMessage = "Your sale(s) updated successfully";
            this.snackbarColor = "success";
          } else if (res.data.status == 400) {
            this.snacbarMessage = "Invalid promo";
            this.snackbarColor = "red";
          }
          this.snackbar = true;
          this.loading = false;
          if (res.data.status == 200 || res.data.status == 400) {
            setTimeout(() => {
              this.$router.push("/sales");
            }, 1000);
          }
        })
        .catch(() => {
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
  min-height: 35px;
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 250px !important;
  border-radius: 20px !important;
  cursor: pointer;
}
.btn-create-1 {
  min-height: 35px;
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 200px !important;
  border-radius: 20px !important;
  cursor: pointer;
}
</style>
