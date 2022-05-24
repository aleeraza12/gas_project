<template>
    <div class="d-flex">
      <div>
        <Sidebar />
      </div>
      <div class="" style="width:100vw">
        <router-view></router-view>
    </div>
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