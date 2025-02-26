import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'

/// Set up axios defaults
axios.defaults.baseURL = import.meta.env.VITE_API_URL || 'http://localhost:8000';
axios.defaults.withCredentials = true;

// Check for token in localStorage and set it in axios headers if it exists
const token = localStorage.getItem('token');
if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

createApp(App).mount('#app')