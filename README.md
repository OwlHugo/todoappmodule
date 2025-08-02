
### 1. Clone o repositório
```bash
git clone <url-do-repositorio>
cd todo-task
```

### 2. Inicie os containers Docker
```bash
docker compose up -d
```

### 3. Instale as dependências do PHP
```bash
docker exec -it todotask-php composer install
```

### 4. Execute as migrações
```bash
docker exec -it todotask-php php artisan migrate
```

### 5. Execute os seeders
```bash
docker exec -it todotask-php php artisan db:seed
```

### 6. Instale as dependências do Node.js
```bash
npm install
```

### 7. Compile os assets
```bash
npm run dev
```

## 🌐 Acessando a Aplicação

Após seguir todos os passos acima, a aplicação estará disponível em:

- **URL:** http://localhost
- **Usuário Admin:** admin@todo.com
- **Senha:** password
