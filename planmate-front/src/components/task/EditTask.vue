<template>
    <div class="editTasksContainer">
      <h2 class="demiBold">Edit Task</h2>
      <!-- Formulario para crear tarea -->
      <form @submit.prevent="createTask">
        <!-- Campo de nombre de la tarea -->
        <div class="inputGroup">
          <label class="content" for="name">Name</label>
          <input type="text" id="name" v-model="taskData.name" required>
        </div>
  
        <!-- Campo de descripción de la tarea -->
        <div class="inputGroup">
          <label class="content" for="description">Description</label>
          <textarea id="description" v-model="taskData.description" required></textarea>
        </div>
  
        <!-- Campo de fecha de la tarea -->
        <div class="inputGroup">
          <label class="content" for="date">Date</label>
          <input type="date" id="date" v-model="taskData.date" required>
        </div>
  
        <!-- Botón para enviar el formulario -->
        <section class="buttons">
          <button type="submit" @click="saveTask">Update Task</button>
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
        const authStore = useAuthStore();
        const authToken = ref('');
        const router = useRouter(); // Obtiene el enrutador
      const taskId = ref(props.id);

      const taskData = ref({
        name: '',
        description: '',
        status: 'pendiente',
        date: null,
      });
  
        // Obtener el token de autenticación del almacenamiento o donde esté guardado
        authToken.value = authStore.getUserToken;

        function goBack() {
          router.go(-1);
        }

       const fetchTaskDetails = async() => {
        console.log('fetching task');
        try{
            const response = await axios.get(`http://127.0.0.1:8000/api/task/${taskId.value}`);
            console.log('response  ', response.data);

            taskData.value.name = response.data.taskInfo.name;
            taskData.value.description = response.data.taskInfo.description;
            taskData.value.status = response.data.taskInfo.status;
            taskData.value.date = response.data.taskInfo.date;
            
        }catch(error){
            console.error('error fetching task details :', error);
        }
       }

       const saveTask = async() => {
        console.log('save task ', taskData.value);

        try{
            const response = await axios.put(`http://127.0.0.1:8000/api/task/${taskId.value}`, taskData.value, {
          headers: {
            Authorization: `Bearer ${authToken.value}` // Incluir el token en el encabezado Authorization
          }
        });

        console.log('task updated:', response.data);
        alert('Task updated');
        router.push('/taskPage');
 
        }catch(error){

        }
       }

       onMounted(async () => {
        await fetchTaskDetails();

       });
  
      return {
        taskData,
        taskId,
        fetchTaskDetails,
        saveTask,
        goBack,
        // createTask,
      };
    },
  };
  </script>
  
  <style scoped>
 @import './styles//EditTask.css';
  </style>
  