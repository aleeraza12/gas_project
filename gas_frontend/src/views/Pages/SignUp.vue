<template>
  <div>
      <Register />
  </div>
</template>
<script>
export default {
  data: () => ({
   
  }),
  components:{
    Register :()=>import("../../components/Auth/Register.vue")
  },
  mounted() {
    
  },
  methods: {
  }
};
</script>
