<template>
  <div class="main-container">
    <div class="sales-details-page">
      <div class="d-flex">
        <div @click="goToPurchases()">
          <v-icon class="ml-3 mt-3"> mdi-close</v-icon>
        </div>
      </div>
      <div class="mt-6"><b>Purchase Details</b></div>
      <v-divider></v-divider>
      <div class="d-flex align-center justify-center mt-3">
        <div
          v-if="getSinglePurchase.base64 == ''"
          style="height: 150px; width: 150px; background-color: #c4c4c4"
        ></div>
        <img
          v-else
          style="border: 1px solid grey; border-radius: 5px"
          max-width="70"
          v-bind:src="'data:image/jpeg;base64,' + getSinglePurchase.base64"
          height="120"
        />
      </div>
      <div class="d-flex align-center justify-center mt-1">
        <div style="text-decoration: underline" class="fonts">Change Image</div>
      </div>

      <div class="d-flex mt-5">
        <div class="ml-10">
          <v-chip small dense color="success" label class="pa-3">
            {{ getSinglePurchase.payment_status }}
          </v-chip>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-10 fonts">
          <div>
            <b>{{ getSinglePurchase.date }}</b>
          </div>
          <div>02:33 pm</div>
        </div>
      </div>
      <div
        class="d-flex align-start justify-start ml-5"
        style="font-size: 16px; font-weight: 600"
      >
        Company Info
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-3">
          <div class="d-flex align-start justify-start">
            <b>{{ getSinglePurchase.company_name }}</b>
          </div>
          <div class="d-flex align-start justify-start fonst">
            {{ getSinglePurchase.company_phone_number }}
          </div>
          <div class="d-flex align-start justify-start fonts">
            office no abc , nowrelad activty sometec howdy
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-3">
          <div class="fonts">Transcation Id</div>
          <div class="fonts">000000010000</div>
        </div>
      </div>
      <div class="mt-3" style="text-decoration: underline">
        <b>Purchase Info</b>
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-3">
          <div class="d-flex">
            <div class="fonts"><b>Unit Gas Price:</b></div>
            <div class="fonts">N {{ getSinglePurchase.unit_price }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Total Amount:</b></div>
            <div class="fonts">N {{ getSinglePurchase.amount }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Payment Mode:</b></div>
            <div class="fonts">Prepaid</div>
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-3">
          <div class="fonts">Transcation Id</div>
          <div class="fonts">000000010000</div>
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
      <div class="fonts">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio label="paid" color="primary" value="paid"></v-radio>
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
  }),
  watch: {
    getSinglePurchase() {
      console.log("data", this.getSingleReceipt);
    },
  },
  computed: {
    ...mapGetters(["getSinglePurchase"]),
  },
  mounted() {
    console.log("nsde mounted", this.getSinglePurchase);
  },
  methods: {
    goToPurchases() {
      this.$router.push("/purchases");
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
