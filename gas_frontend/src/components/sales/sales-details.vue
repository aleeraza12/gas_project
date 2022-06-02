<template>
  <div class="main-container">
    <div class="sales-details-page pa-6">
      <div class="d-flex">
        <div @click="goToSales()">
          <v-icon class="ml-3 mt-5"> mdi-close</v-icon>
        </div>
        <v-spacer></v-spacer>
        <div>
          <v-btn small dense class="mr-5 mt-5 pl-5" color="#CFCFD0"
            ><v-icon class="" size="20">mdi-send</v-icon></v-btn
          >
        </div>
      </div>
      <div class="mt-6" style="text-decoration: underline">
        <b>Sales Details</b>
      </div>
      <div class="d-flex mt-5">
        <div class="ml-10">
          <v-chip small dense color="success" label class="pa-3">
            {{ getSingleReceipt.status }}
          </v-chip>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-10 fonts">
          <div>
            <b>{{ getSingleReceipt.created_at }}</b>
          </div>
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
        <div class="ml-5 mt-5">
          <div class="d-flex align-start justify-start fonts">
            {{ getSingleReceipt.customer_type }}
          </div>
          <div class="d-flex align-start justify-start">
            <b>{{ getSingleReceipt.customer_name }}</b>
          </div>
          <div class="d-flex align-start justify-start fonst">
            {{ getSingleReceipt.customer_phone_number }}
          </div>
          <div class="d-flex align-start justify-start fonts">
            office no abc , nowrelad activty sometec howdy
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-5">
          <div class="fonts">Transcation Id</div>
          <div class="fonts">000000001000</div>
        </div>
      </div>
      <div class="mt-5" style="text-decoration: underline">
        <b>Sales Info</b>
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-5">
          <div class="d-flex">
            <div class="fonts"><b>Unit Gas Price:</b></div>
            <div class="fonts">{{ getSingleReceipt.price }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Total Amount:</b></div>
            <div class="fonts">{{ getSingleReceipt.total_amount }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Payment Mode:</b></div>
            <div class="fonts">{{ getSingleReceipt.payment_mode }}</div>
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-5">
          <div class="fonts">Transcation Id</div>
          <div class="fonts">000000000000</div>
        </div>
      </div>
      <div class="mt-5" style="text-decoration: underline">
        <b>Status History</b>
      </div>
      <div class="fonts mt-5">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio
            label="Delivered"
            color="primary"
            value="Delivered"
          ></v-radio>
        </div>
        <div class="d-flex align-start justify-start ml-8">
          23rd ,april 20222
        </div>
      </div>
      <div class="fonts">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio label="paid" color="primary" value="Paid"></v-radio>
        </div>
        <div class="d-flex align-start justify-start ml-8">
          23rd ,april 20222
        </div>
      </div>
      <div>
        <v-btn class="mt-5 btn-create">
          save
        </v-btn>
      </div>
      <div class="d-flex align-center justify-center">
        <div>
          <v-btn
            dense
            outlined
            small
            class="mt-5 "
           style="border-color:#464646 ;width: 150px"
          >
            Edit
          </v-btn>
        </div>
        <div>
          <v-btn
            dense
            outlined
            small
            style="width: 150px"
            class="mt-5 ml-2"
            color="red"
          >
            Delete
          </v-btn>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  data: () => ({
    loading: false,
  }),
  watch: {
    getSingleReceipt() {
      console.log("data", this.getSingleReceipt);
    },
  },
  computed: {
    ...mapGetters(["getSingleReceipt"]),
  },
  mounted() {
    console.log("nsde mounted", this.getSingleReceipt);
  },
  methods: {
    goToSales() {
      this.$router.push("/sales");
    },
  },
};
</script>
<style scoped>


.btn-create {
  background-color:  #464646 !important;
  color: #fff;
  min-width: 320px !important;
  border-radius: 8px !important;
  cursor: pointer;
}.sales-details-page {
  height: 700px;
  width: 600px;
  background-color: #ebebea;
  margin-left: 12rem;
}
.fonts {
  font-size: 12px;
}
</style>
