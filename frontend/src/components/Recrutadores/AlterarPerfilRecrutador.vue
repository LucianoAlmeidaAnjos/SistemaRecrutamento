<template>
    <div>
        <MainMenu />
        <div class="container">
        <h2>Atualizar Perfil de Recrutador</h2>
        <form @submit.prevent="submitForm">
            <div class="input-field">
            <input type="text" v-mask="'(##)#####-####'" v-model="telefone" required />
            <label for="telefone" class="active">Telefone para contato</label>
            </div>
    
            <div class="input-field">
            <input type="text" v-model="cargo" required />
            <label for="cargo" class="active">Cargo/Função no RH</label>
            </div>
    
            <div class="input-field">
            <input type="text" v-model="empresa" required />
            <label for="empresa" class="active">Empresa</label>
            </div>
    
            <button class="btn waves-effect waves-light" type="submit">Salvar</button>
        </form>
        </div>
    </div>
</template>
  
  <script>
    import http from "@/http"; // Importando axios já configurado
    import MainMenu from "@/components/MainMenu.vue";
  
  export default {
    components: {
        MainMenu
    },
    data() {
      return {
        telefone: "",
        cargo: "",
        empresa: "",
      };
    },
    async mounted() {
      // Carregar os dados do perfil do recrutador ao montar o componente
      const userId = localStorage.getItem("userId");
     
      // Verifica se o ID do usuário no URL é o mesmo que o ID do usuário autenticado
      if (this.$route.params.id !== userId) {
       this.$router.push("/index"); // Redireciona se o usuário tentar acessar o perfil de outra pessoa
        return;
      }
  
      const response = await http.get(`/recrutadores/${userId}`);
      this.telefone = response.data.recrutador.telefone;
      this.cargo = response.data.recrutador.cargo;
      this.empresa = response.data.recrutador.empresa;
    },
    methods: {
      async submitForm() {
        try {
          const userId = localStorage.getItem("userId");
  
          await http.put(`/alterar-perfil/${userId}`, {
            telefone: this.telefone,
            cargo: this.cargo,
            empresa: this.empresa,
            id_user: userId,
          });
          alert("Perfil atualizado com sucesso!");
          this.$router.push("/index"); // Redirecionar após o sucesso
        } catch (error) {
          console.error(error);
          alert("Erro ao atualizar os dados. Tente novamente.");
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .container {
    margin-top: 50px;
  }
  .input-field {
    margin-bottom: 20px;
  }
  </style>
  