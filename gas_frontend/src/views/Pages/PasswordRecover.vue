<template>
  <div>
      <RecoverPassowrd />
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    RecoverPassowrd :()=>import("../../components/Auth/passwordRecover.vue")
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
