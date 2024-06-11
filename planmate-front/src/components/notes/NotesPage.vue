<template>
    <div class="principalContainer">
    <section class="navContainer">
      <navBar></navBar>
    </section>
    <section class="titleNotes">
            <h1 class="extraBold">Thought Repository</h1>
    </section>

    <section class="notesPageContainer">
    <!-- Thought Repository -->
    <section class="notesContainer">
        <!-- <button @click="irARuta('/createNotes')">Create a note</button> -->
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
      </section>
  
    </section>
    <button @click="createNote()" class="createNote extrabold" ></button>
  </div>
  </template>
  
  <script>
  import { useRouter } from "vue-router";
  import { ref, onBeforeMount } from "vue";
  import axios from "axios";
  import { useAuthStore } from "../../../store/auth";
  import navBar from '../navBar/NavBar.vue'
  
  
  export default {
    components: {
      navBar,
    },
    setup() {
      const router = useRouter();
      const notesList = ref([]);
      const authStore = useAuthStore();
      const authToken = ref('');

      
  
  
      // Obtener el token de autenticación
       authToken.value = authStore.getUserToken;
       console.log('token recibido para recuperar savings del usuario' + authToken.value);
  
      //editar llendo a ruta
      const editNote = (id) => {
        router.push({ name: 'EditNotes', params: { id } });
      };

      // crear nota{
      const createNote = () =>{
        router.push('/createNotes');
      }
  
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
 
  
      // Llama a fetchSavings cuando el componente se monta
       onBeforeMount(() => {
        authStore.setPage('notes');
        getImportantNotes();

      });
      

  
      return {
        router,
        getImportantNotes,
        notesList,
        editNote,
        createNote,
      };
    },
  };
  </script>

  <style scoped>
 @import './styles/NotesPage.css';
  </style>