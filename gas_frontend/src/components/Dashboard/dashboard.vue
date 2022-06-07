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
        <div><b>N1 300</b></div>
        <div>Monday 4th, April 2022</div>
      </div>
    </div>

    <v-row>
      <v-col md="4" lg="4" xl="4" sm="12">
        <v-card height="120" style="background-color: #ebebea">
          <v-card-text>
            <div class="d-flex">
              <div>
                <div class="d-flex align-start justify-start">
                  <b>600 Kg</b>
                </div>
                <div class="d-flex align-start justify-start">
                  NA 000000000000000
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
                <div class="d-flex align-start justify-start"><b>124</b></div>
                <div class="d-flex align-start justify-start">
                  3 New Customers
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
                  <b>124,00000000</b>
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
    <div class="d-flex mt-3">
      <div><b>Orders</b></div>
      <v-spacer></v-spacer>
      <div class="mr-3"><b>Date Picker</b></div>
    </div>
    <div class="mt-3">
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
  </div>
</template>

<script>
export default {
  data: () => ({
    search: "",
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
  created() {},
  methods: {
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
