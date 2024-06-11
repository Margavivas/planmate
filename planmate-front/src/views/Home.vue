<template>
    <div>
      <router-view></router-view>
      <signIn></signIn>
      <router-link to="/signUp">SignUp</router-link>
      
    <!-- <router-link to="/signIn">SignIn</router-link> -->
    <!-- <router-link to="/signUp">SignUp</router-link>
    <router-view></router-view> -->
  </div>
    </template>
    
    <script setup>
   // import signUp from '../components/access/SignUp.vue'
   import signIn from '../components/access/SignIn.vue'
    </script>
    
    <style scoped>
    </style>