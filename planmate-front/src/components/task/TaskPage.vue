<template>
    <div class="principalContainer">
        <section class="navContainer">
            <navBar></navBar>
        </section>
        <div class="taskPageContainer">
        <section class="titleSavings">
            <h1 class="extraBold">Priority Planner</h1>
        </section>
        
        <section class="plannerContainer">
        <h3 class="content">Pending</h3>
        <!-- <button @click="irARuta('/createTask')">Create a Task</button> -->
        <div v-for="task in getFilteredTasks('pending')" :key="task.id" class="taskContainer">
            <div class="task">
            <div class="taskStatus" style="background-color: var(--light-pink); cursor: pointer;" @click="changeStatus(task.id, task.status)"></div>
            <div class="taskInfo">
                <p class="taskName demiBold">{{ task.name }} </p>
                <p class="taskDescription content">{{ task.description }} </p>
            </div>
            <button @click="editTask(task.id)" class="editTask">edit</button>
            <button @click="deleteTask(task.id)" class="deleteTask"></button>
            <p class="taskDate content">{{ task.date }}</p>
            
            </div>
            <changeTaskStatus v-if="isChangingStatues && task.id === changingTaskId"
                    :taskId="changingTaskId"
                    :taskStatus="changingTaskStatus"
                    @close="isChangingStatues = false">
            </changeTaskStatus>
        </div>
            <h3 class="content inProgress">In Progress</h3>
                <div v-for="task in getFilteredTasks('inProgress')" :key="task.id" class="taskContainer">
                    <div class="task">
                    <div class="taskStatus" style="background-color: var(--light-purple); cursor: pointer;" @click="changeStatus(task.id, task.status)"></div>
                    <div class="taskInfo">
                        <p class="taskName demiBold">{{ task.name }} </p>
                        <p class="taskDescription content">{{ task.description }} </p>
                    </div>
                    <button @click="editTask(task.id)" class="editTask">edit</button>
                    <button @click="deleteTask(task.id)" class="deleteTask"></button>
                    <p class="taskDate content">{{ task.date }}</p>
                    
                    </div>
                    <changeTaskStatus v-if="isChangingStatues && task.id === changingTaskId"
                            :taskId="changingTaskId"
                            :taskStatus="changingTaskStatus"
                            @close="isChangingStatues = false">
                    </changeTaskStatus>
                </div>
            <h3 class="content finished">Finished</h3>
            <div v-for="task in getFilteredTasks('finished')" :key="task.id" class="taskContainer">
                    <div class="task">
                    <div class="taskStatus" style="background-color: var(--lime-green); cursor: pointer;" @click="changeStatus(task.id, task.status)"></div>
                    <div class="taskInfo">
                        <p class="taskName demiBold" style="text-decoration:line-through;">{{ task.name }} </p>
                        <p class="taskDescription content" style="text-decoration:line-through;">{{ task.description }} </p>
                    </div>
                    <button @click="editTask(task.id)" class="editTask">edit</button>
                    <button @click="deleteTask(task.id)" class="deleteTask"></button>
                    <p class="taskDate content">{{ task.date }}</p>
                    
                    </div>
                    <changeTaskStatus v-if="isChangingStatues && task.id === changingTaskId"
                            :taskId="changingTaskId"
                            :taskStatus="changingTaskStatus"
                            @close="isChangingStatues = false">
                    </changeTaskStatus>
                </div>
        </section>
    </div>
    <button @click="createTask()" class="createTask extrabold" ></button>
</div>
</template>

<script>
import { useRouter } from "vue-router";
import { ref, onBeforeMount, watch } from "vue";
import axios from "axios";
import { useAuthStore } from "../../../store/auth";
import navBar from '../navBar/NavBar.vue';
import changeTaskStatus from './changeTaskStatus.vue';

export default {
  components: {
    navBar,
    changeTaskStatus,
  },
  setup() {
    const router = useRouter();
    const taskList = ref([]);
    const authStore = useAuthStore();
    const authToken = ref('');
    const isChangingStatues = ref(false);
    const changingTaskId = ref(null);
    const changingTaskStatus = ref(null);

    authToken.value = authStore.getUserToken;

    const editTask = (id) => {
      router.push({ name: 'EditTask', params: { id } });
    };

    const createTask = () => {
      router.push('/createTask');
    };

    const deleteTask = async (id) => {
        console.log('delete task ', id);  
        try {
            const response = await axios.delete(`http://127.0.0.1:8000/api/task/${id}`,id, {
            headers: {
                Authorization: `Bearer ${authToken.value}`,
            },
            });
            taskList.value = taskList.value.filter(task => task.id !== id);
            alert('task deleted');
            console.log("Tarea eliminada:", response.data);
        } catch (error) {
            console.error("Error al eliminar tarea:", error);
        }
    };

    const getUserTask = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/task", {
          headers: {
            Authorization: `Bearer ${authToken.value}`,
          },
        });

        taskList.value = response.data.user_tasks;
        console.log("Recuperando task:", taskList.value);
      } catch (error) {
        console.error("Error fetching task:", error);
      }
    };

    const getFilteredTasks = (status) => {
      return taskList.value.filter(task => task.status === status);
    };

    const changeStatus = (taskId, taskStatus) => {
    changingTaskId.value = taskId;
    changingTaskStatus.value = taskStatus;
    isChangingStatues.value = true;
    }


    onBeforeMount(() => {
      authStore.setPage('tasks');
      getUserTask();
    });

    watch(isChangingStatues, (newValues, oldValues) => {
        getUserTask();
    });

    return {
      router,
      getUserTask,
      taskList,
      editTask,
      createTask,
      deleteTask,
      getFilteredTasks,
      isChangingStatues,
      changeStatus,
      changingTaskId,
      changingTaskStatus,
      
    };
  },
};
</script>

<style scoped>
@import './styles/TaskPage.css';
</style>
