<template>
    <div>
      <nav>
        <div class="nav-wrapper green">
          <a href="#" class="brand-logo left">
            <img src="@/assets/logoFIESC.png" width="150px" alt="">
          </a>
          <a href="#" class="center titulo">
            Sistema de Recrutamento
          </a>
          <ul id="dropdown1" class="dropdown-content">
            <li><a href="#" @click="editProfile">Meu Perfil</a></li>
            <li><a href="#" @click="myJobs">Minhas Vagas</a></li>
            <li v-if="isAdmin"><a href="#" @click="viewRecruiters">Ver Recrutadores</a></li>
            <li class="divider"></li>
            <li><a href="#" @click="logout">Sair</a></li>
          </ul>
          <ul class="right">
            <li>
              <a class="dropdown-trigger" href="#!" data-target="dropdown1">{{ username }}</a>
            </li>
          </ul>
        </div>
      </nav>
  
      <div class="container">
        <h2>Lista de Recrutadores</h2>
        <div class="tabela">
          <table class="highlight responsive-table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Autenticado</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="recrutador in recrutadores" :key="recrutador.id">
                <td>{{ recrutador.user.nome }}</td>
                <td>{{ recrutador.user.email }}</td>
                <td>{{ recrutador.telefone }}</td>
                <td>{{ recrutador.autenticado ? 'Sim' : 'Não' }}</td>
                <td>
                  <button @click="editRecruiter(recrutador.id)" class="btn">Editar</button>
                  <button @click="deleteRecruiter(recrutador.id)" class="btn red">Excluir</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import http from "@/http";
  import M from 'materialize-css';
  
  export default {
    data() {
      return {
        username: localStorage.getItem("username"),
        recrutadores: [],
        isAdmin: localStorage.getItem("userId") === '1', // Supondo que o ID do admin é 1
      };
    },
    mounted() {
      this.fetchRecruiters();
      const dropdown = document.querySelectorAll('.dropdown-trigger');
      M.Dropdown.init(dropdown, {
        hover: true,
        constrainWidth: false,
      });
    },
    methods: {
      async fetchRecruiters() {
        try {
          const response = await http.get("/recrutadores");
          this.recrutadores = response.data;
        } catch (error) {
          console.error(error);
        }
      },
      editRecruiter(id) {
        this.$router.push(`/editar-recrutador/${id}`);
      },
      async deleteRecruiter(id) {
        if (confirm('Tem certeza que deseja excluir este recrutador?')) {
          try {
            await http.delete(`/recrutadores/${id}`);
            this.fetchRecruiters(); // Atualiza a lista
          } catch (error) {
            console.error(error);
          }
        }
      },
      editProfile() {
        this.$router.push("/editar-perfil");
      },
      myJobs() {
        this.$router.push("/minhas-vagas");
      },
      logout() {
        localStorage.removeItem("username");
        localStorage.removeItem("userId");
        this.$router.push("/login");
      },
      viewRecruiters() {
        // Lógica para visualizar recrutadores, se necessário
        this.fetchRecruiters(); // Exemplo: recarregar a lista
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    margin-top: 50px;
    padding: 0;
  }
  
  .nav-wrapper {
    padding: 0 20px;
  }
  
  .dropdown-content {
    min-width: 150px;
  }
  
  .brand-logo {
    margin-top: 10px;
    margin-left: 10px;
    position: relative;
  }
  
  .titulo {
    font-size: 30px;
  }
  
  .tabela {
    display: flex;
    justify-content: center;
    width: 100%;
    padding: 0;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    text-align: left;
    padding: 8px;
  }
  
  th {
    background-color: #f2f2f2;
    position: sticky;
    top: 0;
    z-index: 1;
  }
  </style>
  