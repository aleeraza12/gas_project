<template>
  <div class="main-container d-flex align-center justify-center" id="printAble">
    <v-card class="elevation-1" width="700">
      <v-card-text>
        <div class="sales-details-page">
          <div
            class="d-flex align-start justify-start no-print"
            @click="goToSales()"
          >
            <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
          </div>
          <div class="d-flex mt-3 pa-5">
            <div>
              <v-avatar
                size="60px"
                v-if="getSingleReceipt.company_profile_picture"
              >
                <img
                  height="100"
                  width="100"
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
              <!--<div><b>LIT Engineers</b></div>-->
              <!--<div class="fonts"><b>18,chokar town auto street 19</b></div>
              <div class="fonts">015980000045</div>-->
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
                <div class="fonts"><b>Payment Method:</b></div>
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
          <div class="mt-5" style="width: 300px; float: right">
            <div class="d-flex pa-2" style="background-color: #f6f6f5">
              <div>Total Amount</div>
              <div class="ml-5">{{ getSingleReceipt.total_amount }}</div>
            </div>
            <div class="d-flex pa-2" style="background-color: #ebebea">
              <div>Amount Paid</div>
              <div class="ml-5">{{ getSingleReceipt.total_amount }}</div>
            </div>
            <div class="d-flex pa-2" style="background-color: #f6f6f5">
              <div>Balance</div>
              <div class="ml-12">No</div>
            </div>
          </div>
          <div
            class="d-flex align-center justify-center no-print"
            style="margin-top: 10rem"
          >
            <b>Powered By GA3QSD</b>
          </div>
          <div class="d-flex align-center justify-center mt-3">
            <v-btn
              @click="printReceipt('printAble')"
              small
              dense
              class="no-print"
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
    printReceipt(printAble) {
      let prtContent = document.getElementById(printAble).outerHTML;
      let stylesHtml = "";
      for (const node of [
        ...document.querySelectorAll('link[rel="stylesheet"], style'),
      ]) {
        stylesHtml += node.outerHTML;
        console.log(stylesHtml);
      }

      // Open the print window
      let WinPrint = window.open(
        "",
        "",
        "left=0,top=0,width=700,height=900,toolbar=0,scrollbars=0,status=0"
      );

      WinPrint.document.write(`<!DOCTYPE html>
    <html>
    <head>
    ${stylesHtml}
    </head>
    <body>
    ${prtContent}
    </body>
    </html>`);
      setTimeout(() => {
        WinPrint.document.write(prtContent.innerHTML);
        //WinPrint.document.close();
        //WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
      }, 100);
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
.fonts {
  font-size: 12px;
}
@media print {
  .no-print,
  .no-print * {
    display: none !important;
  }
}
/*@page {
  size: auto;
  margin: 0mm;
}*/
</style>
