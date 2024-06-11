import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import SignUp from '../components/access/SignUp.vue';
import SignIn from '../components/access/SignIn.vue';
import Dashboard from '../components/Dashboard.vue';
import CreateSavings from '../components/savings/CreateSaving.vue';
import CreateTask from '../components/task/CreateTask.vue';
import CreateNotes from '../components/notes/CreateNotes.vue';
import EditNotes from '../components/notes/EditNotes.vue';
import EditTask from '../components/task/EditTask.vue';
import EditSaving from '../components/savings/EditSavings.vue';
import SavingsPage from '../components/savings/SavingsPage.vue'
import TaskPage from '../components/task/TaskPage.vue';
import NotesPage from '../components/notes/NotesPage.vue';


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/signUp',
    name: 'SignUp',
    component: SignUp,
  },
  {
    path: '/signIn',
    name: 'SignIn',
    component: SignIn,
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
  },
  {
    path: '/createSavings',
    name: 'CreateSavings',
    component: CreateSavings,
  },
  {
    path: '/createTask',
    name: 'CreateTask',
    component: CreateTask,
  },
  {
    path: '/createNotes',
    name: 'CreateNotes',
    component: CreateNotes,
  },
  {
    path: '/editNote/:id',
    name: 'EditNotes',
    component: EditNotes,
    props: true,
  },
  {
    path: '/editTask/:id',
    name: 'EditTask',
    component: EditTask,
    props: true,
  },
  {
    path: '/EditSaving/:id',
    name: 'EditSaving',
    component: EditSaving,
    props: true,
  },
  {
    path: '/savingHub',
    name: 'SavingsPage',
    component: SavingsPage,
  },
  {
    path: '/taskPage',
    name: 'TaskPage',
    component: TaskPage,
  },
  {
    path: '/notesPage',
    name: 'NotesPage',
    component: NotesPage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
