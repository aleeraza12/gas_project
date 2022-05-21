<template>
  <div>
      <LoginUser />
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    LoginUser :()=>import("../../components/Auth/LoginUser.vue")
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
