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
              v-model="search"
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
            <b> Purchases</b>
          </div>
        </div>
        <div
          class="d-flex mt-5 pa-5"
          style="background-color: #ebebea; border-radius: 5px"
        >
          <div>
            <div class="d-flex align-start justify-start">
              <b>Total Purchases</b>
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
          <div><b>Current depot prices </b></div>
          <v-spacer></v-spacer>
          <div class="mr-3"><b>Date Picker</b></div>
        </div>
        <div class="mt-3">
          <v-data-table
            :loading="loading"
            loading-text="Loading... Please wait"
            :headers="headers"
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
            <template v-slot:item.price_per_twenty_million_ton="{ item }">
              <div>
                {{
                  item.price_per_twenty_million_ton == "0" ||
                  item.price_per_twenty_million_ton == 0
                    ? "N/A"
                    : item.price_per_twenty_million_ton
                }}
              </div>
            </template>
          </v-data-table>
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
    search: "",
    total_sales: null,

    headers: [
      { text: "Depot Name", value: "depo_name" },
      { text: "Location", value: "location" },
      { text: "Price(per 20MT)", value: "price_per_twenty_million_ton" },
    ],
  }),
  components: {},
  computed: {
    ...mapGetters(["getAllDepos"]),
  },
  created() {
    eventBus.$on("responseArrived", () => {
      this.loading = false;
    });
  },
  methods: {
    goToAddPurchase() {
      this.$router.push("purchase-receipt-form");
    },
  },
  watch: {
    getPurchases() {
      for (var i in this.getPurchases) {
        this.total_sales += this.getPurchases[i].amount;
      }
    },
  },
  mounted() {
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
</style>
