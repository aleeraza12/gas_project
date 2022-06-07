<template>
  <div class="main-container">
    <div class="sales-details-page">
      <div class="d-flex">
        <div>
          <v-icon class="ml-3 mt-3" @click="goToOrders()"> mdi-close</v-icon>
        </div>
      </div>
      <div class="mt-6"><b>Orders Details</b></div>
      <v-divider class="mt-2"></v-divider>
      <div class="d-flex mt-5">
        <div class="ml-10">
          <v-chip small dense color="success" label class="pa-3">
            Picked Up
          </v-chip>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-10 fonts">
          <div><b>24th , April 2022</b></div>
          <div>02:33 pm</div>
        </div>
      </div>
      <div
        class="d-flex align-start justify-start ml-5"
        style="font-size: 16px; font-weight: 600"
      >
        Customer Info
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-3">
          <div class="d-flex align-start justify-start fonts">Distributor</div>
          <div class="d-flex align-start justify-start"><b>Ola Adlyan</b></div>
          <div class="d-flex align-start justify-start fonst">04566000433</div>
          <div class="d-flex align-start justify-start fonts">
            office no abc , nowrelad activty sometec howdy
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-3">
          <div class="fonts">Order Id</div>
          <div class="fonts">000000000000</div>
        </div>
      </div>
      <div class="mt-3 d-flex align-start justify-start ml-3">
        <b>Order Info</b>
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-3">
          <div class="d-flex">
            <div class="fonts"><b>Unit Gas Price:</b></div>
            <div class="fonts">N1 , 340</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Total Amount:</b></div>
            <div class="fonts">N1, 18000</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Payment Mode:</b></div>
            <div class="fonts">Cash</div>
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-3">
          <div class="fonts">Gas Quanity : 12</div>
          <div class="fonts">000000000000</div>
        </div>
        <div class="mr-8 mt-3">
          <div class="fonts">Updated By</div>
          <div class="fonts">James</div>
        </div>
      </div>
      <div class="mt-3" style="text-decoration: underline">
        <b>Status History</b>
      </div>
      <div class="fonts mt-3">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio
            label="Deleivered"
            color="primary"
            value="Deleivered"
          ></v-radio>
        </div>
        <div class="d-flex align-start justify-start ml-8">
          23rd ,april 20222
        </div>
      </div>

      <div>
        <v-btn dense small style="width: 230px" class="mt-3"> Delivered </v-btn>
      </div>
      <div>
        <v-btn dense outlined small style="width: 230px" class="mt-3">
          Delete
        </v-btn>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({}),
  components: {},
  created() {},
  methods: {
    goToOrders() {
      this.$router.push("Orders");
    },
  },
};
</script>
<style scoped>
.sales-details-page {
  height: 600px;
  width: 600px;
  background-color: #ebebea;
  margin-left: 12rem;
}
.fonts {
  font-size: 12px;
}
</style>
