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
            ></v-text-field>
          </div>
          <v-spacer></v-spacer>
          <div class="mr-5 mt-2">
            <v-icon> mdi-bell-outline</v-icon>
          </div>
        </div>
        <div class="d-flex mt-5">
          <div>
            <b> Sales</b>
          </div>
        </div>
        <div class="d-flex mt-5">
          <div>
            <v-card height="80" width="930" style="background-color: #ebebea">
              <v-card-text>
                <div class="d-flex">
                  <div>
                    <div class="d-flex align-start justify-start">
                      <b>Total Sales</b>
                    </div>
                    <div class="d-flex align-start justify-start">
                      165,00,0000 NAJRA
                    </div>
                  </div>
                  <v-spacer></v-spacer>
                  <div class="d-flex align-end justify-end">
                    <v-btn small dense outlined
                      >Create Receipt
                      <v-icon small dense class="ml-2">mdi-plus</v-icon></v-btn
                    >
                  </div>
                </div>
              </v-card-text>
            </v-card>
          </div>
        </div>
        <div class="d-flex mt-3">
          <div><b>Transactions</b></div>
          <v-spacer></v-spacer>
          <div class="mr-3" style="border-bottom: 1px solid grey">
            Export Csv
          </div>
          <div class="mr-3"><b>Date Picker</b></div>
        </div>
        <div class="mt-3">
          <v-card>
            <v-card-text>
              <v-data-table
                :loading="loading"
                loading-text="Loading... Please wait"
                :headers="headers"
                :items="getSales"
                :items-per-page="5"
                class="elevation-1"
                hide-default-footer
                hide-default-header
                height="230px"
              >
                <template v-slot:[`body.prepend`]="{ headers }">
                  <th
                    v-for="(header, i) in headers"
                    :key="i"
                    class="table-head"
                  >
                    <div class="d-flex ml-3">
                      {{ header.text }}
                    </div>
                  </th>
                </template>
                  <template v-slot:item.actions="{ item }">
                  <v-icon small class="mr-2" @click="editItem(item)">
                    mdi-eye
                  </v-icon>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
import { eventBus } from "@/main";

export default {
  data: () => ({
    loading: true,
    
    headers: [
      {
        text: "Date",
        align: "start",
        sortable: false,
        value: "name",
      },
      //{ text: "Order Id", value: "id" },
      { text: "Customer Name", value: "customer_name" },
      { text: "Gas Quantity", value: "gas_quantity" },
      { text: "Amount", value: "total_amount" },
      { text: "Status", value: "status" },
      { text: "Update by", value: "updated_by" },
      { text: "Payment Mode", value: "payment_mode" },
            { text: 'Actions', value: 'actions', sortable: false },

    ],
  }),
  components: {},
  computed: {
    ...mapGetters(["getSales"]),
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.loading = false;
    });
  },
  methods: {},
  watch: {
    getSales() {
      console.log("response", this.getSales);
    },
  },
  mounted() {
    this.$store.dispatch("getSalesListings");
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
  width: 930px;
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
