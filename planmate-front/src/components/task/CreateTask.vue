<template>
    <div class="principalContainer createTasksContainer">
      <h2 class="demiBold">Create a New Task</h2>
      <p class="content">Create a new task, set your priorities, and enjoy 
        a streamlined approach to productivity. Let's make achieving your 
        goals a breeze together!</p>

      <!-- Formulario para crear tarea -->
      <form @submit.prevent="createTask">
        <!-- Campo de nombre de la tarea -->
        <div class="inputGroup">
          <label for="name" class="content">Task Name</label>
          <input type="text" id="name" v-model="taskData.name" required>
        </div>
  
        <!-- Campo de descripción de la tarea -->
        <div class="inputGroup">
          <label for="description" class="content">Description</label>
          <textarea id="description" v-model="taskData.description" required></textarea>
        </div>
  
        <!-- Campo de fecha de la tarea -->
        <div class="inputGroup">
          <label for="date" class="content">Date</label>
          <input type="date" id="date" v-model="taskData.date" required>
        </div>
  
        <!-- Botón para enviar el formulario -->
        <section class="buttons">
          <button type="submit">Create Task</button>
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
        const router = useRouter(); // Obtiene el enrutador
      const taskData = ref({
        name: '',
        description: '',
        status: 'pending',
        date: null,
      });
  
        // Obtener el token de autenticación del almacenamiento o donde esté guardado
        authToken.value = authStore.getUserToken;

        function goBack() {
          router.go(-1);
        }

      const createTask = async () => {
        try {
          // Asignar el valor predeterminado antes
          taskData.value.status = 'pending';
  
          // Realizar la solicitud HTTP para crear la tarea utilizando Axios
          const response = await axios.post('http://127.0.0.1:8000/api/task', taskData.value, {
          headers: {
            Authorization: `Bearer ${authToken.value}` // Incluir el token en el encabezado Authorization
          }
        });
  
          // Aquí puedes manejar la respuesta, por ejemplo, redirigir al usuario o mostrar un mensaje de éxito
          console.log('Tarea creada con éxito:', response.data);
  
          // Puedes reiniciar el formulario después de enviar la tarea
         resetFormulario();
         alert('Task created');
          router.push('/taskPage');
        } catch (error) {
          console.error('Error al crear la tarea:', error);
        }
      };
  
      const resetFormulario = () => {
        // Reiniciar los datos del formulario
        taskData.value = {
          name: '',
          description: '',
          status: 'pending',
          date: null,
        };
      };
  
      return {
        taskData,
        createTask,
        goBack,
      };
    },
  };
  </script>
  
  <style scoped>
 @import './styles/CreateTask.css';
  </style>
  