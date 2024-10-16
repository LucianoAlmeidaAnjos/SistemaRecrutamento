<template>
    <div class="container">
      <h2>Editar Vaga</h2>
      <form @submit.prevent="updateJob">
        <div class="input-field">
          <input type="text" v-model="vaga.titulo" required />
          <label for="titulo" class="active">Título da Vaga</label>
        </div>
  
        <div class="input-field">
          <textarea class="materialize-textarea" v-model="vaga.descricao" required></textarea>
          <label for="descricao" class="active">Descrição</label>
        </div>
  
        <div class="input-field">
          <textarea class="materialize-textarea" v-model="vaga.habilidades" required></textarea>
          <label for="habilidades" class="active">Habilidades</label>
        </div>
  
        <div class="input-field">
          <textarea class="materialize-textarea" v-model="vaga.requisitos"></textarea>
          <label for="requisitos" class="active">Requisitos (opcional)</label>
        </div>
  
        <div class="input-field">
          <input type="number" min="1" v-model="vaga.experiencia" required />
          <label for="experiencia" class="active">Anos de Experiência</label>
        </div>
  
        <div class="input-field">
          <input type="number" v-model="vaga.salario_min" required placeholder="Salário mínimo" />
          <label for="salario_min" class="active">Salário Mínimo</label>
        </div>
  
        <div class="input-field">
          <input type="number" v-model="vaga.salario_max" placeholder="Salário máximo" />
          <label for="salario_max" class="active">Salário Máximo (opcional)</label>
        </div>
  
        <div class="input-field">
          <input type="text" v-model="vaga.localizacao" required />
          <label for="localizacao" class="active">Localização</label>
        </div><br>
  
        <div class="input-field">
          <select v-model="vaga.id_tipo_contrato" required>
            <option value="" disabled selected>Selecione o Tipo de Contratação</option>
            <option v-for="tipo in tiposContrato" :key="tipo.id" :value="tipo.id">{{ tipo.nome }}</option>
          </select>
          <label>Tipo de Contratação</label>
        </div>
  
        <div class="input-field">
          <input type="date" v-model="vaga.data_abertura" />
          <label for="data_abertura" class="active">Data de Abertura</label>
        </div>
  
        <div class="input-field">
          <input type="date" v-model="vaga.data_fechamento" />
          <label for="data_fechamento" class="active">Data de Fechamento</label>
        </div>
  
        <button class="btn waves-effect waves-light" type="submit">Atualizar Vaga</button>
        <button @click="cancelEdit" class="btn grey">Cancelar</button>
      </form>
    </div>
  </template>
  
  <script>
  import http from "@/http"; // Importando axios já configurado
  import M from 'materialize-css';
  
  export default {
    data() {
      return {
        vaga: {
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
        },
        tiposContrato: [],
      };
    },
    methods: {
      async fetchTiposContrato() {
        try {
          const response = await http.get("/tipos-contrato");
          this.tiposContrato = response.data;
          this.$nextTick(() => {
            M.FormSelect.init(document.querySelectorAll('select')); // Inicializa o select após os dados serem carregados
          });
        } catch (error) {
          console.error(error);
        }
      },
      async fetchJob() {
        const id = this.$route.params.id;
        try {
          const response = await http.get(`/vagas/${id}`);
          this.vaga = response.data;
          this.fetchTiposContrato(); // Carregar tipos de contrato após buscar a vaga
        } catch (error) {
          console.error(error);
        }
      },
      async updateJob() {
        const id = this.$route.params.id;
        try {
          await http.put(`/vagas/${id}`, this.vaga);
          alert('Vaga atualizada com sucesso!');
          this.$router.push('/index'); // Redireciona para a lista de vagas
        } catch (error) {
          console.error(error);
          alert("Erro ao atualizar a vaga. Tente novamente.");
        }
      },
      cancelEdit() {
        this.$router.push('/index');
      },
    },
    mounted() {
      this.fetchJob(); // Carregar dados da vaga ao montar o componente
    },
  };
  </script>
  
  <style scoped>
  .container {
    margin-top: 50px;
  }
  .materialize-textarea {
  min-height: 100px; /* Defina a altura mínima desejada */
  resize: vertical; /* Permite que o usuário redimensione verticalmente */
}
  </style>
  