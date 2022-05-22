<template>
  <div>
      <ResetMessage />
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    ResetMessage :()=>import("../../components/Auth/resetMessage.vue")
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
