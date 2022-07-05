<template>
  <div>
    <div
      :class="
        $vuetify.breakpoint.xs || $vuetify.breakpoint.sm
          ? 'flex-column justify-center'
          : 'align-center'
      "
      class="d-flex mt-2 mb-2 px-1"
    >
      <v-spacer></v-spacer>
      <v-menu min-width="230" nudge-bottom="6px" offset-y>
        <template v-slot:activator="{ on, attrs }">
          <div v-on="on" v-bind="attrs">
            <v-tooltip bottom color="#ffe7b8">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  depressed
                  light
                  v-on="on"
                  v-bind="attrs"
                  outlined
                  :ripple="false"
                  height="5px"
                  x-small
                  dense
                  style="background-color: rgb(235, 235, 234); color: #fff"
                  class="text-capitalize pa-4"
                >
                  <span class="black--text"
                    >{{ getSelectedDateRange }}
                    <v-icon small dense color="black">mdi-chevron-down</v-icon>
                  </span>
                  <!-- <v-icon size="20" color="white">mdi-calendar</v-icon> -->
                  <v-badge
                    v-if="getSelectedDateRange"
                    class="mb-6"
                    color="#2e3995"
                    dot
                    style="margin-right: -10px"
                  ></v-badge>
                </v-btn>
              </template>
              <span class="black--text">{{ getSelectedDateRange }}</span>
            </v-tooltip>
          </div>
        </template>
        <div>
          <v-list>
            <div
              v-for="list of dateRange"
              :key="list.value"
              class="date-range-dropdown pointer d-flex pa-2"
              :class="
                getSelectedDateRange == list.title ? 'slectedDateRange' : ''
              "
              @click="selectDate(list.value)"
            >
              <div class="date-range-text-color">{{ list.title }}</div>
              <v-spacer></v-spacer>
              <v-icon
                size="20"
                color="#2e3995"
                v-if="getSelectedDateRange == list.title"
              >
                mdi-checkbox-marked</v-icon
              >
            </div>
          </v-list>
        </div>
      </v-menu>
    </div>
    <v-dialog ref="dateModal" v-model="dateModal" persistent width="290px">
      <v-date-picker
        color="#2e3995"
        v-model="picker"
        no-title
        scrollable
        multiple
        :range="true"
        min="2022-01-01"
        :max="new Date().toISOString().substr(0, 10)"
      >
        <v-spacer></v-spacer>
        <v-btn color="#2e3995" outlined @click="dateModal = false" x-small>
          Cancel
        </v-btn>
        <v-btn
          color="#2e3995"
          dark
          x-small
          @click="
            dateModal = false;
            applyCustomRange(picker);
          "
        >
          OK
        </v-btn>
      </v-date-picker>
    </v-dialog>
  </div>
</template>
<script>
import { eventBus } from "@/main";
import { mapGetters } from "vuex";
import moment from "moment";
export default {
  data() {
    return {
      dateRange: [
        { title: "All", value: "all" },
        { title: "Today", value: "today" },
        { title: "Yesterday", value: "yesterday" },
        { title: "Last 7 days", value: "last_seven_days" },
        { title: "Last 30 days", value: "last_thirty_days" },
        { title: "This Month", value: "this_month" },
        { title: "Last Month", value: "last_month" },
        { title: "Custom Range", value: "custom_range" },
      ],
      slectedRange: "today",
      dateModal: false,
      dateRangeText: "Today",
      tableSearch: "",
      picker: [new Date().toISOString().substr(0, 10)],
      start_date: "",
      end_date: "",
    };
  },
  computed: { ...mapGetters(["getSelectedDateRange"]) },
  watch: {},
  methods: {
    /* * @Description
     *This function used to select date.
     * @param Date_data (title) * @return void */
    selectDate(Date_data) {
      if (Date_data == "today") {
        this.slectedRange = "today";
        this.dateRangeText = "Today";
        this.$store.commit("setSelectedDateRange", this.dateRangeText);
        this.picker = [
          moment().format("YYYY-MM-DD"),
          moment().format("YYYY-MM-DD"),
        ];
        this.callselectedDateEmit();
      } else if (Date_data == "yesterday") {
        this.dateRangeText = "Yesterday";
        this.slectedRange = "yesterday";
        this.$store.commit("setSelectedDateRange", this.dateRangeText);
        this.picker = [
          moment().subtract(1, "days").format("YYYY-MM-DD"),
          moment().subtract(1, "days").format("YYYY-MM-DD"),
        ];
        this.callselectedDateEmit();
      } else if (Date_data == "last_seven_days") {
        this.dateRangeText = "Last 7 days";
        this.slectedRange = Date_data;
        this.$store.commit("setSelectedDateRange", this.dateRangeText);
        this.picker = [
          moment().subtract(6, "days").format("YYYY-MM-DD"),
          moment().format("YYYY-MM-DD"),
        ];
        this.callselectedDateEmit();
      } else if (Date_data == "last_thirty_days") {
        this.dateRangeText = "Last 30 days";
        this.slectedRange = Date_data;
        this.$store.commit("setSelectedDateRange", this.dateRangeText);
        this.picker = [
          moment().subtract(29, "days").format("YYYY-MM-DD"),
          moment().format("YYYY-MM-DD"),
        ];
        this.callselectedDateEmit();
      } else if (Date_data == "this_month") {
        this.dateRangeText = "This Month";
        this.slectedRange = Date_data;
        this.$store.commit("setSelectedDateRange", this.dateRangeText);
        this.picker = [
          moment().startOf("month").format("YYYY-MM-DD"),
          moment().endOf("month").format("YYYY-MM-DD"),
        ];
        this.callselectedDateEmit();
      } else if (Date_data == "last_month") {
        this.dateRangeText = "Last Month";
        this.slectedRange = Date_data;
        this.$store.commit("setSelectedDateRange", this.dateRangeText);
        this.picker = [
          moment().subtract(1, "month").startOf("month").format("YYYY-MM-DD"),
          moment().subtract(1, "month").endOf("month").format("YYYY-MM-DD"),
        ];
        this.callselectedDateEmit();
      } else if (Date_data == "all") {
        this.dateRangeText = "All";
        this.slectedRange = Date_data;
        this.$store.commit("setSelectedDateRange", this.dateRangeText);
        this.picker = ["2022-01-01", moment().format("YYYY-MM-DD")];
        this.callselectedDateEmit();
      } else if (Date_data == "custom_range") {
        this.selectedRange = Date_data;
        this.dateRangeText = "Custom Range";
        this.$store.commit("setSelectedDateRange", this.dateRangeText);
        this.dateModal = true;
      }
    },

    applyCustomRange(picker) {
      if (picker && picker.length === 1) {
        let temp = picker;
        this.start_date = picker[0];
        this.end_date = temp[0];
        this.picker[1] = temp[0];
      } else {
        this.start_date = picker[0];
        this.end_date = picker[1];
      }
      this.slectedRange = "custom_range";
      this.dateRangeText = this.start_date + " - " + this.end_date;
      this.$store.commit("setSelectedDateRange", this.dateRangeText);
      this.$route && this.$route.path == "/dashboard"
        ? eventBus.$emit("selectedDashboardDateFilter", this.picker)
        : this.$route && this.$route.path == "/orders"
        ? eventBus.$emit("selectedOrdersDateFilter", this.picker)
        : this.$route && this.$route.path == "/users"
        ? eventBus.$emit("selectedUsersDateFilter", this.picker)
        : this.$route && this.$route.path == "/customers"
        ? eventBus.$emit("selectedCustomersDateFilter", this.picker)
        : this.$route && this.$route.path == "/sales"
        ? eventBus.$emit("selectedSalesDateFilter", this.picker)
        : this.$route && this.$route.path == "/purchases"
        ? eventBus.$emit("selectedPurchasesDateFilter", this.picker)
        : this.$route && this.$route.path == "/reconcilation"
        ? eventBus.$emit("selectedReconcilationDateFilter", this.picker)
        : this.$route && this.$route.path == "/wallet"
        ? eventBus.$emit("selectedWalletDateFilter", this.picker)
        : this.$route && this.$route.path == "/companies"
        ? eventBus.$emit("selectedCompanyDateFilter", this.picker)
        : this.$route && this.$route.path == "/promos"
        ? eventBus.$emit("selectedPromoDateFilter", this.picker)
        : this.$route && this.$route.path == "/rate_list"
        ? eventBus.$emit("selectedRateListDateFilter", this.picker)
        : () => {};
    },
    /* * @Description
     * This function used to get emit data from other components.
     * @param none * @return void */
    callselectedDateEmit() {
      this.$route && this.$route.path == "/dashboard"
        ? eventBus.$emit("selectedDashboardDateFilter", this.picker)
        : this.$route && this.$route.path == "/orders"
        ? eventBus.$emit("selectedOrdersDateFilter", this.picker)
        : this.$route && this.$route.path == "/users"
        ? eventBus.$emit("selectedUsersDateFilter", this.picker)
        : this.$route && this.$route.path == "/customers"
        ? eventBus.$emit("selectedCustomersDateFilter", this.picker)
        : this.$route && this.$route.path == "/sales"
        ? eventBus.$emit("selectedSalesDateFilter", this.picker)
        : this.$route && this.$route.path == "/purchases"
        ? eventBus.$emit("selectedPurchasesDateFilter", this.picker)
        : this.$route && this.$route.path == "/reconcilation"
        ? eventBus.$emit("selectedReconcilationDateFilter", this.picker)
        : this.$route && this.$route.path == "/wallet"
        ? eventBus.$emit("selectedWalletDateFilter", this.picker)
        : this.$route && this.$route.path == "/companies"
        ? eventBus.$emit("selectedCompanyDateFilter", this.picker)
        : this.$route && this.$route.path == "/promos"
        ? eventBus.$emit("selectedPromoDateFilter", this.picker)
        : this.$route && this.$route.path == "/rate_list"
        ? eventBus.$emit("selectedRateListDateFilter", this.picker)
        : () => {};
    },
  },
  mounted() {
    this.slectedRange = "today";
    this.dateRangeText = "Today";
  },
};
</script>
<style scoped>
.pointer {
  cursor: pointer;
}
</style>
<style>
.date-range-dropdown:hover {
  background-color: #f7f7f7;
  color: #cccfce !important ;
}
.date-range-text-color {
  font-size: 14px;
  font-style: Roboto Medium;
}
.date-range-text-color:hover {
  color: #8a918f !important;
}
.date-range-dropdown {
  max-height: 35px;
  min-width: 150px;
}
</style>
