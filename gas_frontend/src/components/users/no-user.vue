<template>
  <div class="main-container">
    <div class="d-flex align-start justify-start">
      <v-icon>mdi-chevron-left</v-icon> <span>Back</span>
    </div>
    <div class="d-flex align-center justify-center mt-16">
      <div>
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
        <div class="mt-5 ml-16">
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
  methods: {
    goToAddNewUser() {
      this.$router.push("/new-user");
    },
  },
};
</script>
<style scoped>
.fonts {
  font-size: 12px;
}
.btn-create {
  background-color: #464646 !important;
  color: #fff;
  min-width: 300px !important;
  border-radius: 8px !important;
  cursor: pointer;
}
</style>
