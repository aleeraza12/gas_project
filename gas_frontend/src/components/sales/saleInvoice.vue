<template>
  <div class="main-container">
    <v-card class="elevation-1">
      <v-card-text>
        <div class="sales-details-page">
          <div class="d-flex align-start justify-start" @click="goToSales()">
            <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
          </div>
          <div class="d-flex mt-3 pa-5">
            <div>
              <v-icon class="ml-10" size="80" color="#EBEBEA">
                mdi-circle</v-icon
              >
            </div>
            <v-spacer></v-spacer>
            <div class="mr-5">
              <div><b>LIT Engineers</b></div>
              <div class="fonts"><b>18,chokar town auto street 19</b></div>
              <div class="fonts">015980000045</div>
            </div>
          </div>
          <div><b>Sales Recepit</b></div>
          <v-divider></v-divider>
          <div
            class="d-flex align-start justify-start ml-5"
            style="font-size: 16px; font-weight: 600"
          >
            Customer Details
          </div>
          <div class="d-flex">
            <div class="ml-5 mt-3">
              <!--<div class="d-flex align-start justify-start fonts">
                distributor
              </div>-->
              <div class="d-flex align-start justify-start">
                <b>{{ getSingleReceipt.customer_name }}</b>
              </div>
              <div class="d-flex align-start justify-start fonst">
                {{ getSingleReceipt.customer_phone_number }}
              </div>
              <div class="d-flex align-start justify-start fonts">
                {{ getSingleReceipt.customer_address }}
              </div>
            </div>
            <v-spacer></v-spacer>
            <div class="mr-8 mt-3">
              <div class="fonts">Transcation Id</div>
              <div class="fonts">
                00000{{ getSingleReceipt.transaction_id }}
              </div>
              <div class="fonts">
                {{ getDate(getSingleReceipt.created_at) }}
              </div>
            </div>
          </div>

          <div class="d-flex" style="background-color: #ebebea">
            <div class="ml-5 mt-3">
              <div class="d-flex">
                <div class="fonts"><b>Payment Mthod:</b></div>
                <div class="fonts">{{ getSingleReceipt.payment_mode }}</div>
              </div>
            </div>
            <v-spacer></v-spacer>
            <div class="mr-8 mt-3">
              <div class="fonts">Amount Paid</div>
              <div class="fonts">{{ getSingleReceipt.total_amount }}</div>
            </div>
          </div>
          <div class="mt-3">
            <v-simple-table>
              <template v-slot:default>
                <thead style="background-color: #464646">
                  <tr>
                    <th class="text-left" style="color: #fff; font-size: 12px">
                      #
                    </th>
                    <th class="text-left" style="color: #fff; font-size: 12px">
                      Gas Quantity (kg)
                    </th>
                    <th class="text-left" style="color: #fff; font-size: 12px">
                      Unit Price(N)
                    </th>
                    <th class="text-left" style="color: #fff; font-size: 12px">
                      Amount(N)
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-left">1</td>
                    <td class="text-left">
                      {{ getSingleReceipt.gas_quantity }}
                    </td>
                    <td class="text-left">{{ getSingleReceipt.price }}</td>
                    <td class="text-left">
                      {{ getSingleReceipt.total_amount }}
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </div>
          <v-divider></v-divider>
          <div class="mt-3">
            <div class="d-flex" style="backgorund-color: #f6f6f5">
              <div>Total Amount</div>
              <div class="ml-5">{{ getSingleReceipt.total_amount }}</div>
            </div>
            <div class="d-flex" style="backgorund-color: #ebebea">
              <div>Amount Paid</div>
              <div class="ml-5">{{ getSingleReceipt.total_amount }}</div>
            </div>
            <div class="d-flex" style="backgorund-color: #f6f6f5">
              <div>Balance</div>
              <div class="ml-12">No</div>
            </div>
          </div>
          <div class="d-flex align-center justify-center">
            <b>Powered By GA3QSD</b>
          </div>
          <div class="d-flex align-center justify-center mt-3">
            <v-btn
              small
              dense
              style="
                background-color: black !important;
                color: #fff;

                cursor: pointer;
              "
              >Print</v-btn
            >
          </div>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
//import RequestService from "../../RequestService";
//import { eventBus } from "@/main";
//import moment from "moment";
export default {
  data() {
    return {};
  },
  computed: {
    ...mapGetters(["getSingleReceipt"]),
    //getIcon() {
    //  return this.snackbarColor == "success"
    //    ? "mdi-checkbox-marked-circle"
    //    : "mdi-close-circle";
    //},
  },
  mounted() {
    if (this.getSingleReceipt.length == 0) {
      this.$router.push("/sales");
    }
  },
  methods: {
    goToSales() {
      this.$router.push("/sales");
    },
    getDate(item) {
      let date = item.split(" ");
      return date[0] + " " + date[1] + " " + date[2];
    },
  },
};
</script>
<style scoped>
.sales-details-page {
}
.fonts {
  font-size: 12px;
}
</style>
