<template>
    <div>
      <MainMenu />
      <h2>{{ vaga.titulo }}</h2>
      <p><strong><b>Descrição:</b></strong> {{ vaga.descricao }}</p>
      <p><strong><b>Localização:</b></strong> {{ vaga.localizacao }}</p>
      <p><strong><b>Salário:</b></strong> {{ formatarSalario(vaga.salario_min, vaga.salario_max) }}</p>
      <p><strong><b>Habilidades:</b></strong> {{ vaga.habilidades }}</p>
      <p><strong><b>Requisitos:</b></strong> {{ vaga.requisitos }}</p>
      <p><strong><b>Experiência:</b></strong> {{ vaga.experiencia }}</p>
      <p><strong><b>Tipo de Contratação:</b></strong> {{ vaga.tipo_contrato.nome }}</p>
      <p><strong><b>Data de Abertura:</b></strong> {{ formatarData(vaga.data_abertura) }}</p>
      <p><strong><b>Data de Fechamento:</b></strong> {{ formatarData(vaga.data_fechamento) }}</p>
  
      <!-- Condicional para exibir os botões com base no tipo de usuário -->
      <div>
        <button v-if="isRecruiter" @click="editJob(vaga.id)" class="btn">Editar Vaga</button>
        <button v-if="isRecruiter" @click="deleteJob(vaga.id)" class="btn red">Excluir Vaga</button>
        <button v-if="!isRecruiter" @click="applyForJob(vaga.id)" class="btn">Inscrever-se</button>
      </div>
  
      <router-link to="/index" class="btn grey">Voltar</router-link>
    </div>
  </template>
  
  <script>
  import http from "@/http"; // Certifique-se de que o caminho está correto
  import MainMenu from '@/components/MainMenu.vue';

  export default {
    components: {
     MainMenu,
    },
    data() {
      return {
        vaga: {},
        isRecruiter: false,
        username: localStorage.getItem("username"),
        userId: localStorage.getItem("userId"),
      };
    },
    mounted() {
      this.fetchJob();
      this.checkUserRole();
    },
    methods: {
      async fetchJob() {
        const id = this.$route.params.id;
        try {
          const response = await http.get(`/vagas/${id}`);
          this.vaga = response.data;
        } catch (error) {
          console.error(error);
        }
      },
      async checkUserRole() {
        const response = await http.get(`/recrutadores/${this.userId}`);
        this.isRecruiter = response.data.autenticado;
      },
      applyForJob(id) {
        console.log(`Inscrevendo-se na vaga com ID: ${id}`);
        // Aqui você pode adicionar a lógica para inscrever-se na vaga
      },
      editJob(jobId) {
        this.$router.push(`/editar-vaga/${jobId}`); // Navega para a tela de edição da vaga
      },
      async deleteJob(jobId) {
        try {
          await http.delete(`/vagas/${jobId}`); // Chama o endpoint para excluir a vaga
          this.$router.push("/ver-vagas"); // Redireciona após a exclusão
        } catch (error) {
          console.error(error);
        }
      },
      formatarSalario(salarioMin, salarioMax) {
        const formatar = (valor) =>
          new Intl.NumberFormat("pt-BR", {
            style: "currency",
            currency: "BRL",
          }).format(valor);
        if (!salarioMax) {
          return formatar(salarioMin);
        }
        return `${formatar(salarioMin)} - ${formatar(salarioMax)}`;
      },
      formatarData(data) {
        if (!data) return "-";
        const partes = data.split("-");
        return `${partes[2]}/${partes[1]}/${partes[0]}`;
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos para a página de ver vaga */
  </style>
  