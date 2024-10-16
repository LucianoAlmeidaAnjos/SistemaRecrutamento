<template>
    <div class="login-container">
      <h1>Login</h1>
      <form @submit.prevent="login">
        <div>
          <label for="email">Email:</label>
          <input type="email" v-model="email" required />
        </div>
        <div>
          <label for="password">Senha:</label>
          <input type="password" v-model="password" required />
        </div>
        <button class="btn waves-effect waves-light" type="submit">Login</button>
      </form>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    </div>
  </template>
  
  <script>
  import http from "@/http"; // Importando axios já configurado

  export default {
    data() {
      return {
        email: '',
        password: '',
        errorMessage: null,
      };
    },
    methods: {
      async login() {
            try {
              const response = await http.post('/login', {
                email: this.email,
                password: this.password,
              });

              // Supondo que a resposta contenha informações sobre o usuário
              const user = response.data.user;
              const completo = response.data.completo;

              // Armazenar o ID do usuário e o tipo no localStorage
              localStorage.setItem('userId', user.id);
              localStorage.setItem('userType', user.recrutador ? 'recrutador' : 'candidato');
              localStorage.setItem("username", user.nome);

              // Verificar se o usuário precisa completar o perfil
              if (!completo) {
                // Redirecionar de acordo com o tipo de usuário
                if (user.recrutador) {
                  this.$router.push('/completar-perfil-recrutador'); // Rota para completar perfil do recrutador
                } else {
                  this.$router.push('/completar-perfil'); // Rota para completar perfil do candidato
                }
              } else {
                this.$router.push('/index'); // Redireciona para o dashboard se o perfil estiver completo
              }
            } catch (error) {
              console.error(error);
              alert('Erro ao fazer login. Verifique suas credenciais.');
            }
      },
    },
  };
  </script>
  
  <style scoped>
  .login-container {
    max-width: 400px;
    margin: 0 auto;
  }
  .error {
    color: red;
  }
  </style>