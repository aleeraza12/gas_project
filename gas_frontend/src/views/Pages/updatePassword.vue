<template>
  <div>
      <UpdatePassword />
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    UpdatePassword :()=>import("../../components/Auth/updatePassword.vue")
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
