<template>
    <div class="auth-container">
      <div class="auth-card">
        <div class="auth-tabs">
          <button 
            :class="['tab-btn', { active: activeTab === 'login' }]" 
            @click="activeTab = 'login'"
          >
            Login
          </button>
          <button 
            :class="['tab-btn', { active: activeTab === 'register' }]" 
            @click="activeTab = 'register'"
          >
            Register
          </button>
        </div>
        
        <div v-if="errorMessage" class="error-message">
          {{ errorMessage }}
        </div>
        
        <!-- Login Form -->
        <form v-if="activeTab === 'login'" @submit.prevent="login" class="auth-form">
          <div class="form-group">
            <label for="login-email">Email</label>
            <input 
              id="login-email" 
              type="email" 
              v-model="loginForm.email" 
              required
              placeholder="your@email.com"
            >
          </div>
          
          <div class="form-group">
            <label for="login-password">Password</label>
            <input 
              id="login-password" 
              type="password" 
              v-model="loginForm.password" 
              required
              placeholder="******"
            >
          </div>
          
          <button type="submit" class="submit-btn" :disabled="isLoading">
            {{ isLoading ? 'Logging in...' : 'Login' }}
          </button>
        </form>
        
        <!-- Register Form -->
        <form v-else @submit.prevent="register" class="auth-form">
          <div class="form-group">
            <label for="register-name">Name</label>
            <input 
              id="register-name" 
              type="text" 
              v-model="registerForm.name" 
              required
              placeholder="Your Name"
            >
          </div>
          
          <div class="form-group">
            <label for="register-email">Email</label>
            <input 
              id="register-email" 
              type="email" 
              v-model="registerForm.email" 
              required
              placeholder="your@email.com"
            >
          </div>
          
          <div class="form-group">
            <label for="register-password">Password</label>
            <input 
              id="register-password" 
              type="password" 
              v-model="registerForm.password" 
              required
              placeholder="******"
              minlength="8"
            >
          </div>
          
          <div class="form-group">
            <label for="register-password-confirmation">Confirm Password</label>
            <input 
              id="register-password-confirmation" 
              type="password" 
              v-model="registerForm.password_confirmation" 
              required
              placeholder="******"
            >
          </div>
          
          <button type="submit" class="submit-btn" :disabled="isLoading">
            {{ isLoading ? 'Creating account...' : 'Register' }}
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import { ref, reactive } from 'vue';
  import axios from 'axios';
  
  export default {
    emits: ['login-success'],
    setup(props, { emit }) {
      const activeTab = ref('login');
      const isLoading = ref(false);
      const errorMessage = ref('');
      
      const loginForm = reactive({
        email: '',
        password: ''
      });
      
      const registerForm = reactive({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      });
      
      const login = async () => {
        try {
          isLoading.value = true;
          errorMessage.value = '';
          
          const response = await axios.post('/api/login', loginForm);
          const { token } = response.data;
          
          // Store token and set axios default authorization header
          localStorage.setItem('token', token);
          axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
          
          emit('login-success');
        } catch (error) {
          if (error.response && error.response.data.message) {
            errorMessage.value = error.response.data.message;
          } else {
            errorMessage.value = 'An error occurred during login. Please try again.';
          }
        } finally {
          isLoading.value = false;
        }
      };
      
      const register = async () => {
        // Check if passwords match
        if (registerForm.password !== registerForm.password_confirmation) {
          errorMessage.value = 'Passwords do not match';
          return;
        }
        
        try {
          isLoading.value = true;
          errorMessage.value = '';
          
          const response = await axios.post('/api/register', registerForm);
          const { token } = response.data;
          
          // Store token and set axios default authorization header
          localStorage.setItem('token', token);
          axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
          
          emit('login-success');
        } catch (error) {
          if (error.response && error.response.data.message) {
            errorMessage.value = error.response.data.message;
          } else if (error.response && error.response.data.errors) {
            // Format validation errors
            const errors = error.response.data.errors;
            const firstError = Object.values(errors)[0][0];
            errorMessage.value = firstError;
          } else {
            errorMessage.value = 'An error occurred during registration. Please try again.';
          }
        } finally {
          isLoading.value = false;
        }
      };
      
      return {
        activeTab,
        isLoading,
        errorMessage,
        loginForm,
        registerForm,
        login,
        register
      };
    }
  }
  </script>
  
  <style>
  .auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
  }
  
  .auth-card {
    width: 100%;
    max-width: 450px;
    padding: 2rem;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: white;
  }
  
  .auth-tabs {
    display: flex;
    margin-bottom: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
  }
  
  .tab-btn {
    flex: 1;
    padding: 0.5rem;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.3s ease;
  }
  
  .tab-btn.active {
    border-bottom: 2px solid #4f46e5;
    color: #4f46e5;
    font-weight: bold;
  }
  
  .auth-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  .form-group {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }
  
  .form-group label {
    font-weight: 500;
    font-size: 0.875rem;
  }
  
  .form-group input {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.25rem;
    font-size: 1rem;
  }
  
  .submit-btn {
    margin-top: 1rem;
    padding: 0.75rem;
    background-color: #4f46e5;
    color: white;
    border: none;
    border-radius: 0.25rem;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  .submit-btn:hover:not(:disabled) {
    background-color: #4338ca;
  }
  
  .submit-btn:disabled {
    background-color: #a5b4fc;
    cursor: not-allowed;
  }
  
  .error-message {
    padding: 0.75rem;
    margin-bottom: 1rem;
    background-color: #fee2e2;
    color: #b91c1c;
    border-radius: 0.25rem;
    font-size: 0.875rem;
  }
  
  @media (max-width: 640px) {
    .auth-card {
      padding: 1.5rem;
      max-width: 100%;
      box-shadow: none;
    }
  }
  </style>