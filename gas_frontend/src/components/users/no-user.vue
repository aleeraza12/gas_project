<template>
  <div class="main-container">
    <div
      class="d-flex align-start justify-start mt-7"
      @click="goToPreviousPage()"
    >
      <v-icon color="#2e3995">mdi-chevron-left</v-icon>
      <span style="color: #2e3995">Back</span>
    </div>
    <div class="d-flex align-center justify-center mt-16">
      <div style="margin-top: 6rem">
        <img
          height="150px"
          width="150px"
          src="../../assets/images/bg.png"
          style="position: absolute"
        />
        <img
          height="150px"
          width="150px"
          src="../../assets/images/no-data.png"
          style="position: relative"
        />
        <div class="fonts">
          Sorry, you have not yet created any user <br />
          Kindly add new user to begin
        </div>
        <div class="mt-5">
          <v-btn
            small
            dense
            class="elevation-0 btn-create"
            :loading="loading"
            @click="goToAddNewUser()"
          >
            Create New User
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
  computed: {
    ...mapGetters(["getUsers"]),
  },
  methods: {
    goToAddNewUser() {
      this.$router.push("/new-user");
    },
    goToPreviousPage() {
      if (this.getUsers.length == 0) {
        console.log("prevos route");
        this.$router.push("/orders");
      } else this.$router.push("/users");
    },
  },
};
</script>
<style scoped>
.fonts {
  font-size: 12px;
}
.btn-create {
  /*background-color: #464646 !important;
  color: #fff;
  min-width: 250px !important;
  border-radius: 8px !important;
  cursor: pointer;*/
  min-height: 40px;
  background-color: #2e3995 !important;
  color: #fff;
  min-width: 250px !important;
  border-radius: 20px !important;
  cursor: pointer;
  /*margin-right: 8rem;*/
}
</style>
