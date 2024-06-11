<template>
  <div class="changeTaskStatus">
    <section class="changeContainer">
      <h2 class="extraBold">Change Task Status {{ taskId }}</h2>
      
      <label for="newStatus" class="content">Select New Status: {{ taskStatus }}</label>
      <select v-model="selectedStatus" id="newStatus">
        <option value="pending">Pending</option>
        <option value="inProgress">In Progress</option>
        <option value="finished">Finished</option>
      </select>
      <div class="buttons">
      <button @click="saveChanges" class="saveChanges extrabold">Save Changes</button>
      <button @click="closeComponent" class="back extrabold">Back</button>
      
    </div>
    </section>
  </div>
</template>

<script>
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import { useAuthStore } from "../../../store/auth";


export default {
  props: {
    taskId: {
      type: String,
      required: true,
    },
    taskStatus: {
      type: String,
      required: true,
    },
  },
  setup(props, { emit }) {
    const selectedStatus = ref("pending"); // Valor por defecto
    const authStore = useAuthStore();
    const authToken = ref('');
    

    // Obtener el token de autenticación del almacenamiento o donde esté guardado
    authToken.value = authStore.getUserToken;

    const saveChanges = async () => {
        console.log('save changes method', selectedStatus.value );
      try {
        // Realizar la solicitud para actualizar el estado de la tarea en la base de datos
        const response = await axios.put( `http://127.0.0.1:8000/api/task/${props.taskId}/change-status`,
        { status: selectedStatus.value }, 
        {
            headers: {
            Authorization: `Bearer ${authToken.value}`
            }
        }
        );

        console.log("Cambios guardados:", response.data);
        closeComponent();
      } catch (error) {
        console.error("Error al guardar cambios:", error);
      }
    };

    const closeComponent = () => {
    emit("close");
    }
    
    watch(() => props.taskId, () => {
      // Puedes realizar acciones adicionales si es necesario cuando cambia el ID de la tarea
    });

    
    onMounted(() => {
      // Por ejemplo, podrías cargar el estado actual de la tarea aquí si es necesario
    });

    return {
      selectedStatus,
      closeComponent,
      saveChanges,
    };
  },
};
</script>

<style scoped>
@import './styles/ChangeTaskStatus.css';
</style>