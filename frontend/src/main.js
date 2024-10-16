import Vue from 'vue'
import App from './App.vue'
import VueRouter from "vue-router";
import VueMask from 'v-mask'
import HomePage from './components/HomePage.vue';
import Candidato from './components/CompletarPerfil.vue';
import ListaVagas from './components/Vagas/ListaVagas.vue';
import VerVaga from './components/Vagas/VerVaga.vue';
import EditarVaga from './components/Vagas/EditarVaga.vue';
import CadastroVagas from './components/Vagas/CadastroVagas.vue';

import Recrutador from './components/Recrutadores/CompletarPerfilRecrutador.vue';
import AlterarPerfilRecrutador from './components/Recrutadores/AlterarPerfilRecrutador.vue';
import EditarRecrutador from './components/Recrutadores/EditarRecrutador.vue';
import VerRecrutadores from './components/Recrutadores/VerRecrutadores.vue';
import RegisterRecrutador from "./components/Recrutadores/RegisterRecrutador.vue";

import Login from "./components/LoginUser.vue";
import Register from "./components/RegisterUser.vue";
import 'materialize-css/dist/css/materialize.min.css';
import 'materialize-css/dist/js/materialize.min.js';

Vue.config.productionTip = false

Vue.use(VueRouter);
Vue.use(VueMask);

// Definindo as rotas
const routes = [
  { path: '/', component: HomePage },
  { path: "/login", component: Login },
  { path: "/register-candidato", component: Register },
  { path: "/register-recrutador", component: RegisterRecrutador },
  { path: "/completar-perfil", component: Candidato },
  { path: "/completar-perfil-recrutador", component: Recrutador },
  { path: "/index", component: ListaVagas },
  { path: "/ver-vaga/:id", component: VerVaga },
  { path: "/editar-vaga/:id", component: EditarVaga },
  { path: "/cadastrar-vagas", component: CadastroVagas },
  { path: "/ver-recrutadores", component: VerRecrutadores },
  { path: "/editar-perfil/:id", component: AlterarPerfilRecrutador },
  { path: "/editar-recrutador/:id", component: EditarRecrutador },
];

// Configurando o Vue Router
const router = new VueRouter({
  mode: "history",
  routes,
});

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
