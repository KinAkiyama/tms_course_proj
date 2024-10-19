<template>
    <div class="container auth-container">
      <div class="form-singup w-100 m-auto">
        <h2 class="h3 mb-3 fw-normal text-center">Sign in</h2>
        <form @submit.prevent="login">
          <div class="form-floating">
            <input type="email" v-model="email" class="form-control" id="floatingInput" placeholder="Email address" required/>
            <label for="floatingInput">Email address</label>
          </div>
          <div class="form-floating">
            <input type="password" v-model="password" class="form-control password-input" id="floatingInput" placeholder="Password" required/>
            <label for="floatingInput">Password</label>
          </div>
          <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
        </form>
    
        <div v-if="error" class="error">{{ error }}</div>
      </div>
    </div>
  </template>
  
  <script>
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
          const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              email: this.email,
              password: this.password,
            }),
          });
  
          if (!response.ok) {
            const data = await response.json();
            this.error = data.message || 'Response error';
          } else {
          const data = await response.json();
          const token = data.token;
          localStorage.setItem('token', token);

          this.$router.push('/home');
          }
        } catch (error) {
          this.error = 'Network error';
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .error {
    color: red;
  }
  </style>