<template>
  <div>
    <div class="d-flex">
      <div> <Orders /></div>
    </div>
     
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    Orders :()=>import("../../components/orders/orders.vue"),
   
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
