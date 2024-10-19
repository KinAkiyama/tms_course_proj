<template>
    <Navbar />
    <router-view></router-view>
  </template>
  
  <script>
  import Register from './Register.vue';
  import Login from './Login.vue';
  import Navbar from './Navbar.vue';
  import Titels from './Titels.vue';
  import TitelDetail from './TitelDetail.vue';
  
  export default {
    components: {
      Register,
      Login,
      Navbar,
      Titels,
      TitelDetail,
    },
  };
  </script>
  