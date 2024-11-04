<template>
    <div class="container auth-container">
      <div class="form-singup w-100 m-auto p-4">
        <h2 class="h3 mb-3 fw-semibold text-center pb-3">Sign in</h2>
        <form @submit.prevent="login">
          <div class="form-floating">
            <input type="email" v-model="email" class="form-control" id="floatingInput" placeholder="Email address" required/>
            <label for="floatingInput">Email address</label>
          </div>
          <div class="form-floating">
            <input type="password" v-model="password" class="form-control password-input" id="floatingInput" placeholder="Password" required/>
            <label for="floatingInput">Password</label>
          </div>
          <button class="btn fs-4 fw-bold w-100 py-2 mt-2" type="submit">Login</button>
        </form>
    
        <div v-if="error" class="error">{{ error }}</div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        email: '',
        password: '',
        error: null,
      };
    },
    methods: {
      async login() {
        try {
              const response = await axios.post('/api/login', {
                  email: this.email,
                  password: this.password,
              });

              if (response.status !== 200) {
                  this.error = response.data.message || 'Response error';
              } else {
                  const data = response.data;
                  const token = data.token;
                  localStorage.setItem('token', token);
                  localStorage.setItem('user', JSON.stringify(data.user));

                  this.$router.push('/home');
              }
          } catch (error) {
              if (error.response && error.response.data.errors) {
                  this.error = error.response.data.errors;
              } else {
                  this.error = 'Network error';
              }
          }
      }
    },
  };
  </script>
  
  <style scoped>
  .error {
    color: red;
  }
  </style>