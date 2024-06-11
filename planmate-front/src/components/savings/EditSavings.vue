<template>
    <div class="editSavingsContainer">
      <h2 class="demiBold">Edit Saving {{ savingsData.name }}</h2>
      <form @submit.prevent="saveSavings">
        <div class="inputGroup">
          <label for="name" class="content">Name:</label>
          <input type="text" id="name" v-model="savingsData.name" required />
        </div>
        <div class="inputGroup">
          <label for="amount" class="content">Amount:</label>
          <input type="number" id="amount" v-model="savingsData.amount" required />
        </div>
        <div class="inputGroup">
          <label for="goal" class="content">Goal:</label>
          <input type="number" id="goal" v-model="savingsData.goal" required />
        </div>
        <div class="inputGroup">
          <label for="deadline" class="content">Deadline:</label>
          <input type="date" id="deadline" v-model="savingsData.deadline" />
        </div>
        <section class="buttons">
        <button type="submit" @click="saveSaving">Edit</button>
        <button type="button" class="back" @click="goBack">back</button>
      </section>
      </form>
    </div>
  </template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from "../../../store/auth";
import { useRouter } from 'vue-router';


export default {
  props: ['id'],
  setup(props) {
    const savingId = ref(props.id);
    const authStore = useAuthStore();
    const authToken = ref('');
    const router = useRouter(); // Obtiene el enrutador
    const savingsData = ref({
      name: '',
      amount: '',
      goal: '',
      deadline: null
    });

    // Obtener el token de autenticación del almacenamiento o donde esté guardado
    authToken.value = authStore.getUserToken;

  
    const fetchSavingsDetails = async() => {
        console.log('fetching saving');
        try{
            const response = await axios.get(`http://127.0.0.1:8000/api/savings/${savingId.value}`);
            console.log('response  ', response.data);

            savingsData.value.name = response.data.savingInfo.name;
            savingsData.value.amount = response.data.savingInfo.amount;
            savingsData.value.goal = response.data.savingInfo.goal;
            savingsData.value.deadline = response.data.savingInfo.deadline;
            
        }catch(error){
            console.error('error fetching saving details :', error);
        }
       }

       onMounted(async () => {
        await fetchSavingsDetails();
       });

       const saveSaving = async() => {
        console.log('save saving');

        try{
            const response = await axios.put(`http://127.0.0.1:8000/api/savings/${savingId.value}`, savingsData.value, {
          headers: {
            Authorization: `Bearer ${authToken.value}` // Incluir el token en el encabezado Authorization
          }
        });

        // Aquí puedes manejar la respuesta, por ejemplo, redirigir al usuario o mostrar un mensaje de éxito
        console.log('savings updated:', response.data);
        alert('savings updated');
        router.push('/savingHub');
 
        }catch(error){

        }
       }

       function goBack() {
          router.go(-1);
        }


    return {
      savingsData,
      //saveSavings,
      savingId,
      fetchSavingsDetails,
      saveSaving,
      goBack,
    };
  }
};
</script>

<style scoped>
@import './styles/EditSavings.css';
</style>