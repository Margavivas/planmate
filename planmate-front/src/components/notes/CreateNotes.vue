<template>
  <div class="principalContainer">
    <section class="createNotesContainer">
  <div v-if="editor">
    <!-- <button @click="insertImageFromDevice">Add image</button> -->
    <section class="buttonsPannel">
    <button class="black" @click="editor.chain().focus().toggleBold().run()" :disabled="!editor.can().chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
    </button>
    <button class="italic" @click="editor.chain().focus().toggleItalic().run()" :disabled="!editor.can().chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
    </button>
    <button class="strike" @click="editor.chain().focus().toggleStrike().run()" :disabled="!editor.can().chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }">
    </button>
    <!-- <button @click="editor.chain().focus().unsetAllMarks().run()">
      clear marks
    </button>
    <button @click="editor.chain().focus().clearNodes().run()">
      clear nodes
    </button> -->
    <button class="paragraph" @click="editor.chain().focus().setParagraph().run()" :class="{ 'is-active': editor.isActive('paragraph') }">
    </button>
    <button class="bullet" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }">
    </button>
    <button class="numberedList" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'is-active': editor.isActive('orderedList') }">
    </button>
    <button class="quote" @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'is-active': editor.isActive('blockquote') }">
    </button>
    <button class="demiBold" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
      h1
    </button>
    <button class="demiBold" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
      h2
    </button>
    <button class="demiBold" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }">
      h3
    </button>
    <button class="demiBold" @click="editor.chain().focus().toggleHeading({ level: 4 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }">
      h4
    </button>
    <button class="demiBold" @click="editor.chain().focus().toggleHeading({ level: 5 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 5 }) }">
      h5
    </button>
    <button class="demiBold" @click="editor.chain().focus().toggleHeading({ level: 6 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 6 }) }">
      h6
    </button>
  
    <button class="code" @click="editor.chain().focus().toggleCodeBlock().run()" :class="{ 'is-active': editor.isActive('codeBlock') }">
    </button>
    
    <button class="line" @click="editor.chain().focus().setHorizontalRule().run()">
    </button>
    <button class="enter" @click="editor.chain().focus().setHardBreak().run()">
    </button>
    <button class="undo" @click="editor.chain().focus().undo().run()" :disabled="!editor.can().chain().focus().undo().run()">
    </button>
    <button class="redo" @click="editor.chain().focus().redo().run()" :disabled="!editor.can().chain().focus().redo().run()">
    </button>
    <button class="saveNote" @click="openModal">Save note</button>
    <button class="back" @click="goBack">back</button>
  </section>
        <!-- Modal para crear nota -->
        <div v-if="showModal" class="modal">
      <div class="modal-content">
        <h2 class="demiBold">Nueva Nota</h2>

        <div class="inputGroup">
          <label class="content" for="title">Título:</label>
          <input v-model="notesData.title" type="text" id="title" />
        </div>
        <div class="inputGroup">
          <label class="content" for="excerpt">Extracto:</label>
          <textarea v-model="notesData.excerpt" id="excerpt"></textarea>
        </div>
        <div class="inputGroup">
        <label class="content" for="importance">Importancia:</label>
        <select v-model="notesData.importance" id="importance">
          <option value="1">Baja</option>
          <option value="2">Media</option>
          <option value="3">Alta</option>
        </select>
        </div>
        <section class="buttons">
        <button @click="saveNote" class="save">Save</button>
        <button @click="closeModal" class="cancel">Cancel</button>
        </section>
      </div>
    </div>

  </div>
  <editor-content :editor="editor" class="noteContainerCreation"/>
</section>
</div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import StarterKit from '@tiptap/starter-kit'
import { Editor, EditorContent } from '@tiptap/vue-3'
import Image from '@tiptap/extension-image'

import axios from 'axios';
  import { useAuthStore } from "../../../store/auth";
  import { useRouter } from 'vue-router';

export default {
  components: {
    EditorContent,
  },

  setup() {
    const editor = ref(null);
    const showModal = ref(false);
    const authStore = useAuthStore();
    const authToken = ref('');
    const router = useRouter(); // Obtiene el enrutador
    const notesData = ref({
      title: '',
      excerpt: '',
      importance: '1',
    });

     // Obtener el token de autenticación del almacenamiento o donde esté guardado
     authToken.value = authStore.getUserToken;

    const openModal = () => {
      showModal.value = true;
    }

    const closeModal = () => {
      showModal.value = false;
    }

    const handleReturn =() => {
      router.push('/dashboard');
    }

    function goBack() {
          router.go(-1);
    }

    const saveNote = async() => {

      // Obtener el contenido del editor Tiptap
      const content = editor.value.getHTML();
      
      // Datos a enviar
        const data = {
        title: notesData.value.title,
        excerpt: notesData.value.excerpt,
        importance: notesData.value.importance,
        content: content,
      };
      console.log('data before send',  data);
      try {
        // Realizar la solicitud POST con Axios
        const response = await axios.post('http://127.0.0.1:8000/api/notes', data, {
          headers: {
            Authorization: `Bearer ${authToken.value}` // Incluir el token en el encabezado Authorization
          }
        });
        
        // Manejar la respuesta según tus necesidades
        console.log('Respuesta del servidor:', response.data);

        // Cerrar el modal después de guardar la nota
        closeModal();
        alert('Note Created created');
         
      } catch (error) {
        // Manejar errores, por ejemplo, mostrar un mensaje de error
        console.error('Error al guardar la nota:', error);
      }
      
      closeModal()
    }

    const insertImageFromDevice = () => {
      const input = document.createElement('input')
      input.type = 'file'
      input.accept = 'image/*'
      input.addEventListener('change', () => {
        const file = input.files[0]
        if (file) {
          const reader = new FileReader()
          reader.onload = () => {
            const imageUrl = reader.result
            console.log('URL Imagen  ', imageUrl);
            editor.value.chain().focus().setImage({ src: imageUrl, alt: 'Descripción de la imagen' }).run()
          }
          reader.readAsDataURL(file)
        }
      })
      input.click()
    }

    onMounted(() => {
      editor.value = new Editor({
        extensions: [
          StarterKit,
          Image,
        ],
        content: `
          <h1>
            Title
          </h2>
          <p>
            -
          </p>
        `,
      })
    })

    onBeforeUnmount(() => {
      editor.value.destroy()
    })

    return {
      editor,
      showModal,
      openModal,
      closeModal,
      saveNote,
      insertImageFromDevice,
      notesData,
      handleReturn,
      goBack,
    }
  },
}
</script>

<style lang="scss">
/* Basic editor styles */
.tiptap {
  > * + * {
    margin-top: 0.75em;
  }

  ul,
  ol {
    padding: 0 1rem;
  }

  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
    line-height: 1.1;
  }

  code {
    background-color: rgba(#616161, 0.1);
    color: #616161;
  }

  pre {
    background: #0D0D0D;
    color: #FFF;
    font-family: 'JetBrainsMono', monospace;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;

    code {
      color: inherit;
      padding: 0;
      background: none;
      font-size: 0.8rem;
    }
  }

  img {
    max-width: 100%;
    height: auto;
  }

  blockquote {
    padding-left: 1rem;
    border-left: 2px solid rgba(#0D0D0D, 0.1);
  }

  hr {
    border: none;
    border-top: 2px solid rgba(#0D0D0D, 0.1);
    margin: 2rem 0;
  }
}


</style>
<style scoped>

@import './styles/CreateNotes.css';
</style>