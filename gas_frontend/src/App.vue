<template>
  <v-app >
      <div class="d-flex">
      <div>
        <Sidebar />
      </div>
      <div class="mx-4 mt-5" style="width:100vw">
        <router-view></router-view>
    </div>
    </div>
  </v-app>
</template>

<script>
//import { eventBus } from "@/main";
export default {
  name: "App",
  data() {
    return {
    };
  },
  components:{
     Sidebar:()=>import("./components/sidebar/sidebar.vue")
  },
  computed: {},
  watch: {
  },
  
  methods: {},
};
</script>

<style scoped>
body {
  background: white !important;
}
</style>
<style>
</style>