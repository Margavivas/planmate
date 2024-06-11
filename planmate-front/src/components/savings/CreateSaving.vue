<template>
  <div class="principalContainer createSavingsContainer">
    <h2 class="demiBold">Create a New Saving</h2>
    <p class="content">Start your savings journey with ease on PlanMate! 
      Simply create a new saving, set your goal, and watch as your 
      contributions accumulate over time.</p>
    <form @submit.prevent="saveSavings">
      <div class="inputGroup">
        <label for="name" class="content">Name</label>
        <input type="text" id="name" v-model="savingsData.name" required />
      </div>
      <div class="inputGroup">
        <label for="amount" class="content">Amount</label>
        <input type="number" id="amount" v-model="savingsData.amount" required />
      </div>
      <div class="inputGroup">
        <label for="goal" class="content">Goal</label>
        <input type="number" id="goal" v-model="savingsData.goal" required />
      </div>
      <div class="inputGroup">
        <label for="deadline" class="content">Deadline</label>
        <input type="date" id="deadline" v-model="savingsData.deadline" />
      </div>
      <section class="buttons">
        <button type="submit">Create Savings</button>
        <button type="button" class="back" @click="goBack">back</button>
      </section>
      
    </form>
    
  </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';
import { useAuthStore } from "../../../store/auth";
import { useRouter } from 'vue-router';

export default {
  setup() {
    const authStore = useAuthStore();
    const authToken = ref('');
    const router = useRouter();
    const savingsData = ref({
      name: '',
      amount: '',
      goal: '',
      deadline: null
    });

    // Obtener el token de autenticación del almacenamiento o donde esté guardado
    authToken.value = authStore.getUserToken;

    const saveSavings = async () => {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/savings', savingsData.value, {
          headers: {
            Authorization: `Bearer ${authToken.value}` //el token para hacer la Authorization
          }
        });

        console.log('Savings created:', response.data);
          alert('Savings created');
          router.push('/savingHub');
      } catch (error) {
        console.error('Error creating savings:', error);
      }
    };

    function goBack() {
      router.go(-1);
    }

    return {
      savingsData,
      saveSavings,
      goBack
    };
  }
};
</script>

<style scoped>
@import './styles/CreateSavings.css';
</style>
