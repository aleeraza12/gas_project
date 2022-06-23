<template>
  <div class="main-container">
    <div class="d-flex">
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
            <div v-if="loggedinUser.company_email == 'superadmin@gmail.com'">
              <v-select
                :items="
                  Object.keys(company_names).map((key) => ({
                    text: company_names[key].name,
                    value: company_names[key],
                  }))
                "
                label="Select one company for purchase"
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
              <!--<v-select
                :items="
                  Object.keys(promo_names).map((key) => ({
                    text: promo_names[key].name,
                    value: promo_names[key],
                  }))
                "
                label="Enter Discount Code"
                v-model="discount_code"
                :rules="nameRules"
                outlined
                class="username-feild mt-3"
                dense
                small
                hide-details
              ></v-select>-->
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
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import axios from "axios";
import RequestService from "../../RequestService";
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
    promo_names: [],
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
    updateable: false,
    company_id: null,
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
    emitData: "",
    company_names: [],
    setDefaultPrice: true,
    company_name: "",
    loggedinUser: JSON.parse(localStorage.getItem("user")),
  }),
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
    if (this.loggedinUser.company_email !== "superadmin@gmail.com") {
      this.$store.dispatch("getCustomersListing", requestBody);
      //this.$store.dispatch("getPromosListing", requestBody);
    }
    this.$store.dispatch("getPaymentMethods");
    this.$store.dispatch("getCustomerTypes");
    setTimeout(() => {
      if (!this.updateable) this.$store.dispatch("getCurrentPrice");
    }, 1000);
    //if super admn wants to create sale than we get companes to assign a sale to specific company
    if (this.loggedinUser.company_email == "superadmin@gmail.com") {
      let requestBody = {
        start_date: this.start_date,
        end_date: this.end_date.concat(" 23:59:00"),
      };
      this.$store.dispatch("getCompaniesListing", requestBody);
    }
  },
  watch: {
    customer_name(value) {
      console.log("customer name selected", value);
      if (value.name != undefined && this.setDefaultPrice) {
        for (let j = 0; j < this.getCustomers.length; j++) {
          if (this.getCustomers[j].id == value.id)
            this.customer_phone_number = this.getCustomers[j].phone_number;
        }
      }
    },
    getPrice() {
      console.log("watcher called");
      this.price = this.getPrice
        ? this.getPrice.price_per_twenty_million_ton
        : this.price;
    },
    gas_quantity() {
      if (this.setDefaultPrice)
        this.total_amount = this.gas_quantity * this.price;
    },
    price() {
      if (this.setDefaultPrice)
        this.total_amount = this.gas_quantity * this.price;
    },
    company_name() {
      if (this.loggedinUser.company_email == "superadmin@gmail.com") {
        this.getCompanyCustomers(this.company_name.id);
        //this.getCompanyPromos(this.company_name.id);
      } else console.log(this.company_name);
    },
    //getPromos() {
    //  console.log("get promo watcher called", this.emitData);
    //  this.promo_names = [];
    //  for (let j = 0; j < this.getPromos.length; j++) {
    //    let promo = {
    //      name: this.getPromos[j].promo_name,
    //      id: this.getPromos[j].id,
    //    };
    //    this.promo_names.push(promo);
    //  }
    //  let updateAblePromo = {
    //    name: this.emitData.discount_code,
    //    id: this.emitData.promo_id,
    //  };
    //  this.discount_code = updateAblePromo;
    //},
    getCompanies() {
      this.customer_names = [];
      for (let j = 0; j < this.getCompanies.length; j++) {
        console.log(this.getCompanies[j].company_name);
        let company = {
          name: this.getCompanies[j].company_name,
          id: this.getCompanies[j].id,
        };
        this.company_names.push(company);
      }
      console.log(this.emitData, "emtdata");
      let updateAblecompany = {
        name: this.emitData.updated_by,
        id: this.emitData.company_id,
      };
      this.company_name = updateAblecompany;
    },
    getCustomers() {
      console.log("efqwepruqepqppqef", this.emitData);
      this.customer_names = [];
      for (let j = 0; j < this.getCustomers.length; j++) {
        let customer = {
          name: this.getCustomers[j].name,
          id: this.getCustomers[j].id,
          //phone_number: this.getCustomers[j].phone_number,
        };
        this.customer_names.push(customer);
      }
      //if(this.emitData)
      let updateAblecustomer = {
        name: this.emitData.customer_name,
        id: this.emitData.customer_id,
        //phone_number: this.emitData.customer_phone_number,
      };
      this.customer_name = updateAblecustomer;
    },
  },
  methods: {
    getCompanyCustomers(id) {
      console.log("id", id);

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
      customAxios;
      customAxios
        .post(url + "customer/read_all", requestBody)
        .then((response) => {
          console.log("response customer", response.data.response);
          this.customer_names = [];
          for (let j = 0; j < response.data.response.length; j++) {
            let customer = {
              name: response.data.response[j].name,
              id: response.data.response[j].id,
            };
            this.customer_names.push(customer);
          }
        });
    },

    getCompanyPromos(id) {
      console.log("id", id);

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
      customAxios;
      customAxios.post(url + "promo/read_all", requestBody).then((response) => {
        console.log("response promo", response.data.response);
        this.promo_names = [];
        for (let j = 0; j < response.data.response.length; j++) {
          let promo = {
            name: response.data.response[j].promo_name,
            id: response.data.response[j].id,
          };
          this.promo_names.push(promo);
        }
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
      this.discount_code = data.discount_code;
      this.payment_mode = data.payment_mode;
      this.sale_id = data.id;
      this.company_id = data.company_id;
      let requestBody = {
        start_date: this.start_date,
        end_date: this.end_date.concat(" 23:59:00"),
      };
      if (this.loggedinUser.company_email == "superadmin@gmail.com") {
        this.$store.dispatch("getCustomersListing", requestBody);
        //this.$store.dispatch("getPromosListing", requestBody);
      }
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
        users_id:
          "user_id" in this.loggedinUser
            ? this.loggedinUser.user_id
            : this.loggedinUser.id,
      };
      if (
        this.company_id != null &&
        this.loggedinUser.company_email !== "superadmin@gmail.com"
      ) {
        requestBody.company_id = this.company_id;
      }
      if (
        this.company_name !== "" &&
        this.loggedinUser.company_email == "superadmin@gmail.com"
      ) {
        requestBody.company_id = this.company_name.id;
      }
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
            this.snackbarColor = "success";
          } else if (res.data.status == 200) {
            this.snacbarMessage = "Your sale(s) updated successfully";
            this.snackbarColor = "success";
          } else if (res.data.status == 400) {
            this.snacbarMessage = "Invalid promo";
            this.snackbarColor = "red";
          }
          this.snackbar = true;
          this.loading = false;
          if (res.data.status !== 400) {
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
