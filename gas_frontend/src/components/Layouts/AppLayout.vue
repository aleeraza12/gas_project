<template>
    <div class="d-flex">
      <div>
        <Sidebar />
      </div>
      <div class="mx-16 mt-5" style="width:100%">
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