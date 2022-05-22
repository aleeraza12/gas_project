<template>
  <div>
    <div class="d-flex">
      <div> <Sidebar/> </div>
      <div> <Dashboard /></div>
    </div>
     
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    Dashboard :()=>import("../../components/Dashboard/dashboard.vue"),
   
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
