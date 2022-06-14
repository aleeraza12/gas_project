<template>
  <div class="main-container">
    <div class="d-flex top-bar pt-2">
      <div class="ml-2">
        <v-text-field
          placeholder="search..."
          outlined
          dense
          prepend-inner-icon="mdi-magnify"
          hide-details
          class="searchbar"
          v-model="search"
        ></v-text-field>
      </div>
      <v-spacer></v-spacer>
      <!--<div class="mr-5 mt-2">
        <v-icon> mdi-bell-outline</v-icon>
      </div>-->
    </div>
    <div class="d-flex mt-2">
      <div>
        <b> Welcome {{ loggedinUser.owner_name }},</b>
      </div>
      <v-spacer></v-spacer>
      <div v-if="loggedinUser.company_email !== 'superadmin@gmail.com'">
        <div style="font-size: 16px; margin-right: 0.5rem">
          Current gas price
        </div>

        <div class="d-flex">
          <v-skeleton-loader
            v-if="priceLoader"
            type="list-item-avatar-three-line"
          ></v-skeleton-loader>
          <div v-else-if="!priceLoader">
            <b style="font-size: 19px" class="ml-16" v-if="getPrice"
              >N{{ getPrice.price_per_twenty_million_ton }}</b
            >
            <b style="font-size: 16px" class="ml-5" v-else>Not set</b>
          </div>
          <div
            v-if="!priceLoader"
            @click="setModal()"
            class="mt-1"
            style="font-size: 13px; text-decoration: underline; cursor: pointer"
          >
            <b v-if="!priceLoader">edit</b>
          </div>
        </div>
        <div class="mr-12" v-if="!priceLoader && getPrice">
          {{ getPrice.created_at }}
        </div>
      </div>
    </div>

    <v-row>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="150" style="background-color: #ebebea">
          <v-card-text>
            <div class="d-flex">
              <div>
                <div class="d-flex align-start justify-start">
                  <b>{{ getDashboardData.total_gas_quantity }} Kg</b>
                </div>
                <div class="d-flex align-start justify-start">
                  ₦ {{ getDashboardData.total_gas_price }}
                </div>
              </div>
              <v-spacer></v-spacer>
              <div class="d-flex align-end justify-end mt-6">
                <img
                  src="../../assets/images/dashboardicon.png"
                  height="55"
                  style="position: absolute"
                />
                <img
                  src="../../assets/images/Chalkboard.png"
                  style="
                    position: relative;
                    margin-bottom: 8px;
                    margin-right: 9px;
                  "
                />
              </div>
            </div>
            <div class="d-flex align-start justify-start mt-8">
              <b>Total Available Gas</b>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="150" class="ml-5" style="background-color: #ebebea">
          <v-card-text>
            <div class="d-flex">
              <div>
                <div class="d-flex align-start justify-start">
                  <b>{{ getDashboardData.total_customer }}</b>
                </div>
                <div class="d-flex align-start justify-start">
                  0 New Customers
                </div>
              </div>
              <v-spacer></v-spacer>
              <div class="d-flex align-end justify-end mt-6">
                <img
                  src="../../assets/images/dashboardicon.png"
                  height="55"
                  style="position: absolute"
                />
                <img
                  src="../../assets/images/Chalkboard.png"
                  style="
                    position: relative;
                    margin-bottom: 8px;
                    margin-right: 9px;
                  "
                />
              </div>
            </div>
            <div class="d-flex align-start justify-start mt-7">
              <b>Total Customers</b>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="150" class="ml-5" style="background-color: #ebebea">
          <v-card-text>
            <div class="d-flex">
              <div>
                <div class="d-flex align-start justify-start">
                  <b>{{ getDashboardData.total_sales }} ₦</b>
                </div>
                <div class="d-flex align-start justify-start mt-7">
                  45 New Connections
                </div>
              </div>
              <v-spacer></v-spacer>
              <div class="d-flex align-end justify-end mt-6">
                <img
                  src="../../assets/images/dashboardicon.png"
                  height="55"
                  style="position: absolute"
                />
                <img
                  src="../../assets/images/Chalkboard.png"
                  style="
                    position: relative;
                    margin-bottom: 8px;
                    margin-right: 9px;
                  "
                />
              </div>
            </div>
            <div class="d-flex align-start justify-start mt-7">
              <b>Total Sales</b>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <div
      class="d-flex mt-3"
      v-if="loggedinUser.company_email !== 'superadmin@gmail.com'"
    >
      <div><b>Orders</b></div>
      <v-spacer></v-spacer>
      <div class="mr-3">
        <date-picker />
      </div>
    </div>
    <div
      class="mt-0"
      v-if="loggedinUser.company_email !== 'superadmin@gmail.com'"
    >
      <v-data-table
        :headers="headers"
        :items="getAllOrders"
        class="elevation-1"
        height="220px"
        :search="search"
        :loading="tableloading"
        hide-default-header
      >
        <template v-slot:[`body.prepend`]="{ headers }">
          <th v-for="(header, i) in headers" :key="'A' + i" class="table-head">
            <div class="d-flex ml-3">
              {{ header.text }}
            </div>
          </th>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon small class="mr-2" @click="ViewOrders(item)">
            mdi-eye
          </v-icon>
        </template></v-data-table
      >
    </div>
    <v-dialog v-model="isModal" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h5 text-center align-center display-center">
          Set Gas Price
        </v-card-title>
        <v-form v-model="valid">
          <v-card-text>
            <v-text-field
              v-model="depo_name"
              solo
              label="Enter Depo Name"
              hide-details="auto"
              clearable
              class="ma-3"
              :rules="nameRules"
            ></v-text-field>
            <v-text-field
              hide-details="auto"
              v-model="location"
              solo
              label="Enter Depo Location"
              clearable
              :rules="nameRules"
              class="ma-3"
            ></v-text-field>
            <v-text-field
              class="ma-3"
              hide-details="auto"
              v-model="price"
              :rules="nameRules"
              solo
              label="Enter price"
              clearable
            ></v-text-field
          ></v-card-text>
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
            @click="setGasPrice()"
            :disabled="!valid"
            :loading="loading"
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
      class="mt-4"
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
import datePicker from "../../views/Pages/datePicker.vue";
export default {
  data: () => ({
    nameRules: [(v) => !!v || "This field is required"],
    tableloading: true,
    loading: false,
    valid: false,
    priceLoader: true,
    start_date: new Date().toISOString().substr(0, 10),
    end_date: new Date().toISOString().substr(0, 10),
    isModal: false,
    price: "",
    depo_id: null,
    location: "",
    depo_name: "",
    search: "",
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    picker: [
      new Date().toISOString().substr(0, 10),
      new Date().toISOString().substr(0, 10),
    ],
    loggedinUser: JSON.parse(localStorage.getItem("user")),
    headers: [
      {
        text: "Date",
        align: "start",
        sortable: false,
        value: "created_at",
      },
      { text: "Order Id", value: "order_id" },
      { text: "Customer Name", value: "customer_name" },
      { text: "Gas Quantity", value: "gas_quantity" },
      { text: "Amount", value: "amount" },
      { text: "Status", value: "status" },
      //{ text: "Updated by", value: "updated_by" },
      { text: "Payment Mode", value: "payment_mode" },
      { text: "View Details", value: "actions", sortable: false },
    ],
  }),
  components: {
    datePicker,
  },

  mounted() {
    this.getOrderListing([this.start_date, this.end_date]);
    this.$store.dispatch("getCurrentPrice");
    this.$store.dispatch("getDashboardStats");
    this.$store.commit("setSelectedDateRange", "Today");
  },
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getPrice", "getDashboardData", "getAllOrders"]),
  },
  watch: {
    getDashboardData() {
      console.log(this.getDashboardData);
    },
  },
  created() {
    eventBus.$on("priceResponseArrived", () => {
      this.priceLoader = false;
    });
    eventBus.$on("responseArrived", () => {
      this.tableloading = false;
    });
    eventBus.$on("selectedDashboardDateFilter", (value) => {
      console.log(value, "value");
      this.getOrderListing(value);
    });
  },
  methods: {
    getOrderListing(date) {
      this.tableloading = true;
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      console.log("before dispatching", requestBody);
      this.$store.dispatch("getOrderListing", requestBody);
    },
    setModal() {
      if (this.getPrice) {
        this.depo_name = this.getPrice.depo_name;
        this.location = this.getPrice.location;
        this.price = this.getPrice.price_per_twenty_million_ton;
        this.depo_id = this.getPrice.id;
      }
      this.isModal = true;
    },
    setGasPrice() {
      this.loading = true;
      let requestBody = {
        depo_name: this.depo_name,
        location: this.location,
        price_per_twenty_million_ton: this.price,
        depo_id: this.depo_id,
      };
      let apiName = "";
      this.purchase_id == null
        ? (apiName = "depo/create")
        : (apiName = "depo/update");
      RequestService.post(apiName, requestBody)
        .then((res) => {
          if (res.data.status == 201 && !this.depo_id)
            this.snacbarMessage = "Your price(s) added successfully";
          else if (this.depo_id)
            this.snacbarMessage = "Your price(s) updated successfully";

          this.snackbar = true;
          this.snackbarColor = "success";
          this.loading = false;
          this.isModal = false;
          this.$store.dispatch("getCurrentPrice");
        })
        .catch((err) => {
          if (err.response) {
            this.loading = false;
            this.isModal = false;
            this.snackbar = true;
            this.snackbarColor = "red";
            this.snacbarMessage = " Something went wrong";
          }
        });
    },
    ViewOrders(item) {
      this.$store.commit("SET_VIEW_PURCHASE", item);
      this.$router.push("/order-details");
    },
  },
};
</script>
<style scoped>
.dashboard-card {
  height: 600px;

  border-radius: 0px !important;
}
.top-bar {
  background-color: #ebebea;
  height: 55px;
  border-radius: 20px;
}
.searchbar {
  border-radius: 10px;
  background-color: white !important;
  width: 500px;
}
.table-head {
  background-color: #ebebea;
  font-size: 12px;
  height: 50px;
}
</style>
