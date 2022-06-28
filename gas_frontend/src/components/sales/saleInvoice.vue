<template>
  <div class="main-container d-flex align-center justify-center" id="printAble">
    <v-card class="elevation-1" width="700">
      <v-card-text>
        <div class="sales-details-page">
          <div class="d-flex align-start justify-start" @click="goToSales()">
            <v-icon color="#2e3995" class="no-print">mdi-chevron-left</v-icon>
            <span style="color: #2e3995" class="no-print">Back</span>
          </div>
          <div class="d-flex mt-3 pa-5">
            <div>
              <v-avatar
                size="60px"
                v-if="getSingleReceipt.company_profile_picture"
              >
                <img
                  height="45"
                  width="45"
                  style="border-radius: 50%"
                  :src="
                    'data:image/jpeg;base64,' +
                    getSingleReceipt.company_profile_picture
                  "
                />
              </v-avatar>
              <v-icon class="ml-10" size="80" color="#EBEBEA" v-else>
                mdi-circle</v-icon
              >
            </div>

            <v-spacer></v-spacer>
            <div class="mr-5">
              <div>
                <b>{{ getSingleReceipt.updated_by }}</b>
              </div>
              <div class="fonts">
                <b>{{ getSingleReceipt.company_address }}</b>
              </div>
              <!--<div class="fonts">015980000045</div>-->
            </div>
          </div>
          <div class="mb-3"><b>Sales Recepit</b></div>
          <v-divider></v-divider>
          <div
            class="d-flex align-start justify-start ma-5"
            style="font-size: 16px; font-weight: 600"
          >
            Customer Details
          </div>
          <div class="d-flex">
            <div class="ml-5 mt-3">
              <!--<div class="d-flex align-start justify-start fonts">
                distributor
              </div>-->
              <div class="d-flex align-start justify-start fonts">
                <b> Customer Name:</b>
                <b class="ml-2">{{ getSingleReceipt.customer_name }}</b>
              </div>
              <div class="d-flex align-start justify-start fonts">
                <b> Customer Phone#:</b>
                <b class="ml-2">
                  {{ getSingleReceipt.customer_phone_number }}</b
                >
              </div>
              <div class="d-flex align-start justify-start fonts">
                <b> Customer Address:</b>
                <b class="ml-2">{{ getSingleReceipt.customer_address }}</b>
              </div>
            </div>
            <v-spacer></v-spacer>
            <div class="mr-8 mt-3">
              <div class="font-weight-bold">Transcation Id</div>

              00000{{ getSingleReceipt.transaction_id }}

              <div class="font-weight-bold">
                {{ getDate(getSingleReceipt.created_at) }}
              </div>
            </div>
          </div>

          <div class="d-flex" style="background-color: #ebebea">
            <div class="ml-5 mt-3">
              <div class="d-flex">
                <div class="font-weight-bold"><b>Payment Method:</b></div>
                <div class="font-weight-bold ml-2">
                  {{ getSingleReceipt.payment_mode }}
                </div>
              </div>
            </div>
            <v-spacer></v-spacer>
            <div class="mr-8 mt-3">
              <div class="font-weight-bold">Amount</div>
              <div class="font-weight-bold">
                {{ getSingleReceipt.total_amount }}
              </div>
            </div>
          </div>
          <div class="mt-3">
            <v-simple-table>
              <template v-slot:default>
                <thead style="background-color: #2e3995">
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
                    <th class="text-left" style="color: #fff; font-size: 12px">
                      After Discount(N)
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
                    <td class="text-left">
                      {{ getSingleReceipt.discounted_amount }}
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </div>
          <v-divider class="no-print"></v-divider>
          <div
            class="mt-5"
            style="width: 300px; float: right; margin-top: 20px"
          >
            <div class="d-flex pa-2" style="background-color: #f6f6f5">
              <div class="font-weight-bold">Total Amount</div>
              <div class="ml-5 font-weight-bold">
                {{ getSingleReceipt.total_amount }}
              </div>
            </div>
            <div class="d-flex pa-2" style="background-color: #ebebea">
              <div class="font-weight-bold">Amount Paid</div>
              <div class="ml-5 font-weight-bold">
                {{ getSingleReceipt.total_amount }}
              </div>
            </div>
            <div class="d-flex pa-2" style="background-color: #f6f6f5">
              <div class="font-weight-bold">Promo</div>
              <div class="ml-15 font-weight-bold">
                {{
                  getSingleReceipt.discount_code != null
                    ? getSingleReceipt.discount_code
                    : "No"
                }}
              </div>
            </div>
          </div>
          <div
            class="d-flex align-center justify-center no-print"
            style="margin-top: 10rem"
          >
            <b class="no-print">Powered By GA3QSD</b>
          </div>
          <div class="d-flex align-center justify-center mt-3 no-print">
            <v-btn
              @click="print"
              small
              dense
              class="no-print"
              style="
                background-color: #2e3995 !important;
                color: #fff;
                min-width: 150px !important;
                border-radius: 20px !important;
                cursor: pointer;
              "
            >
              <span class="no-print">Print</span></v-btn
            >
          </div>
        </div>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {};
  },
  computed: {
    ...mapGetters(["getSingleReceipt"]),
  },
  mounted() {
    if (this.getSingleReceipt.length == 0) {
      this.$router.push("/sales");
    }
  },
  methods: {
    print() {
      // Pass the element id here
      //      const prtHtml = document.getElementById("printAble").innerHTML;

      //      // Get all stylesheets HTML
      //      let stylesHtml = "";
      //      for (const node of [
      //        ...document.querySelectorAll('link[rel="stylesheet"], style'),
      //      ]) {
      //        stylesHtml += node.outerHTML;
      //      }

      //      // Open the print window
      //      const WinPrint = window.open(
      //        "",
      //        "",
      //        "left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0"
      //      );

      //      WinPrint.document.write(`<!DOCTYPE html>
      //<html>
      //  <head>
      //    ${stylesHtml}
      //  </head>
      //  <body>
      //    ${prtHtml}
      //  </body>
      //</html>`);

      //window.document.close();
      //window.focus();
      //window.print();

      ////document.execCommand("print", false, null);

      //window.close();
      try {
        // Print for chrome browser
        window.print();
      } catch {
        document.execCommand("print", false, null);
      }
    },
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
@media print {
  .no-print,
  .no-print * {
    display: none !important;
  }
}
</style>
<style>
@media print {
  .no-print,
  .no-print * {
    display: none !important;
  }
}
</style>
