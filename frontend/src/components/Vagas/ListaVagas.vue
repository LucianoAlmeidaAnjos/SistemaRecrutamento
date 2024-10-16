<template>
  <div>
    <MainMenu />
    <div class="container">
      <h2>Lista de Vagas</h2>
      <button v-if="isRecruiterAuthenticated" @click="createJob" class="btn">Cadastrar Vaga</button>
      <div class="tabela">
        <table class="highlight responsive-table">
          <thead>
            <tr>
              <th>Título</th>
              <th>Descrição da vaga</th>
              <th>Habilidades</th>
              <th>Requisitos</th>
              <th>Experiência</th>
              <th>Salário</th>
              <th>Localização</th>
              <th>Tipo de Contratação</th>
              <th>Data de Abertura</th>
              <th>Data de Fechamento</th>
              <th>Contagem de Candidatos</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="vaga in vagas" :key="vaga.id">
              <td>{{ vaga.titulo }}</td>
              <td>{{ limitarDescricao(vaga.descricao, 20) }}</td>
              <td>{{ vaga.habilidades }}</td>
              <td>{{ vaga.requisitos }}</td>
              <td>{{ vaga.experiencia }}</td>
              <td>{{ formatarSalario(vaga.salario_min, vaga.salario_max) }}</td>
              <td>{{ vaga.localizacao }}</td>
              <td>{{ vaga.tipo_contrato.nome }}</td>
              <td>{{ formatarData(vaga.data_abertura) }}</td>
              <td>{{ formatarData(vaga.data_fechamento) }}</td>
              <td>{{ vaga.contagem_candidatos }}</td>
              <td>
                <button v-if="isRecruiterAuthenticated" @click="seeJob(vaga.id)" class="btn-small green">Ver Vaga</button>
                <button v-if="isRecruiterAuthenticated" @click="editJob(vaga.id)" class="btn-small">Editar</button>
                <button v-if="isRecruiterAuthenticated" @click="openDeleteModal(vaga.id)" class="btn-small red">Excluir</button>

                <!-- Verificações para o candidato -->
                <div v-if="!isRecruiterAuthenticated">
                  <button @click="seeJob(vaga.id)" class="btn-small green">Ver Vaga</button>
                  <button 
                    v-if="!vaga.estaInscrito" 
                    @click="inscreverVaga(vaga.id)" 
                    class="btn-small blue">
                    Inscrever
                  </button>
                  <span v-if="vaga.estaInscrito" class="green">INSCRITO</span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal de Confirmação -->
      <div id="deleteModal" class="modal">
        <div class="modal-content">
          <h4>Confirmar Exclusão</h4>
          <p>Você tem certeza que deseja excluir esta vaga?</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat green" @click="confirmDelete">Confirmar</a>
          <a href="#!" class="modal-close waves-effect waves-red btn-flat red">Cancelar</a>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import http from "@/http";
import MainMenu from "@/components/MainMenu.vue";
import M from "materialize-css";

export default {
  components: {
    MainMenu,
  },
  data() {
    return {
      vagas: [],
      isRecruiterAuthenticated: false,
      isCandidate: false,
      vagaIdParaExcluir: null, 
    };
  },
  mounted() {
    this.checkUserRole();
    this.fetchJobs();
    M.Modal.init(document.querySelectorAll(".modal"));
  },
  methods: {
    async fetchJobs() {
      try {
        const response = await http.get("/vagas");
        this.vagas = response.data;

        // Verificar a inscrição em cada vaga
        for (let i = 0; i < this.vagas.length; i++) {
          const estaInscrito = await this.checkInscricao(this.vagas[i].id);
          this.$set(this.vagas[i], 'estaInscrito', estaInscrito);

          const contagemResponse = await http.get(`/vagas/${this.vagas[i].id}/contagem`);
          this.$set(this.vagas[i], 'contagem_candidatos', contagemResponse.data.contagem);
        }
      } catch (error) {
        console.error(error);
      }
    },
    async checkUserRole() {
      const userId = localStorage.getItem("userId");
      try {
        const response = await http.get(`/recrutadores/${userId}`);
        this.isRecruiterAuthenticated = response.data.recrutador.autenticado;

        // Verifica se o usuário é um candidato
        if (!this.isRecruiterAuthenticated) {
          const candidatoResponse = await http.get(`/candidatos/${userId}`);
          this.isCandidate = !!candidatoResponse.data.candidato;
        }
      } catch (error) {
        console.error(error);
      }
    },
    async checkInscricao(vagaId) {
      const userId = localStorage.getItem("userId");
      try {
        const response = await http.post(`/vaga/${vagaId}/inscricao`, {
          id_vaga: vagaId,
          id_user: userId,
        });
        return response.data.inscrito;
      } catch (error) {
        console.error(error);
        return false;
      }
    },
    async inscreverVaga(vagaId) {
      const userId = localStorage.getItem("userId");
      try {
        await http.post(`/vaga/${vagaId}/inscrever`, {
          id_vaga: vagaId,
          id_user: userId,
        });
        this.fetchJobs();
      } catch (error) {
        console.error(error);
      }
    },
    createJob() {
      this.$router.push("/cadastrar-vagas");
    },
    seeJob(jobId) {
      this.$router.push(`/ver-vaga/${jobId}`);
    },
    editJob(jobId) {
      this.$router.push(`/editar-vaga/${jobId}`);
    },
    openDeleteModal(jobId) {
      this.vagaIdParaExcluir = jobId;
      const modal = M.Modal.getInstance(document.getElementById("deleteModal"));
      modal.open();
    },
    async confirmDelete() {
      if (this.vagaIdParaExcluir) {
        try {
          await http.delete(`/vagas/${this.vagaIdParaExcluir}`);
          this.fetchJobs();
        } catch (error) {
          console.error(error);
        }
      }
      this.vagaIdParaExcluir = null;
    },
    limitarDescricao(descricao, limite) {
      const palavras = descricao.split(" ");
      return palavras.slice(0, limite).join(" ") + "...";
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
.btn {
  width: 200px;
}
button {
  width: 100px;
  margin-bottom: 10px;
}
.container {
  margin-top: 50px;
  padding: 0;
}
.tabela {
  border-collapse: collapse;
  display: flex;
  justify-content: center;
  width: 100%;
  padding: 0;
  margin-top: 15px;
}
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  text-align: left;
  padding: 8px;
  border: 1px solid #ddd;
}
th {
  background-color: #f2f2f2;
  position: sticky;
  top: 0;
  z-index: 1;
}
</style>
