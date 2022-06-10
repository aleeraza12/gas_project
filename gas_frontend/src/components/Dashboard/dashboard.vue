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
      <div class="mr-5 mt-2">
        <v-icon> mdi-bell-outline</v-icon>
      </div>
    </div>
    <div class="d-flex mt-5">
      <div>
        <b> Welcome Ola,</b>
      </div>
      <v-spacer></v-spacer>
      <div>
        <div>Current gas price</div>

        <div class="d-flex">
          <v-skeleton-loader
            v-if="priceLoader"
            type="list-item-avatar-three-line"
          ></v-skeleton-loader>
          <div v-else-if="!priceLoader">
            <b style="font-size: 26px" class="ml-5" v-if="getPrice"
              >N{{ getPrice.price_per_twenty_million_ton }}</b
            >
            <b style="font-size: 16px" class="ml-5" v-else>Not set</b>
          </div>
          <div
            v-if="!priceLoader"
            @click="setModal()"
            class="mt-4 ml-2"
            style="font-size: 13px; text-decoration: underline; cursor: pointer"
          >
            <b v-if="!priceLoader">edit</b>
          </div>
        </div>
        <div v-if="!priceLoader && getPrice">{{ getPrice.created_at }}</div>
      </div>
    </div>

    <v-row>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="120" style="background-color: #ebebea">
          <v-card-text>
            <div class="d-flex">
              <div>
                <div class="d-flex align-start justify-start">
                  <b>{{ getDashboardData.total_gas_quantity }} Kg</b>
                </div>
                <div class="d-flex align-start justify-start">
                  NA {{ getDashboardData.total_gas_price }}
                </div>
              </div>
              <v-spacer></v-spacer>
              <div class="d-flex align-end justify-end">
                <v-icon>mdi-image</v-icon>
              </div>
            </div>
            <div class="d-flex align-start justify-start mt-5">
              <b>Total Available Gas</b>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="120" class="ml-5" style="background-color: #ebebea">
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
              <div class="d-flex align-end justify-end">
                <v-icon>mdi-image</v-icon>
              </div>
            </div>
            <div class="d-flex align-start justify-start mt-5">
              <b>Total Customers</b>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="120" class="ml-5" style="background-color: #ebebea">
          <v-card-text>
            <div class="d-flex">
              <div>
                <div class="d-flex align-start justify-start">
                  <b>{{ getDashboardData.total_sales }}</b>
                </div>
                <div class="d-flex align-start justify-start">
                  45 New Connections
                </div>
              </div>
              <v-spacer></v-spacer>
              <div class="d-flex align-end justify-end">
                <v-icon>mdi-image</v-icon>
              </div>
            </div>
            <div class="d-flex align-start justify-start mt-5">
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
      <div class="mr-3"><b>Date Picker</b></div>
    </div>
    <div
      class="mt-3"
      v-if="loggedinUser.company_email !== 'superadmin@gmail.com'"
    >
      <v-data-table
        :headers="headers"
        :items="desserts"
        :items-per-page="5"
        class="elevation-1"
        hide-default-footer
        height="370px"
        :search="search"
      >
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

export default {
  data: () => ({
    nameRules: [(v) => !!v || "This field is required"],
    loading: false,
    valid: false,
    priceLoader: true,
    isModal: false,
    price: "",
    depo_id: null,
    location: "",
    depo_name: "",
    search: "",
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
    loggedinUser: JSON.parse(localStorage.getItem("user")),
    headers: [
      {
        text: "Date",
        align: "start",
        sortable: false,
        value: "date",
      },
      { text: "Order Id", value: "id" },
      { text: "Customer Name", value: "name" },
      { text: "Gas Quantity", value: "quantity" },
      { text: "Amount", value: "amount" },
      { text: "Status", value: "status" },
      { text: "Update by", value: "update_by" },
      { text: "Payment Mode", value: "payment" },
      { text: "View Details", value: "actions", sortable: false },
    ],
    desserts: [
      {
        date: "04 april 2022 01:32 am",
        id: "100",
        name: "John",
        quantity: 6,
        amount: 2400,
        status: "Paid",
        update_by: "abc",
        payment: "cash",
      },
      {
        date: "04 april 2022 01:32 am",
        id: "101",
        name: "Bran",
        quantity: 6,
        amount: 2400,
        status: "Paid",
        update_by: "abc",
        payment: "cash",
      },
      {
        date: "04 april 2022 01:32 am",
        id: "102",
        name: "Asla",
        quantity: 6,
        amount: 2400,
        status: "Paid",
        update_by: "abc",
        payment: "cash",
      },
      {
        date: "04 april 2022 01:32 am",
        id: "103",
        name: "Urab",
        quantity: 6,
        amount: 2400,
        status: "Paid",
        update_by: "abc",
        payment: "cash",
      },
      {
        date: "04 april 2022 01:32 am",
        id: "104",
        name: "Sanam",
        quantity: 6,
        amount: 2400,
        status: "Paid",
        update_by: "abc",
        payment: "cash",
      },
      {
        date: "04 april 2022 01:32 am",
        id: "105",
        name: "Steve",
        quantity: 6,
        amount: 2400,
        status: "Paid",
        update_by: "abc",
        payment: "cash",
      },
      {
        date: "04 april 2022 01:32 am",
        id: "106",
        name: "Alex",
        quantity: 6,
        amount: 2400,
        status: "Paid",
        update_by: "abc",
        payment: "cash",
      },
    ],
  }),
  components: {},

  mounted() {
    this.$store.dispatch("getCurrentPrice");
    this.$store.dispatch("getDashboardStats");
  },
  computed: {
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
    ...mapGetters(["getPrice", "getDashboardData"]),
  },
  watch: {
    getDashboardData() {
      console.log(this.getDashboardData);
    },
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.priceLoader = false;
    });
  },
  methods: {
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
    ViewOrders() {
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
</style>
