<template>
    <div class="app-container">
      <nav v-if="isAuthenticated" class="navbar">
        <div class="brand">Wardrobe Manager</div>
        <div class="nav-actions">
          <button class="logout-btn" @click="logout">Logout</button>
        </div>
      </nav>
      
      <main>
        <LoginRegister v-if="!isAuthenticated" @login-success="handleLoginSuccess" />
        <WardrobeManager v-else />
      </main>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import LoginRegister from './components/LoginRegister.vue';
  import WardrobeManager from './components/WardrobeManager.vue';
  import axios from 'axios';
  
  export default {
    components: {
      LoginRegister,
      WardrobeManager
    },
    setup() {
      const isAuthenticated = ref(false);
      
      onMounted(() => {
        const token = localStorage.getItem('token');
        if (token) {
          isAuthenticated.value = true;
          // Set the token for all future axios requests
          axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        }
      });
      
      const handleLoginSuccess = () => {
        isAuthenticated.value = true;
      };
      
      const logout = async () => {
        try {
          await axios.post('/api/logout');
          localStorage.removeItem('token');
          isAuthenticated.value = false;
          axios.defaults.headers.common['Authorization'] = '';
        } catch (error) {
          console.error('Logout error:', error);
        }
      };
      
      return {
        isAuthenticated,
        handleLoginSuccess,
        logout
      };
    }
  }
  </script>
  
  <style>
  .app-container {
    font-family: 'Roboto', sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
  }
  
  .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    margin-bottom: 2rem;
    border-bottom: 1px solid #e2e8f0;
  }
  
  .brand {
    font-size: 1.5rem;
    font-weight: bold;
  }
  
  .logout-btn {
    background-color: #e53e3e;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    cursor: pointer;
  }
  
  main {
    min-height: 80vh;
  }
  
  @media (max-width: 768px) {
    .app-container {
      padding: 0.5rem;
    }
  }
  </style>