<template>
    <div class="d-flex">
      <div>
        <Sidebar />
      </div>
       <v-main>
         <v-container fluid>
       <router-view></router-view>
      </v-container>
</v-main>

    </div>
  
</template>

<script>
export default {
  name: "AppLayout",
  components: {
    Sidebar:()=>import("../sidebar/sidebar.vue")
  }
};
</script>
<style scoped>

</style>