<template>
    <nav>
      <div class="nav-wrapper green">
        <a href="/index" class="brand-logo left">
          <img src="@/assets/logoFIESC.png" width="150px" alt="Logo FIESC">
        </a>
        <a href="/index" class="center titulo">
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
            <!-- Adiciona hover:true para abrir ao passar o mouse -->
            <a class="dropdown-trigger" href="#!" data-target="dropdown1">{{ username }}</a>
          </li>
        </ul>
      </div>
    </nav>
  </template>
  
  <script>
  import M from 'materialize-css';
  
  export default {
    data() {
      return {
        username: localStorage.getItem("username"),
        userId: localStorage.getItem("userId"),
        isAdmin: false,
      };
    },
    mounted() {
      // Verifica se o usuário é admin
      this.isAdmin = this.userId === "1";
  
      // Inicializa o dropdown do Materialize
      const dropdown = document.querySelectorAll('.dropdown-trigger');
      M.Dropdown.init(dropdown, {
        hover: true, // Abre o dropdown automaticamente ao passar o mouse
        constrainWidth: false, // Permite que o dropdown tenha a largura de acordo com seu conteúdo
        coverTrigger: false, // Garante que o dropdown não cubra o botão de ativação
      });
    },
    methods: {
      editProfile() {
        let id = this.userId;
        this.$router.push(`/editar-perfil/${id}`);
      },
      myJobs() {
        this.$router.push("/teste");
      },
      viewRecruiters() {
        this.$router.push("/ver-recrutadores");
      },
      logout() {
        localStorage.removeItem("username");
        localStorage.removeItem("userId");
        this.$router.push("/login");
      }
    }
  };
  </script>
  
  <style scoped>
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
  </style>
  