<template>
  <div>
     <Orders />
     
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
