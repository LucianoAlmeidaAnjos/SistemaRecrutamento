<template>
    <div class="container">
      <h2>Complete seu Perfil</h2>
      <form @submit.prevent="submitForm">
        <div class="input-field">
          <textarea class="materialize-textarea" v-model="experiencia" required></textarea>
          <label for="experiencia">Experiência Profissional</label>
        </div>

        <div class="input-field">
          <input type="text" v-mask="'(##)#####-####'" v-model="telefone" required />
          <label for="telefone" class="active">Telefone</label>
        </div>
  
        <div class="input-field">
          <input
            type="text"
            v-model="habilidadeInput"
            @keyup.enter="addHabilidade"
            placeholder="Digite uma habilidade e pressione Enter"
          />
          <label for="habilidadeInput" class="active">Habilidades (adicione várias)</label>
        </div>
  
        <div class="habilidades-list">
          <span class="habilidade" v-for="(habilidade, index) in habilidades" :key="index">
            {{ habilidade }}
            <span class="remove-habilidade" @click="removeHabilidade(index)">x</span>
          </span>
        </div>
  
        <div class="input-field">
          <select v-model="tempo" required>
            <option value="" disabled selected>Escolha seu tempo de experiência</option>
            <option value="1">Menos de 6 meses</option>
            <option value="2">6-12 meses</option>
            <option value="3">12-24 meses</option>
            <option value="4">+24 meses</option>
          </select>
          <label>Tempo de Experiência</label>
        </div>
  
        <div class="row">
          <div class="input-field col s6">
            <input type="number"  v-model="salario_min" placeholder="Salário mínimo" />
            <label for="salario_min" class="active">Salário mínimo</label>
          </div>
          <div class="input-field col s6">
            <input type="number" v-model="salario_max" placeholder="Salário máximo" />
            <label for="salario_max" class="active">Salário máximo</label>
          </div>
        </div>
  
        
  
        <button class="btn waves-effect waves-light" type="submit">Salvar</button>
      </form>
    </div>
  </template>
  
  <script>
  import http from "@/http"; // Importando axios já configurado
  import M from 'materialize-css';

  export default {
    data() {
      return {
        experiencia: "",
        habilidades: [],
        habilidadeInput: "", // Para armazenar a habilidade digitada
        tempo: "", // Corrigido para string para compatibilidade com o select
        salario_min: null,
        salario_max: null,
        telefone: "",
      };
    },
    methods: {
      addHabilidade() {
        const habilidade = this.habilidadeInput.trim();
        if (habilidade && !this.habilidades.includes(habilidade)) {
          this.habilidades.push(habilidade);
        }
        this.habilidadeInput = ""; // Limpar o campo de entrada
      },
      removeHabilidade(index) {
        this.habilidades.splice(index, 1); // Remover a habilidade selecionada
      },
      async submitForm() {
        try {
          // Pegar o ID do usuário do localStorage
          const userId = localStorage.getItem("userId");
  
          // Log para verificar os dados antes de enviar
          console.log("Dados enviados:", {
            experiencia: this.experiencia,
            habilidades: this.habilidades.join(", "),
            tempo: this.tempo,
            salario_min: this.salario_min,
            salario_max: this.salario_max,
            telefone: this.telefone,
            id_user: userId,
          });
  
          // Enviar os dados para a API Laravel
          await http.post("/completar-perfil", {
            experiencia: this.experiencia,
            habilidades: this.habilidades.join(", "),
            tempo: this.tempo,
            salario_min: this.salario_min,
            salario_max: this.salario_max,
            telefone: this.telefone,
            id_user: userId,
          });
  
          // Redirecionar para o dashboard ou outra página após o preenchimento
          this.$router.push("/index");
        } catch (error) {
          console.error(error);
          alert("Erro ao salvar os dados. Tente novamente.");
        }
      },
    },
    mounted() {
      // Inicializa o select do Materialize CSS após o componente ser montado
      this.$nextTick(() => {
        const elems = document.querySelectorAll('select');
        M.FormSelect.init(elems);
      });
    },
  };
  </script>
  
  <style scoped>
  .container {
    margin-top: 50px;
  }
  .row {
    margin-bottom: 0;
  }
  .input-field {
    margin-bottom: 20px;
  }
  .habilidades-list {
    margin: 10px 0;
  }
  .habilidade {
    display: inline-block;
    background-color: #e0e0e0;
    padding: 5px 10px;
    border-radius: 3px;
    margin: 2px;
  }
  .remove-habilidade {
    margin-left: 5px;
    cursor: pointer;
    color: red;
  }
  </style>
  