# Dockerfile para Vue.js
FROM node:14

# Define o diretório de trabalho
WORKDIR /app

# Copia os arquivos do projeto para o contêiner
COPY package*.json ./
RUN npm install

COPY . .

# Compila a aplicação
RUN npm run build

# Expondo a porta 8080
EXPOSE 8080

CMD ["npm", "run", "serve"]
