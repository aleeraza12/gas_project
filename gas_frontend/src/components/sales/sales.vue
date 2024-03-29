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
          <!--<div class="mr-5 mt-2">
            <v-icon> mdi-bell-outline</v-icon>
          </div>-->
        </div>
        <div class="d-flex mt-5">
          <div>
            <b> Sales</b>
          </div>
        </div>
        <div
          class="d-flex mt-5 pa-5"
          style="background-color: #eff0fa; border-radius: 5px"
        >
          <div>
            <div
              class="d-flex align-start justify-start"
              style="color: #2b3896"
            >
              <b>Total Sales</b>
            </div>
            <div class="d-flex align-start justify-start total-amount">
              ₦ {{ Number(total_sales).toLocaleString() }}
            </div>
          </div>
          <v-spacer></v-spacer>
          <div class="d-flex align-end justify-end">
            <v-btn small dense outlined color="#2b3896" @click="goToSalesPage()"
              >Create Receipt
              <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
            >
          </div>
        </div>
        <div class="d-flex mt-3">
          <div class="mt-4"><b>History</b></div>
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
              <span style="color: #2e3995">Export </span></v-btn
            >
          </div>
          <div class="mr-3"><date-picker /></div>
        </div>
        <div class="mt-3">
          <v-data-table
            :loading="loading"
            loading-text="Loading... Please wait"
            :headers="headers"
            :items="getSales"
            :items-per-page="5"
            class="elevation-1"
            hide-default-header
            height="calc(100vh - 400px)"
            :search="search"
            :mobile-breakpoint="0"
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
            <template v-slot:item.transaction_id="{ item }">
              000{{ item.transaction_id }}
            </template>
            <template v-slot:item.gas_quantity="{ item }">
              {{ item.gas_quantity }} kg
            </template>
            <template v-slot:item.total_amount="{ item }">
              ₦ {{ Number(item.total_amount).toLocaleString() }}
            </template>
            <template v-slot:item.discounted_amount="{ item }">
              ₦ {{ Number(item.discounted_amount).toLocaleString() }}
            </template>
            <template v-slot:item.status="{ item }">
              {{ getStatus(item) }}
            </template>
            <template v-slot:item.actions="{ item }">
              <v-btn
                small
                class="mr-2"
                @click="ViewReceipt(item), (loader_id = item.id)"
                :loading="noResponse && loader_id == item.id"
                icon
              >
                <v-icon size="17"> mdi-eye </v-icon>
              </v-btn>
            </template>
          </v-data-table>
        </div>
      </v-card-text>
    </v-card>
    <download-csv :json-data="getSales">
      <v-btn style="display: none" id="myBtn">
        <b>My custom button</b>
      </v-btn>
    </download-csv>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import datePicker from "../../views/Pages/datePicker.vue";
import VueJsonToCsv from "vue-json-to-csv";
import RequestService from "../../RequestService";
import Vue from "vue";
Vue.component("downloadCsv", VueJsonToCsv);
export default {
  data: () => ({
    loading: true,
    total_sales: null,
    loader_id: "",
    noResponse: false,
    search: "",
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
    headers: [
      {
        text: "Date",
        align: "start",
        sortable: false,
        value: "created_at",
      },
      { text: "Transaction Id", value: "transaction_id" },
      { text: "Customer Name", value: "customer_name" },
      { text: "Gas Quantity", value: "gas_quantity" },
      { text: "Amount", value: "total_amount" },
      { text: "After Discount", value: "discounted_amount" },
      { text: "Status", value: "status" },
      { text: "Updated by", value: "updated_by" },
      { text: "Payment Mode", value: "payment_mode" },
      { text: "View Receipt", value: "actions", sortable: false },
    ],
  }),
  components: {
    datePicker,
  },
  computed: {
    ...mapGetters(["getSales"]),
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.loading = false;
    });
    eventBus.$on("selectedSalesDateFilter", (value) => {
      this.getSalesListings(value);
    });
  },
  methods: {
    btnClick() {
      document.getElementById("myBtn").click();
    },
    getStatus(item) {
      if (item.paid === null && item.delivered === null) return "Unpaid";
      else if (item.paid !== null && item.delivered === null) return "Paid";
      else if (item.paid !== null && item.delivered !== null) return "Paid";
      else if (item.paid == null && item.delivered !== null) return "Delivered";
    },
    goToSalesPage() {
      this.$router.push("sale-receipt-form");
    },
    ViewReceipt(item) {
      this.noResponse = true;
      let requestBody = {
        sale_id: item.id,
      };
      RequestService.post("sale/read_single_sale", requestBody).then(
        (response) => {
          if (response.data.status == 200) {
            this.noResponse = false;
            this.$store.commit("SET_VIEW_RECEIPT", response.data.response);
            this.$router.push("sales-details");
          }
        }
      );
    },
    getSalesListings(date) {
      this.loading = true;
      let requestBody = {
        start_date: date[0],
        end_date: date[1].concat(" 23:59:00"),
      };
      this.$store.dispatch("getSalesListings", requestBody);
    },
  },
  watch: {
    getSales() {
      this.total_sales = 0;
      for (var i in this.getSales) {
        this.total_sales += this.getSales[i].total_amount;
      }
    },
  },
  mounted() {
    this.getSalesListings([this.start_date, this.end_date]);
    this.$store.commit("setSelectedDateRange", "All");
  },
};
</script>
<style scoped>
.total-amount {
  color: #2b3896;
  font-family: "Inter";
  font-style: normal;
  font-weight: 500;
  font-size: 22px;
}
.dashboard-card {
  height: 600px;

  border-radius: 0px !important;
}
.top-bar {
  background-color: #eff0fa;
  height: 55px;
  border-radius: 20px;
}
.searchbar {
  border-radius: 10px;
  background-color: white !important;
  width: 100% !important;
}
.table-head {
  background-color: #eff0fa;
  font-size: 12px;
  height: 50px;
}
</style>
