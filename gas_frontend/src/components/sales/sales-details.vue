<template>
  <div class="main-container">
    <div class="sales-details-page">
      <div class="d-flex">
        <div @click="goToSales()">
          <v-icon class="ml-3 mt-3"> mdi-close</v-icon>
        </div>
        <v-spacer></v-spacer>
        <div>
          <v-btn small dense class="mr-5 mt-3"
            ><v-icon class="ml-2">mdi-send</v-icon></v-btn
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
        <div class="ml-5 mt-3">
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
        <div class="mr-8 mt-3">
          <div class="fonts">Transcation Id</div>
          <div class="fonts">00000000{{ getSingleReceipt.transaction_id }}</div>
        </div>
      </div>
      <div class="mt-3" style="text-decoration: underline">
        <b>Sales Info</b>
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-3">
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
        <div class="mr-8 mt-3">
          <div class="fonts">Gas Quantity</div>
          <div class="fonts">{{ getSingleReceipt.gas_quantity }}</div>
        </div>
      </div>
      <div class="mt-3" style="text-decoration: underline">
        <b>Status History</b>
      </div>
      <div class="fonts mt-3">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio-group v-model="Delivered" column>
            <v-radio
              label="Delivered"
              color="primary"
              value="Delivered"
            ></v-radio>
          </v-radio-group>
        </div>
        <div class="d-flex align-start justify-start ml-8">
          23rd ,april 20222
        </div>
      </div>
      <div class="fonts">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio-group v-model="Paid" column>
            <v-radio label="paid" color="primary" value="Paid"></v-radio>
          </v-radio-group>
        </div>
        <div class="d-flex align-start justify-start ml-8">
          23rd ,april 20222
        </div>
      </div>
      <div>
        <v-btn dense outlined small style="width: 230px" class="mt-3">
          save
        </v-btn>
      </div>
      <div class="d-flex align-center justify-center">
        <div>
          <v-btn
            dense
            outlined
            small
            style="width: 100px"
            class="mt-3 mr-3"
            color="primary"
          >
            Edit
          </v-btn>
        </div>
        <div>
          <v-btn
            dense
            outlined
            small
            style="width: 100px"
            class="mt-3"
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
    Delivered: "Delivered",
    Paid: "Paid",
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
