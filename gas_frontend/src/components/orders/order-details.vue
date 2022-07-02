<template>
  <div class="main-container">
    <div class="sales-details-page" id="printAble">
      <div class="d-flex">
        <div>
          <v-icon class="ml-3 mt-3 no-print" @click="goToOrders()">
            mdi-close</v-icon
          >
        </div>
      </div>
      <div class="mt-6"><b>Orders Details</b></div>
      <v-divider class="ml-5 mr-5 mt-2"></v-divider>
      <div class="d-flex mt-5">
        <div class="ml-10">
          <v-chip
            dense
            label
            class="pa-3"
            style="background-color: #ebffef; color: #5fba7e"
          >
            <v-icon size="10" color="#5FBA7E" class="mr-4">mdi-circle</v-icon>
            {{ getSinglePurchase.status }}
          </v-chip>
        </div>

        <v-spacer></v-spacer>
        <div class="mr-10 fonts">
          <div>
            <b>{{ getDate(getSinglePurchase.created_at) }}</b>
          </div>
          <div>{{ getTme(getSinglePurchase.created_at) }}</div>
        </div>
      </div>
      <div
        class="d-flex align-start justify-start ml-5 mt-5"
        style="font-size: 16px; font-weight: 600"
      >
        Customer Info
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-3">
          <div class="d-flex align-start justify-start fonts">Distributor</div>
          <div class="d-flex align-start justify-start">
            <b>{{ getSinglePurchase.customer_name }}</b>
          </div>
          <!--<div class="d-flex align-start justify-start fonst">04566000433</div>-->
          <div class="d-flex align-start justify-start fonts">
            {{ getSinglePurchase.company_address }}
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-3">
          <div class="fonts">Order Id</div>
          <div class="fonts">{{ getSinglePurchase.order_id }}</div>
        </div>
      </div>
      <div class="mt-5 d-flex align-start justify-start ml-5">
        <b>Order Info</b>
      </div>
      <div class="d-flex">
        <div class="ml-5 mt-3">
          <div class="d-flex">
            <div class="fonts"><b>Unit Gas Price:</b></div>
            <div class="fonts">N {{ getSinglePurchase.unit_price }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Total Amount:</b></div>
            <div class="fonts">N{{ getSinglePurchase.amount }}</div>
          </div>
          <div class="d-flex">
            <div class="fonts"><b>Payment Mode:</b></div>
            <div class="fonts">{{ getSinglePurchase.payment_mode }}</div>
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="mr-8 mt-3">
          <div class="fonts">Gas Quanity : 12</div>
          <div class="fonts">{{ getSinglePurchase.gas_quantity }}</div>
        </div>
        <div class="mr-8 mt-3">
          <div class="fonts">Updated By</div>
          <div class="fonts">{{ getSinglePurchase.company_name }}</div>
        </div>
      </div>
      <div class="mt-5 mb-5 ml-5 d-flex justify-start align-start">
        <b>Status History</b>
      </div>
      <div class="fonts mt-3 mb-5">
        <div class="d-flex align-start justify-start ml-3">
          <v-radio
            label="Delivered"
            color="primary"
            value="Delivered"
          ></v-radio>
        </div>
        <div class="d-flex align-start justify-start ml-8">
          {{ getSinglePurchase.updated_at }}
        </div>
      </div>
      <div>
        <v-btn
          class="mt-3 btn-delivered text-capitalize no-print"
          @click="print()"
        >
          Print
        </v-btn>
      </div>
      <div>
        <v-btn
          outlined
          class="mt-3 btn-delete text-capitalize no-print"
          @click="dialog = true"
          color="red"
        >
          Delete
        </v-btn>
      </div>
    </div>
    <v-dialog v-model="dialog" persistent max-width="390">
      <v-card>
        <v-card-title class="text-h7">
          Are you sure to delete this order?
        </v-card-title>
        <v-card-text>By deleting,it will removed permanently.</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color=" black" small text @click="dialog = false">
            Cancel
          </v-btn>
          <v-btn color="red darken-1" small text @click="deleteItem()">
            Delete
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-snackbar
      v-model="snackbar"
      :timeout="2000"
      :value="true"
      absolute
      class="mt-5"
      :color="snackbarColor"
      shaped
      :right="true"
      :top="true"
      text
    >
      <v-icon class="pr-3" :color="snackbarColor">{{ getIcon }} </v-icon>
      {{ snacbarMessage }}
    </v-snackbar>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import RequestService from "../../RequestService";
// import { eventBus } from "@/main";
// import moment from "moment";

export default {
  data: () => ({
    dialog: false,
    snacbarMessage: "",
    snackbar: false,
    snackbarColor: "",
  }),
  components: {},
  mounted() {
    if (this.getSinglePurchase.length == 0) this.$router.push("/dashboard");
  },
  created() {},
  methods: {
    print() {
      try {
        // Print for chrome browser
        window.print();
      } catch {
        document.execCommand("print", false, null);
      }
    },

    goToOrders() {
      this.$router.push("Orders");
    },
    getDate(item) {
      let date = item.split(" ");
      return date[0] + " " + date[1] + " " + date[2];
    },
    getTme(item) {
      let date = item.split(" ");
      return date[3] + date[4];
      //return moment(time, "HH:mm:ss").format("hh:mm a");
    },
    deleteItem() {
      this.dialog = false;
      let requestBody = {
        order_id: this.getSinglePurchase.id,
      };
      RequestService.post("order/delete", requestBody).then((response) => {
        if (response.data.status == 200) {
          this.snackbar = true;
          this.snackbarColor = "success";
          this.snacbarMessage = "Your order deleted successfully";
          setTimeout(() => {
            this.$router.push("/dashboard");
          }, 1500);
        }
      });
    },
  },
  computed: {
    ...mapGetters(["getSinglePurchase"]),
    getIcon() {
      return this.snackbarColor == "primary"
        ? "mdi-checkbox-marked-circle"
        : "mdi-close-circle";
    },
  },
};
</script>
<style scoped>
.sales-details-page {
  height: 650px;
  width: 600px;
  background-color: #ebebea;
  margin-left: 12rem;
}
.fonts {
  font-size: 12px;
}

.btn-delivered {
  min-height: 35px;
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 220px !important;
  border-radius: 20px !important;
  cursor: pointer;
}
.btn-delete {
  min-height: 35px;
  /*background-color: red !important;*/
  /*color: red;*/
  min-width: 220px !important;
  border-radius: 20px !important;
  cursor: pointer;
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
