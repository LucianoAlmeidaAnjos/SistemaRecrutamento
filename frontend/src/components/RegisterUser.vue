<template>
  <div class="container">
    <h2>Registro de Candidato</h2>
    <form @submit.prevent="submitForm">
      <div class="input-field">
        <input type="text" id="nome" v-model="nome" required />
        <label for="nome" class="active">Nome completo</label>
      </div>
      <div class="input-field">
        <input type="email" id="email" v-model="email" required />
        <label for="email" class="active">Email</label>
      </div>
      <div class="input-field">
        <input type="password" id="password" v-model="password" required />
        <label for="password" class="active">Senha</label>
      </div>
      <div class="input-field">
        <input type="password" id="password_confirmation" v-model="password_confirmation" required />
        <label for="password_confirmation" class="active">Confirmação de Senha</label>
      </div>
      <button class="btn waves-effect waves-light" type="submit">Registrar</button>
    </form>
  </div>
</template>

<script>
import http from "@/http"; // Importando axios já configurado

export default {
  data() {
    return {
      nome: "",
      email: "",
      password: "",
      password_confirmation: "",
    };
  },
  methods: {
    async submitForm() {
      try {
        // Faz a chamada da API Laravel para o cadastro
        await http.post("/register", {
          nome: this.nome,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        });

        // Alerta de sucesso
        alert("Usuário cadastrado com sucesso!");
        
        // Redireciona para a página de login após o cadastro
        this.$router.push("/login");
      } catch (error) {
        console.error(error);

        // Lida com erros na resposta
        if (error.response && error.response.status === 422) {
          alert("Erro de validação. Verifique os campos e tente novamente.");
        } else {
          alert("Erro ao cadastrar o usuário.");
        }
      }
    },
  },
};
</script>

<style scoped>
.container {
  margin-top: 50px;
}
</style>
