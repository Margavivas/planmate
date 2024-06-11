<template>
    <div class="principalContainer">
    <div class="EditNotesContainer">
        <!-- <h1>Edit notes</h1> -->
        <!-- <textarea v-model="editedNote.content"></textarea> -->
        <div v-if="editor">
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
    <button @click="saveNote" class="save">Update</button>
    <button class="back" @click="goBack">back</button>
  </section>
    
  </div>
  <editor-content :editor="editor" class="noteContainerCreation"/>
    </div>
  </div>
    
</template>

<script>
import { ref, onMounted } from 'vue';
import StarterKit from '@tiptap/starter-kit';
import { Editor, EditorContent } from '@tiptap/vue-3';
import Image from '@tiptap/extension-image';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useAuthStore } from "../../../store/auth";

export default {
  components: {
    EditorContent,
  },
  props: ['id'],
  setup(props) {
    const router = useRouter(); // Obtiene el enrutador
    const editor = ref(null);
    const noteId = ref(props.id);
    const editedNote = ref({
      content: '',
    });

    const authStore = useAuthStore();
    const authToken = ref('');
         // Obtener el token de autenticación del almacenamiento o donde esté guardado
         authToken.value = authStore.getUserToken;


         function goBack() {
          router.go(-1);
    }


    const fetchNoteDetails = async() => {
      console.log('fetching data note');
     
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/notes/${noteId.value}`);
        editedNote.value.content = response.data.noteInfo.content;
        // const test = await decodeImagesInContent(editedNote.value.content);
        // console.log('test' + test);
        console.log('getting note ' + JSON.stringify(editedNote.value.content, null, 2));
      } catch (error) {
        console.error('Error fetching note details:', error);
      }
    };

    const saveNote = async() => {
    console.log('save note');
    const content = editor.value.getHTML();
    console.log('note ', content);

    try {
        await axios.put(`http://127.0.0.1:8000/api/notes/${noteId.value}`, { content }, {
            headers: {
                Authorization: `Bearer ${authToken.value}`
            }
        });

        alert('Note updated');
    } catch (error) {
        console.error('Error saving note:', error);
    }
};
    
    // const decodeBase64ImagesInContent = (content) => {
    //   // Encuentra todas las coincidencias de imágenes codificadas en base64 en el contenido
    //   const base64ImageRegex = /<img.*?src=['"](data:image\/.*?;base64,.*?)['"].*?>/g;
    //   const matches = content.match(base64ImageRegex);

    //   if (matches) {
    //     // Decodifica cada coincidencia y reemplázala en el contenido
    //     matches.forEach((match) => {
    //       const base64Data = match.match(/src=['"](data:image\/.*?;base64,.*?)['"]/)[1];
    //       const decodedImage = atob(base64Data.split(',')[1]);
    //       content = content.replace(base64Data, `src="data:image/jpeg;base64,${btoa(decodedImage)}"`);
    //     });
    //   }

    //   return content;
    // };

    const insertImageFromDevice = async() => {
      const input = document.createElement('input')
      input.type = 'file'
      input.accept = 'image/*'
      input.addEventListener('change', () => {
        const file = input.files[0]
        if (file) {
          const reader = new FileReader()
          reader.onload = () => {
            const imageUrl = reader.result
            editor.value.chain().focus().setImage({ src: imageUrl, alt: 'Descripción de la imagen' }).run()
          }
          reader.readAsDataURL(file)
        }
      })
      input.click()
    }

onMounted(async () => {
  await fetchNoteDetails();
console.log('token ', authToken.value);



  editor.value = new Editor({
    extensions: [
      StarterKit,
      Image,
    ],
    content: editedNote.value.content,
  });
});

    return {
      noteId,
      editedNote,
      fetchNoteDetails,
      saveNote,
      editor,
      goBack,
      insertImageFromDevice,
    //   decodeImagesInContent,
    //   decodeBase64Image,
    };
  },
};
</script>

<style scoped>
@import './styles/EditNotes.css';
</style>
