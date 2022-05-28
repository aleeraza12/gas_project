<template>
  <div>
    <div class="d-flex">
      <div> <Wallet /></div>
    </div>
     
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    Wallet :()=>import("../../components/wallet/wallet.vue"),
   
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
