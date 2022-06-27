<template>
  <section class="page_404">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-10 col-sm-offset-1 text-center">
            <div class="four_zero_four_bg">
              <h1 class="text-center">404</h1>
            </div>

            <div class="contant_box_404">
              <h3 class="h2">Look like you're lost</h3>

              <p>the page you are looking for not avaible!</p>

              <v-btn
                @click="$router.push('/dashboard')"
                small
                dense
                style="
                  background-color: #2e3995 !important;
                  color: #fff;

                  cursor: pointer;
                "
                >Go Back</v-btn
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import axios from "axios";
//import { mapGetters } from "vuex";
export default {
  data() {
    return {};
  },
  mounted() {
    if (this.$router.history.current.path == "/logout") this.Logout();
  },
  methods: {
    Logout() {
      this.$router.push("login");
      let url = this.$store.state.url;
      let requestBody = {
        token: localStorage.getItem("token"),
      };
      axios.post(url + "logout", requestBody).then(() => {
        localStorage.removeItem("token");
        localStorage.removeItem("user");
      });
    },
  },
};
</script>

<style>
/*======================
    404 page
=======================*/

.page_404 {
  padding: 40px 0;
  background: #fff;
  font-family: "Arvo", serif;
}

.page_404 img {
  width: 100%;
}

.four_zero_four_bg {
  background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
  height: 400px;
  background-position: center;
}

.four_zero_four_bg h1 {
  font-size: 80px;
}

.four_zero_four_bg h3 {
  font-size: 80px;
}

.link_404 {
  color: #fff !important;
  padding: 10px 20px;
  background: #39ac31;
  margin: 20px 0;
  display: inline-block;
}
.contant_box_404 {
  margin-top: -50px;
}
</style>
