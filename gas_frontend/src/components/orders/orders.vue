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
        <b> Orders</b>
      </div>
    </div>
    <div
      class="d-flex mt-5 pa-5"
      style="background-color: #ebebea; border-radius: 5px"
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
      <div><b>History</b></div>
      <v-spacer></v-spacer>
      <div class="mr-3"><b>Date Picker</b></div>
    </div>
    <div class="mt-3">
      <v-data-table
        :headers="headers"
        :items="getAllOrders"
        :items-per-page="5"
        class="elevation-1"
        height="370px"
        :search="search"
        :loading="tableloading"
        hide-default-footer
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
        </template>
      </v-data-table>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";
export default {
  data: () => ({
    search: "",
    tableloading: true,
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
  components: {},
  computed: {
    //getIcon() {
    //  return this.snackbarColor == "primary"
    //    ? "mdi-checkbox-marked-circle"
    //    : "mdi-close-circle";
    //},
    ...mapGetters(["getAllOrders"]),
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.tableloading = false;
    });
  },
  mounted() {
    this.$store.dispatch("getOrderListing");
  },
  methods: {
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
