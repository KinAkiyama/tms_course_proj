<template>
  <div class="container auth-container">
    <div class="form-singup w-100 m-auto p-4">
      <h2 class="h3 mb-3 fw-semibold text-center pb-3">Sign up</h2>
      <form @submit.prevent="register">
        <div class="form-floating">
          <input type="email" v-model="email" class="form-control" id="floatingInput" placeholder="Email address" required/>
          <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
          <input type="text" v-model="username" class="form-control" id="floatingInput" placeholder="Username" required/>
          <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
          <input type="password" v-model="password" class="form-control password-input" id="floatingInput" placeholder="Password" required/>
          <label for="floatingInput">Password</label>
        </div>
        <div class="form-floating">
          <input type="password" v-model="password_confirmation" class="form-control confirm-password-input" id="floatingInput" placeholder="Confirm password" required/>
          <label for="floatingInput">Confirm password</label>
        </div>
        <button class="btn fs-4 fw-bold w-100 py-2" type="submit">Register</button>
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
      username: '',
      password: '',
      password_confirmation: '',
      error: null,
    };
  },
  methods: {
    async register() {
      try {
        const response = await axios.post('/api/register', {
          email: this.email,
          username: this.username,
          password: this.password,
          password_confirmation: this.password_confirmation,
        });

        alert('Registration successful!');
        this.$router.push('/login');
      } catch (error) {
        if (error.response) {
          this.error = error.response.data.message || 'Response error';
        } else {
          this.error = 'Network error';
        }
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
