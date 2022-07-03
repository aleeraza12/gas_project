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
      <div v-if="!loggedinUser.is_super_admin">
        <div
          class="row display-end mt-2"
          :class="$vuetify.breakpoint.smAndDown ? 'ml-9' : 'mr-7'"
        >
          <div style="font-size: 16px" class="text-amount-color">
            Current gas price
          </div>
          <div style="cursor: pointer" @click="setModal()">
            <div
              v-if="!priceLoader"
              class="mt-1 ml-1"
              style="
                font-size: 12px;
                text-decoration: underline;
                cursor: pointer;
              "
            >
              <b
                v-if="
                  !priceLoader && loggedinUser.permissions.includes('Rates')
                "
                class="text-amount-color"
                >edit</b
              >
            </div>
          </div>
        </div>
        <br />
        <div
          class="d-flex justify-end align-end"
          :class="$vuetify.breakpoint.smAndDown ? 'mr-n3' : 'mr-8'"
        >
          <div class="row">
            <v-skeleton-loader
              v-if="priceLoader"
              type="list-item-avatar-three-line"
            ></v-skeleton-loader>
            <div class="col" v-else-if="!priceLoader">
              <b
                :style="
                  $vuetify.breakpoint.smAndDown
                    ? 'font-size: 12px'
                    : 'font-size: 22px'
                "
                class="text-amount-color"
                v-if="getPrice.household_user"
                >N{{ getPrice.household_user.price_per_twenty_million_ton }}</b
              >
              <b
                :style="
                  $vuetify.breakpoint.smAndDown
                    ? 'font-size: 12px'
                    : 'font-size: 22px'
                "
                class="text-amount-color"
                v-else
                :class="$vuetify.breakpoint.smAndDown ? 'ml-2' : 'ml-10'"
                >N0</b
              >
              <h5>Household User</h5>
            </div>
            <div class="col">
              <b
                :style="
                  $vuetify.breakpoint.smAndDown
                    ? 'font-size: 12px'
                    : 'font-size: 22px'
                "
                class="text-amount-color"
                v-if="getPrice.retailor"
                >N{{ getPrice.retailor.price_per_twenty_million_ton }}</b
              >
              <b
                :style="
                  $vuetify.breakpoint.smAndDown
                    ? 'font-size: 12px'
                    : 'font-size: 22px'
                "
                class="text-amount-color"
                :class="$vuetify.breakpoint.smAndDown ? 'ml-2' : 'ml-10'"
                v-else
                >N0</b
              >
              <h5>Retailor</h5>
            </div>
            <div class="col">
              <b
                :style="
                  $vuetify.breakpoint.smAndDown
                    ? 'font-size: 12px'
                    : 'font-size: 22px'
                "
                class="text-amount-color"
                v-if="getPrice.distributor"
                >N{{ getPrice.distributor.price_per_twenty_million_ton }}</b
              >
              <b
                :style="
                  $vuetify.breakpoint.smAndDown
                    ? 'font-size: 12px'
                    : 'font-size: 22px'
                "
                class="text-amount-color"
                v-else
                :class="$vuetify.breakpoint.smAndDown ? 'ml-2' : 'ml-10'"
                >N0</b
              >
              <h5>Distributor</h5>
            </div>
          </div>
        </div>
        <div v-if="!priceLoader && getPrice" class="mr-6">
          <p style="font-size: 14px">{{ getPrice.updated_at }}</p>
        </div>
      </div>
    </div>

    <v-row>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="150" style="background-color: #e3fbff">
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
              <div class="d-flex align-end justify-end mt-0">
                <img src="../../assets/images/1.png" height="55" />
              </div>
            </div>
            <div class="d-flex align-start justify-start mt-8">
              <b>Total Available Gas</b>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="150" class="ml-0" style="background-color: #fff4d0">
          <v-card-text>
            <div class="d-flex">
              <div>
                <div class="d-flex align-start justify-start">
                  <b>{{ getDashboardData.total_customer }}</b>
                </div>
                <div class="d-flex align-start justify-start">
                  {{
                    getDashboardData.new_customer == []
                      ? 0
                      : getDashboardData.new_customer
                  }}
                  New Customers
                </div>
              </div>
              <v-spacer></v-spacer>
              <div class="d-flex align-end justify-end mt-0">
                <img src="../../assets/images/2.png" height="55" />
              </div>
            </div>
            <div class="d-flex align-start justify-start mt-7">
              <b>Total Customers</b>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="150" class="ml-0" style="background-color: #ebe8ff">
          <v-card-text>
            <div class="d-flex">
              <div>
                <div class="d-flex align-start justify-start">
                  <b>{{ getDashboardData.total_sales }} ₦</b>
                </div>
                <!--<div class="d-flex align-start justify-start mt-7">
                  45 New Connections
                </div>-->
              </div>
              <v-spacer></v-spacer>
              <div class="d-flex align-end justify-end mt-0">
                <img src="../../assets/images/3.png" height="55" />
              </div>
            </div>
            <div class="d-flex align-start justify-start mt-7">
              <b>Total Sales</b>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <div class="d-flex mt-3">
      <div><b>Orders</b></div>
      <v-spacer></v-spacer>
      <div class="mr-3">
        <date-picker />
      </div>
    </div>
    <div class="mt-0">
      <v-data-table
        :headers="headers"
        :items="getAllOrders"
        class="elevation-1"
        height="calc(100vh - 450px)"
        :search="search"
        :loading="tableloading"
        hide-default-header
        :mobile-breakpoint="0"
      >
        <template v-slot:[`body.prepend`]="{ headers }">
          <th v-for="(header, i) in headers" :key="'A' + i" class="table-head">
            <div class="d-flex ml-3">
              {{ header.text }}
            </div>
          </th>
        </template>
        <template v-slot:item.status="{ item }">
          <v-chip
            class="ma-2"
            small
            :color="item.status == 'Unpaid' ? 'red' : 'green'"
            label
            outlined
            >{{ item.status }}</v-chip
          >
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
            <v-select
              class="ma-3"
              :items="['Distributor', 'Retailer', 'Household User']"
              v-model="customer_type"
              label="Customer Type"
              :rules="nameRules"
              dense
              solo
              small
              hide-details
            ></v-select>
            <v-text-field
              class="ma-3"
              hide-details="auto"
              v-model="price"
              :rules="nameRules"
              solo
              label="Enter price"
              clearable
            ></v-text-field>
          </v-card-text>
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
    customer_type: "",
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
    isModal: false,
    price: "",
    price_distributor: "",
    price_retailor: "",
    price_household_user: "",
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
    options2: {
      responsive: [
        { end: 576, size: 1 },
        { start: 576, end: 768, size: 2 },
        { start: 768, end: 992, size: 3 },
        { size: 4 },
      ],
      autoscroll: {
        enabled: true,
        interval: 5000, // in milliseconds
        repeat: true, // used to tell if after reaching the end of the list should the list return to beginning again
      },
      list: {
        // 1200 because @media (min-width: 1200px) and therefore I want to switch to windowed mode
        windowed: 1200,
        // Because: #app {padding: 80px 24px;}
        padding: 24,
      },
      items: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9].map((i) => {
        return {
          title: `Auto scroll ${i}`,
          content: `Auto scroll, 5s/5000ms.`,
        };
      }),
    },
  }),
  components: {
    datePicker,
    // VueHorizontalListAutoscroll
  },

  mounted() {
    this.getOrderListing([this.start_date, this.end_date]);
    this.$store.dispatch("getCurrentPrice");
    this.$store.dispatch("getDashboardStats");
    this.$store.commit("setSelectedDateRange", "All");
    this.depo_name = this.loggedinUser.company_name;
    this.location = this.loggedinUser.address;
  },
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters([
      "getAllCustomerTypes",
      "getPrice",
      "getDashboardData",
      "getAllOrders",
    ]),
  },
  watch: {},
  created() {
    eventBus.$on("snackbarMsg", () => {
      this.snacbarMessage = "No internet connection";
      this.snackbar = true;
      this.snackbarColor = "red";
    });
    eventBus.$on("priceResponseArrived", () => {
      this.priceLoader = false;
    });
    eventBus.$on("responseArrived", () => {
      this.tableloading = false;
    });
    eventBus.$on("selectedDashboardDateFilter", (value) => {
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
      this.$store.dispatch("getOrderListing", requestBody);
    },
    setModal() {
      // if (this.getPrice) {
      //   this.depo_name = this.getPrice.depo_name;
      //   this.location = this.getPrice.location;
      //   this.price_distributor = this.getPrice.distributor.price_per_twenty_million_ton;
      //   this.price_retailor = this.getPrice.distributor.price_per_twenty_million_ton;
      //   this.price_household_user = this.getPrice.household_user.price_per_twenty_million_ton;
      //   this.depo_id = this.getPrice.id;
      // }
      this.isModal = true;
    },
    setGasPrice() {
      this.loading = true;
      let requestBody = {
        depo_name: this.depo_name,
        location: this.location,
        price_per_twenty_million_ton: this.price,
        depo_id: this.depo_id,
        customer_type: this.customer_type,
        added_by_admin: false,
      };
      RequestService.post("depo/create", requestBody)
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
.text-amount-color {
  color: rgb(60, 57, 149);
}

.dashboard-card {
  height: 600px;

  border-radius: 0px !important;
}
.top-bar {
  background: #eff0fa;
  height: 55px;
  border-radius: 20px;
}
.searchbar {
  border-radius: 10px;
  background-color: white !important;
  width: 100%;
}
.table-head {
  background: #eff0fa;
  font-size: 12px;
  height: 50px;
}
</style>
