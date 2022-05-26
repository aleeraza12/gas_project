<template>
  <div>
    <div class="d-flex">
      <div> <Purchases /></div>
    </div>
     
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    Purchases :()=>import("../../components/purchases/purchases.vue"),
   
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
