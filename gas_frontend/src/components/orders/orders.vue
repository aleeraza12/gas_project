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
          class="searchbar shrink"
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
        <b> Orders</b>
      </div>
    </div>
    <div
      class="d-flex mt-5 pa-5"
      style="background-color: #eff0fa; border-radius: 5px"
    >
      <div>
        <div class="d-flex align-start justify-start"><b>Pending</b></div>
        <div class="d-flex align-start justify-start">
          {{ getAllOrders.length }}
        </div>
      </div>
      <v-spacer></v-spacer>
      <div class="d-flex align-end justify-end">
        <!--<v-btn small dense outlined
          >View All
          <v-icon small dense class="ml-2">mdi-eye-outline</v-icon></v-btn
        >-->
      </div>
    </div>
    <div class="d-flex mt-3">
      <div class="mt-4"><b>History</b></div>
      <v-spacer></v-spacer>
      <div class="mr-3"><date-picker /></div>
    </div>
    <div class="mt-3">
      <v-data-table
        :headers="headers"
        :items="getAllOrders"
        :items-per-page="5"
        :search="search"
        :loading="tableloading"
        class="elevation-1"
        hide-default-header
        height="calc(100vh - 400px)"
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
        </template>
      </v-data-table>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
import datePicker from "../../views/Pages/datePicker.vue";
export default {
  data: () => ({
    search: "",
    tableloading: true,
    start_date: "2022-01-01",
    end_date: new Date().toISOString().substr(0, 10),
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
  computed: {
    ...mapGetters(["getAllOrders"]),
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.tableloading = false;
    });
    eventBus.$on("selectedOrdersDateFilter", (value) => {
      this.getOrderListing(value);
    });
  },
  mounted() {
    this.getOrderListing([this.start_date, this.end_date]);
    this.$store.commit("setSelectedDateRange", "All");
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
  background: #eff0fa;
  height: 55px;
  border-radius: 20px;
  width: 100%;
}
.searchbar {
  border-radius: 10px;
  background-color: white !important;
  width: 100% !important;
}
.table-head {
  background: #eff0fa;
  font-size: 12px;
  height: 50px;
}
</style>
