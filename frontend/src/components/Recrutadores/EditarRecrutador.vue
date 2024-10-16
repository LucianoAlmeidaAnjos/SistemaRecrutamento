<template>
  <div>
    <h2>Editar Recrutador</h2>
    <form @submit.prevent="updateRecruiter">
      <div class="input-field"><br>
        <label>Nome:</label>
        <input type="text" v-model="recrutador.user.nome" id="nome" disabled />
      </div>
      <div class="input-field"><br>
        <label>E-mail:</label>
        <input type="email" v-model="recrutador.user.email" id="email" disabled />
      </div>
      <div class="input-field"><br>
        <label>Autenticado:</label><br>
        <div class="rad">
          <label>
            <input name="autenticado" type="radio" v-model="recrutador.autenticado" :value="true" />
            <span>Sim</span>
          </label>

          <label>
            <input name="autenticado" type="radio" v-model="recrutador.autenticado" :value="false" />
            <span>Não</span>
          </label>
        </div>
      </div><br><br>
      <button type="submit" class="btn">Atualizar</button>
      <button @click="cancelEdit" class="btn grey">Cancelar</button>
    </form>
  </div>
</template>

<script>
import http from "@/http";

export default {
  data() {
    return {
      recrutador: {
        user: {
          nome: '',
          email: ''
        },
        autenticado: false,
      },
    };
  },
  mounted() {
    this.fetchRecruiter();
  },
  methods: {
    async fetchRecruiter() {
      const id = this.$route.params.id;
      try {
        const response = await http.get(`/recrutadores/${id}`);
        this.recrutador = response.data;
        // Garantir que o valor de autenticado seja true ou false
        this.recrutador.autenticado = response.data.recrutador.autenticado;
      } catch (error) {
        console.error(error);
      }
    },
    async updateRecruiter() {
      const id = this.$route.params.id;
      try {
        await http.put(`/recrutadores/${id}`, {
          autenticado: this.recrutador.autenticado,
        });
        alert('Recrutador atualizado com sucesso!');
        this.$router.push('/ver-recrutadores');
      } catch (error) {
        console.error(error);
      }
    },
    cancelEdit() {
      this.$router.push('/ver-recrutadores');
    },
  },
};
</script>

<style scoped>
form {
  margin-left: 20px;
}
.input-field {
  margin: 20px 0;
}
.input-field label {
  display: block;
  margin-bottom: 10px;
}
input[type="radio"] {
  margin-right: 5px;
}
.rad {
  position: absolute;
}
</style>
