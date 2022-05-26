<template>
  <div>
    <div class="d-flex">
      <div> <Customers /></div>
    </div>
     
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    Customers :()=>import("../../components/customers/customers.vue"),
   
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
