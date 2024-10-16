<template>
  <div>
    <MainMenu />
  <div class="container">
    <h2>Cadastrar Vaga</h2>
    <form @submit.prevent="submitForm">
      <div class="input-field">
        <input type="text" v-model="titulo" required />
        <label for="titulo" class="active">Título da Vaga</label>
      </div>

      <div class="input-field">
        <textarea class="materialize-textarea" v-model="descricao" required></textarea>
        <label for="descricao" class="active">Descrição</label>
      </div>

      <div class="input-field">
        <textarea class="materialize-textarea" v-model="habilidades" required></textarea>
        <label for="habilidades" class="active">Habilidades</label>
      </div>

      <div class="input-field">
        <textarea class="materialize-textarea" v-model="requisitos"></textarea>
        <label for="requisitos" class="active">Requisitos (opcional)</label>
      </div>

      <div class="input-field">
        <input type="number" min="1" v-model="experiencia" required />
        <label for="experiencia" class="active">Anos de Experiência</label>
      </div>

      <div class="input-field">
        <input type="number" v-model="salario_min" required placeholder="Salário mínimo" />
        <label for="salario_min" class="active">Salário Mínimo</label>
      </div>
      
      <div class="input-field">
        <input type="number" v-model="salario_max" placeholder="Salário máximo" />
        <label for="salario_max" class="active">Salário Máximo (opcional)</label>
      </div>

      <div class="input-field">
        <input type="text" v-model="localizacao" required />
        <label for="localizacao" class="active">Localização</label>
      </div><br>

      <div class="input-field">
        <select v-model="id_tipo_contrato" required>
          <option value="" disabled selected>Selecione o Tipo de Contratação</option>
          <option v-for="tipo in tiposContrato" :key="tipo.id" :value="tipo.id">{{ tipo.nome }}</option>
        </select>
        <label>Tipo de Contratação</label>
      </div>

      <div class="input-field">
        <input type="date" v-model="data_abertura" />
        <label for="data_abertura" v-mask="'dd/mm/yyyy'" class="active">Data de Abertura</label>
      </div>

      <div class="input-field">
        <input type="date" v-model="data_fechamento" />
        <label for="data_fechamento" class="active">Data de Fechamento</label>
      </div>

      <button class="btn waves-effect waves-light" type="submit">Cadastrar Vaga</button>
    </form>
  </div>
</div>

</template>

<script>
import http from "@/http"; // Importando axios já configurado
import M from 'materialize-css';
import MainMenu from "@/components/MainMenu.vue";


export default {
  components: {
    MainMenu
  },
  data() {
    return {
      titulo: "",
      descricao: "",
      habilidades: "",
      requisitos: "",
      experiencia: null,
      salario_min: null,
      salario_max: null,
      localizacao: "",
      id_tipo_contrato: null,
      data_abertura: "",
      data_fechamento: "",
      tiposContrato: [],
    };
  },
  methods: {
    async fetchTiposContrato() {
      try {
        const response = await http.get("/tipos-contrato"); // Endpoint para pegar tipos de contrato
        this.tiposContrato = response.data;
        this.$nextTick(() => {
          M.FormSelect.init(document.querySelectorAll('select')); // Inicializa o select após os dados serem carregados
        });
      } catch (error) {
        console.error(error);
      }
    },
    async submitForm() {
      try {
        const userId = localStorage.getItem("userId");
        await http.post("/cadastrar-vaga", {
          titulo: this.titulo,
          descricao: this.descricao,
          habilidades: this.habilidades,
          requisitos: this.requisitos,
          experiencia: this.experiencia,
          salario_min: this.salario_min,
          salario_max: this.salario_max,
          localizacao: this.localizacao,
          id_tipo_contrato: this.id_tipo_contrato,
          id_user: userId, // ID do usuário que está cadastrando a vaga
          data_abertura: this.data_abertura,
          data_fechamento: this.data_fechamento,
        });

        this.$router.push("/index"); // Redirecionar após o cadastro
      } catch (error) {
        console.error(error);
        alert("Erro ao cadastrar a vaga. Tente novamente.");
      }
    },
  },
  mounted() {
    this.fetchTiposContrato(); // Carregar tipos de contrato ao montar o componente
  },
};
</script>

<style scoped>
.container {
  margin-top: 50px;
}
</style>