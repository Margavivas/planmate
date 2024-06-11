<template>
<div class="principalContainer">
    <section class="navContainer">
            <navBar></navBar>
        </section>
    <div class="savingsPageContainer">
        <section class="titleSavings">
            <h1 class="extraBold">Savings Hub</h1>
        </section>
        <section class="jarsCounter">
            <h3 class="demiBold"> 6 Jars Calculator</h3>
            <p class="content">Lets you divide your savings into manageable increments, 
              turning small contributions into significant financial growth.</p>
            <section class="quantity">
              <input type="number" name="Salary" id="salary" v-model="amount" @input="calculateJarValues">
            </section>
            <div class="jarsContainer">
                <div class="jar1Container">
                    <img src="../../assets/images/savingsImage/freedom.png" alt="jar financial Freedom">
                    <p class="content">Financial freedom</p>
                    <input class="jarInput" type="number" name="Salary" id="salary" v-model="freedom">
                    <p class="result" :class="{ 'correct': correctValue, 'incorrect': !correctValue }">{{ freedomResult }}</p>
                </div>
                <div class="jar2Container">
                    <img src="../../assets/images/savingsImage/savings.png" alt="Long Term Saving">
                    <p class="content">Long Term Saving</p>
                    <input class="jarInput" type="number" name="Salary" id="salary" v-model="longTerm">
                    <p class="result" :class="{ 'correct': correctValue, 'incorrect': !correctValue }">{{ longTermResult }}</p>
                </div>
                <div class="jar3Container">
                    <img src="../../assets/images/savingsImage/necessities.png" alt="Necessities">
                    <p class="content">Necessities</p>
                    <input class="jarInput" type="number" name="Salary" id="salary" v-model="Necessities">
                    <p class="result" :class="{ 'correct': correctValue, 'incorrect': !correctValue }">{{ NecessitiesResult }}</p>
                </div>
                <div class="jar4Container">
                    <img src="../../assets/images/savingsImage/education.png" alt="education">
                    <p class="content">education</p>
                    <input class="jarInput" type="number" name="Salary" id="salary" v-model="education">
                    <p class="result" :class="{ 'correct': correctValue, 'incorrect': !correctValue }">{{ educationResult }}</p>
                </div>
                <div class="jar5Container">
                    <img src="../../assets/images/savingsImage/play.png" alt="play">
                    <p class="content">Play</p>
                    <input class="jarInput" type="number" name="Salary" id="salary" v-model="education">
                    <p class="result" :class="{ 'correct': correctValue, 'incorrect': !correctValue }">{{ playResult }}</p>
                </div>
                <div class="jar6Container">
                    <img src="../../assets/images/savingsImage/give.png" alt="give">
                    <p class="content">give</p>
                    <input class="jarInput" type="number" name="Salary" id="salary" v-model="give">
                    <p class="result" :class="{ 'correct': correctValue, 'incorrect': !correctValue }">{{ giveResult }}</p>

                </div>
            </div>
        </section>

        <section class="loadSavingsContainer">
            <h3 class="demiBold"> Savings</h3>
            <p class="content">"Welcome to PlanMate's Savings Hub! Take control of your financial journey.</p>
            <div class="dropSavings">
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
                <p class="savingDeadLine content">{{savings.deadline}}</p> 
              </div>
          </div>
            <button @click="editSavings(savings.id)" class="editSavings">edit</button>
        </div>
          </div>
        </section>
</div>
<button @click="createSaving()" class="createSaving extrabold" ></button>
</div>
</template>

<script>
import navBar from '../navBar/NavBar.vue'
import { useRouter } from "vue-router";
import { ref, onBeforeMount, watch} from "vue";
import axios from "axios";
import { useAuthStore } from "../../../store/auth";


export default {
  components: {
    navBar,
  },
  setup() {
    const router = useRouter();
    const savingsList = ref([]);
    const authStore = useAuthStore();
    const authToken = ref('');
    let amount = ref();
    let correctValue = ref(true);

    //porcentaje
    let freedom = ref(10);
    let longTerm = ref(10);
    let Necessities = ref(55);
    let education = ref(10);
    let play = ref(10);
    let give = ref(5);

    // result
    let freedomResult = ref();
    let longTermResult = ref();
    let NecessitiesResult = ref();
    let educationResult = ref();
    let playResult = ref();
    let giveResult = ref();

    
    // Obtener el token de autenticación
    authToken.value = authStore.getUserToken;
    console.log('token recibido para recuperar savings del usuario' + authToken.value);

    //editar llendo a ruta
    const editSavings = (id) => {
    router.push({ name: 'EditSaving', params: { id } });
    };

    // crear Saving
    function createSaving() {
        router.push('/createSavings');
    }


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

    // Llama a fetchSavings cuando el componente se monta
     onBeforeMount(() => {
      authStore.setPage('savings');
      fetchSavings();
    });
    

    // jar function
    const calculateJarValues = () => {
      // const totalAmount = parseFloat(amount);
      
      freedomResult.value = (amount.value * freedom.value)/100; 
      longTermResult.value = (amount.value * longTerm.value)/100;
      NecessitiesResult.value = (amount.value * Necessities.value)/100; 
      educationResult.value = (amount.value * education.value)/100;
      playResult.value = (amount.value * play.value)/100;
      giveResult.value = (amount.value * give.value)/100;
  };

  // verify porcentaje 
  const calculatePercentage = () => {
    if(freedom.value + longTerm.value + Necessities.value + education.value + play.value + give.value == 100){
      // console.log("suma correta");
      correctValue.value = true;
    }else{
      // console.log("suma incorrecta");
      correctValue.value = false;
    }
  }

watch([freedom, longTerm, Necessities, education, play, give], (newValues, oldValues) => {
  calculatePercentage();
  calculateJarValues();
});

    return {
        editSavings,
        fetchSavings,
        savingsList,
        createSaving,
        amount,
        freedom,
        longTerm,
        Necessities,
        education,
        play,
        give,
        calculateJarValues,
        freedomResult,
        longTermResult,
        NecessitiesResult,
        educationResult,
        playResult,
        giveResult,
        calculatePercentage,
        correctValue,
    };
  },
};
</script>

<style scoped>
@import './styles/SavingsPage.css';
</style>