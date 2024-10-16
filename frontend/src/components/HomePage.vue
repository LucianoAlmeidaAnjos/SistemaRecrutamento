<template>
    <div class="container center-align">
      <h1><img width="150px" src="@/assets/logoFIESC.png" alt="Logo" class="logo" />Sistema de Recrutamento</h1>
      
      
      <div class="row">
        <button 
          class="btn-large waves-effect waves-light" 
          @click="goToRegisterRecrutador">
          Quero me cadastrar como recrutador
        </button>
      </div>
  
      <div class="row">
        <button 
          class="btn-large waves-effect waves-light" 
          @click="goToRegisterCandidato">
          Quero me cadastrar como candidato
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    methods: {
      goToRegisterRecrutador() {
        // Redireciona para a tela de cadastro de recrutador (a ser implementada se necessário)
        this.$router.push("/register-recrutador");
      },
      goToRegisterCandidato() {
        // Redireciona para a tela de cadastro de candidato
        this.$router.push("/register-candidato");
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    margin-top: 50px;
  }
  
  .logo {
    max-width: 150px;
  }
  </style>
  