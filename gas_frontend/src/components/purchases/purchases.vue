<template>
  <div class="main-container">
    <v-card class="dashboard-card pa-0 elevation-0">
      <v-card-text>
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
            <b> Purchases</b>
          </div>
        </div>
        <div
          class="d-flex mt-5 pa-5"
          style="background-color: #ebebea; border-radius: 5px"
        >
          <div>
            <div class="d-flex align-start justify-start">
              <b>Available Balance</b>
            </div>
            <div class="d-flex align-start justify-start">
              {{ total_sales }} ₦
            </div>
          </div>
          <v-spacer></v-spacer>
          <div class="d-flex align-end justify-end">
            <v-btn small dense outlined @click="goToAddPurchase()"
              >Add Receipt
              <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
            >
          </div>
        </div>

        <div class="d-flex mt-3">
          <div></div>
          <v-spacer></v-spacer>
          <div class="pointer" @click="myFunction()">
            View Current Depo Prices
          </div>
        </div>
        <div class="d-flex mt-3">
          <div><b>History</b></div>
          <v-spacer></v-spacer>
          <div class="mr-3" style="border-bottom: 1px solid grey">
            <v-btn
              @click="btnClick()"
              depressed
              light
              text
              :ripple="false"
              height="5px"
              x-small
              dense
              class="text-capitalize pa-4 mb-n1 mt-2"
            >
              <span class="black--text">Export </span></v-btn
            >
          </div>
          <div class="mr-3"><date-picker /></div>
        </div>
        <div class="mt-3">
          <v-data-table
            id="myDIV"
            :loading="loading"
            loading-text="Loading... Please wait"
            :headers="Depoheaders"
            :items="getAllDepos"
            :items-per-page="5"
            class="elevation-1"
            hide-default-footer
            hide-default-header
            height="400px"
            :search="search"
          >
            <template v-slot:[`body.prepend`]="{ headers }">
              <th
                v-for="(header, i) in headers"
                :key="'A' + i"
                class="table-head"
              >
                <div class="d-flex ml-3">
                  {{ header.text }}
                </div>
              </th>
            </template>
          </v-data-table>
          <v-data-table
            :loading="loading"
            loading-text="Loading... Please wait"
            :headers="headers"
            :items="getPurchases"
            :items-per-page="5"
            class="elevation-1 mt-5"
            hide-default-footer
            hide-default-header
            height="400px"
            :search="search"
          >
            <template v-slot:[`body.prepend`]="{ headers }">
              <th
                v-for="(header, i) in headers"
                :key="'A' + i"
                class="table-head"
              >
                <div class="d-flex ml-3">
                  {{ header.text }}
                </div>
              </th>
            </template>
            <template v-slot:item.date="{ item }">
              {{ getDate(item) }}
            </template>
            <template v-slot:item.status="{ item }">
              {{ getStatus(item) }}
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon small class="mr-2" @click="viewPurchase(item)">
                mdi-eye
              </v-icon>
            </template>
          </v-data-table>
        </div>
      </v-card-text>
    </v-card>
    <download-csv :json-data="getPurchases">
      <v-btn style="display: none" id="myBtn">
        <b>My custom button</b>
      </v-btn>
    </download-csv>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import moment from "moment";
import datePicker from "../../views/Pages/datePicker.vue";
import VueJsonToCsv from "vue-json-to-csv";
import Vue from "vue";
Vue.component("downloadCsv", VueJsonToCsv);
export default {
  data: () => ({
    loading: true,
    depoLoading: true,
    isDepo: false,
    search: "",
    total_sales: null,
    start_date: '2022-01-01',
    end_date: new Date().toISOString().substr(0, 10),
    Depoheaders: [
      { text: "Depot Name", value: "depo_name" },
      { text: "Location", value: "location" },
      { text: "Price(per 20MT)", value: "price_per_twenty_million_ton" },
    ],
    headers: [
      {
        text: "Date",
        align: "start",
        sortable: false,
        value: "date",
      },
      { text: "Receipt Number", value: "receipt_number" },
      { text: "Company Name", value: "company_name" },
      { text: "Gas Quantity", value: "gas_quantity" },
      { text: "Amount", value: "amount" },
      { text: "Unit Price", value: "unit_price" },
      { text: "Status", value: "status" },
      { text: "Driver's Name", value: "driver_name" },
      { text: "Received By", value: "recepient_name" },
      { text: "Actions", value: "actions", sortable: false },
    ],
  }),
  components: {
    datePicker,
  },
  computed: {
    ...mapGetters(["getPurchases", "getAllDepos"]),
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.loading = false;
    });
    eventBus.$on("responseArrivedDepo", () => {
      this.depoLoading = false;
    });
    eventBus.$on("selectedPurchasesDateFilter", (value) => {
      console.log(value, "value");
      this.getPurchasesListing(value);
    });
  },
  methods: {
    btnClick() {
      document.getElementById("myBtn").click();
    },
    myFunction() {
      var x = document.getElementById("myDIV");
      if (x.style.display === "none") {
        x.style.display = "block";
      } else {
        x.style.display = "none";
      }
    },
    getPurchasesListing(date) {
      this.loading = true;
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      console.log("before dispatching", requestBody);
      this.$store.dispatch("getPurchaseListing", requestBody);
    },
    goToDepos() {
      this.$router.push("/depot");
    },
    getStatus(item) {
      if (item.paid === null && item.delivered === null) return "Unpaid";
      else if (item.paid !== null && item.delivered === null) return "Paid";
      else if (item.paid !== null && item.delivered !== null) return "Paid";
      else if (item.paid == null && item.delivered !== null) return "Delivered";
    },
    getDate(date) {
      return moment(date.date).format("Do MMMM YYYY, h:mm a");
    },
    viewPurchase(item) {
      this.$store.commit("SET_VIEW_PURCHASE", item);
      this.$router.push("purchase-details");
    },
    goToAddPurchase() {
      this.$router.push("purchase-receipt-form");
    },
  },
  watch: {
    getPurchases() {
      if (this.getPurchases.length > 0) {
        this.total_sales = 0;
        for (let i in this.getPurchases)
          this.total_sales += this.getPurchases[i].amount;
      } else this.total_sales = 0;
    },
  },
  mounted() {
    document.getElementById("myDIV").style.display = "none";
    this.getPurchasesListing([this.start_date, this.end_date]);
    this.$store.commit("setSelectedDateRange", "All");
    this.$store.dispatch("getAllDepos");
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
.pointer {
  cursor: pointer;
}
</style>
