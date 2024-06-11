<template>
  <div class="principalContainer">
    <section class="navContainer">
  <navBar :targetPage="'dashboard'"></navBar>
</section>
  <section class="userInfo">
    <div class="userContainer">
      <img src="../assets/images/profile-image.png" alt="userPhoto">
      <div class="helloUser">
        <p class="hello">Hello,</p>
        <p class="userName demiBold">{{userName}}</p>
      </div>
    </div>
    <h1 class="extraBold">Dashboard</h1>
  </section>
    
  <section class="dashboardContainer">
    <!-- Savings -->
    <section class="savingsContainer">
      <h3 class="demiBold">Savings Hub</h3>
      <!-- <button @click="irARuta('/createSavings')">Create Savings</button> -->
        <draggable class="dropSavings" v-model="savingsList" :group="{name: 'savingHub'}"> 
          <div v-for="savings in savingsList" :key="savings.id" class="savings">
            <p class="savingName demiBold">{{ savings.name }} </p>
            <div class="saving">
              <div class="savingGraphic">
                <vc-donut class="donut"
                  :sections="[{ value: parseInt(savings.amount), color: '#BCB4FF' }]"
                  :thickness="30"
                  :size="55"
                  :total="parseInt(savings.goal)"
                  :background="'#F5F5F5'"
                  :foreground="'#2A2C39'"
                  >
                </vc-donut>
              </div>
              <div class="savingContent">
                <p class="savingAmount demiBold">{{ parseInt(savings.amount) }}</p>
                <p class="savingGoal">{{parseInt(savings.goal)}}</p> 
              </div>
          </div>
            <!-- <button @click="editSavings(savings.id)">edit</button> -->
          </div>
        </draggable>
  </section>

  <section class="plannerContainer">
    <h3 class="demiBold">Priority Planner</h3>
    <!-- <button @click="irARuta('/createTask')">Create a Task</button> -->
    <draggable v-model="taskList" :group="{name: 'priorityPlanner'}">
      <div v-for="task in taskList" :key="task.id" class="taskContainer">
        <div class="task">
          <div class="taskStatus" style="background-color: var(--light-purple);"></div>
          <div class="taskInfo">
            <p class="taskName demiBold">{{ task.name }} </p>
            <p class="taskDescription content">{{ task.description }} </p>
          </div>
          <p class="taskDate content">{{ task.date }}</p>
          
            <!-- {{ task.name }}  -->
          <!-- description: {{ task.description }}  -->
          <!-- status: {{ task.status }}   -->
          <!-- <button @click="editTask(task.id)">edit</button> -->
        </div>
      </div>
    </draggable>
  </section>

  <!-- Thought Repository -->
  <section class="notesContainer">
      <h3 class="demiBold">Thought Repository</h3>
      <!-- <button @click="irARuta('/createNotes')">Create a note</button> -->
      <draggable class="noteContainer" v-model="notesList" :group="{ name: 'thoughtRepository' }">
        <div v-for="note in notesList" :key="note.id" class="notes">
          <p class="noteTitle demiBold">{{note.title}}</p>
          <p class="excerpt">{{ note.excerpt}}</p>
          
          
          <!-- - Excerpt: {{ note.excerpt }}  -->
          <!-- - Importance: {{ note.importance }} -->
          <div class="noteFooter">
            <!-- <p class="noteDate content">date</p> -->
            <button class="editNote" @click="editNote(note.id)"></button>
          </div>

        </div>
      </draggable>
    </section>

  </section>
</div>
</template>

<script>
import { useRouter } from "vue-router";
import { ref, onBeforeMount } from "vue";
import axios from "axios";
import { useAuthStore } from "../../store/auth";
import { VueDraggableNext } from 'vue-draggable-next'
import navBar from './navBar/NavBar.vue'


export default {
  components: {
    draggable: VueDraggableNext,
    navBar,
  },
  setup() {
    const router = useRouter();
    const savingsList = ref([]);
    const taskList = ref([]);
    const notesList = ref([]);
    const authStore = useAuthStore();
    const authToken = ref('');
    const userName = ref('');
    


    // Obtener el token de autenticación
     authToken.value = authStore.getUserToken;
     console.log('token recibido para recuperar savings del usuario' + authToken.value);

    //editar llendo a ruta
    const editNote = (id) => {
      router.push({ name: 'EditNotes', params: { id } });
    };

    //editar llendo a ruta
    const editTask = (id) => {
    router.push({ name: 'EditTask', params: { id } });
    };

    //editar llendo a ruta
    const editSavings = (id) => {
    router.push({ name: 'EditSaving', params: { id } });
    };



    // recuperar savings
    const fetchSavings = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/savings", {
          headers: {
            Authorization: `Bearer ${authToken.value}`, // incluir el token en el header para recuperar los savings de este header
          },
        });

        savingsList.value = response.data.savings;
        console.log("Recuperando savings:", response.data.savings);
      } catch (error) {
        console.error("Error fetching savings:", error);
      }
    };

    //recuperar task
    const getUserTask = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/task", {
          headers: {
            Authorization: `Bearer ${authToken.value}`, // incluir el token en el header para recuperar los savings de este header
          },
        });

        taskList.value = response.data.user_tasks;
        console.log("Recuperando task:", taskList.value);
      } catch (error) {
        console.error("Error fetching task:", error);
      }
    };

    //recuperar notes
    const getImportantNotes = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/notes", {
          headers: {
            Authorization: `Bearer ${authToken.value}`, // incluir el token en el header para recuperar los savings de este header
          },
        });

        notesList.value = response.data.userNotes;
        console.log("Recuperando notes:", notesList.value);
      } catch (error) {
        console.error("Error fetching notes:", error);
      }
    };

    //recuperar userName
    const getUserName = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/login", {
          headers: {
            Authorization: `Bearer ${authToken.value}`, // incluir el token en el header para recuperar los savings de este header
          },
        });

        userName.value =  response.data.userInfo.name;
        console.log("datos usuario:", response.data.userInfo.name);
      } catch (error) {
        console.error("Error fetching notes:", error);
      }
    }

    // Llama a fetchSavings cuando el componente se monta
     onBeforeMount(() => {
      authStore.setPage('dashboard');
      fetchSavings();
      getUserTask();
      getImportantNotes();
      getUserName();
    });
    
    function irARuta(ruta) {
      switch(ruta){
        case '/createSavings':
        router.push(ruta);
        break;
        case '/createTask':
        router.push(ruta);
        break;
        case '/createNotes':
        router.push(ruta);
        break;
      }
      
    }

    return {
      irARuta,
      router,
      savingsList,
      getUserTask,
      taskList,
      getImportantNotes,
      notesList,
      editNote,
      editTask,
      editSavings,
      getUserName,
      userName,
      // sections,
      // formData,
      // login
    };
  },
};
</script>

<style scoped>
@import "./Dashboard.css";
</style>
