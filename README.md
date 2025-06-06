# Sistema de Gerenciamento de Óticas

Uma API RESTful completa para gerenciamento de óticas especializadas em oftalmologia, desenvolvida com Laravel e React. O sistema oferece controle total de estoque, vendas, clientes e relatórios gerenciais.

🔗 **[Demo Online](https://oticamundial.clinicadeolhos.shop/)**

## 📋 Sobre o Projeto

Este sistema foi desenvolvido para atender às necessidades específicas de óticas, oferecendo uma solução completa para:
- Gestão de estoque (lentes e armações)
- Controle de vendas e clientes
- Sistema de autenticação e autorização
- Relatórios gerenciais
- Recuperação de senha

O projeto foi desenvolvido em colaboração com outros profissionais, demonstrando habilidades práticas em desenvolvimento full-stack.

## ⚡ Funcionalidades

### 🔐 Autenticação e Autorização
- Sistema de login com JWT
- Controle de acesso baseado em roles
- Recuperação de senha via email
- Middleware de proteção de rotas

### 👥 Gestão de Usuários e Clientes
- CRUD completo de usuários do sistema
- Cadastro e gerenciamento de clientes
- Histórico de compras por cliente

### 📦 Controle de Estoque
- Gestão de lentes (tipos, graduações, preços)
- Controle de armações (modelos, cores, tamanhos)
- Alertas de estoque baixo
- Histórico de movimentações

### 💰 Sistema de Vendas
- Registro de vendas completo
- Associação de produtos aos clientes
- Cálculo automático de totais
- Status de pagamento

### 📊 Relatórios
- Relatórios de vendas por período
- Análise de estoque
- Performance de produtos
- Dados de clientes

## 🛠️ Tecnologias Utilizadas

### Backend
- ![Laravel](https://img.shields.io/badge/Laravel-8.x-FF2D20?style=flat&logo=laravel&logoColor=white)
- ![JWT](https://img.shields.io/badge/JWT-Auth-000000?style=flat&logo=json-web-tokens&logoColor=white)
- ![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
- ![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php&logoColor=white)

### Frontend
- ![React](https://img.shields.io/badge/React-18.x-61DAFB?style=flat&logo=react&logoColor=black)
- ![Styled Components](https://img.shields.io/badge/Styled--Components-5.x-DB7093?style=flat&logo=styled-components&logoColor=white)
- ![Axios](https://img.shields.io/badge/Axios-1.x-5A29E4?style=flat&logo=axios&logoColor=white)

## 🚀 Endpoints da API

| Método | Endpoint | Descrição | Autenticação |
|--------|----------|-----------|--------------|
| `POST` | `/api/auth/login` | Login do usuário | ❌ |
| `POST` | `/api/auth/register` | Registro de usuário | ❌ |
| `POST` | `/api/auth/logout` | Logout do usuário | ✅ |
| `GET` | `/api/users` | Listar usuários | ✅ |
| `POST` | `/api/users` | Criar usuário | ✅ |
| `PUT` | `/api/users/{id}` | Atualizar usuário | ✅ |
| `DELETE` | `/api/users/{id}` | Deletar usuário | ✅ |
| `GET` | `/api/customers` | Listar clientes | ✅ |
| `POST` | `/api/customers` | Criar cliente | ✅ |
| `PUT` | `/api/customers/{id}` | Atualizar cliente | ✅ |
| `DELETE` | `/api/customers/{id}` | Deletar cliente | ✅ |
| `GET` | `/api/lenses` | Listar lentes | ✅ |
| `POST` | `/api/lenses` | Criar lente | ✅ |
| `PUT` | `/api/lenses/{id}` | Atualizar lente | ✅ |
| `DELETE` | `/api/lenses/{id}` | Deletar lente | ✅ |
| `GET` | `/api/frames` | Listar armações | ✅ |
| `POST` | `/api/frames` | Criar armação | ✅ |
| `PUT` | `/api/frames/{id}` | Atualizar armação | ✅ |
| `DELETE` | `/api/frames/{id}` | Deletar armação | ✅ |
| `GET` | `/api/sales` | Listar vendas | ✅ |
| `POST` | `/api/sales` | Criar venda | ✅ |
| `GET` | `/api/sales/{id}` | Detalhes da venda | ✅ |
| `PUT` | `/api/sales/{id}` | Atualizar venda | ✅ |

## 📥 Instalação e Configuração

### Pré-requisitos
- PHP 8.0+
- Composer
- Node.js 16+
- MySQL 8.0+
- Git

### Backend (Laravel API)

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/sistema-otica-api.git
cd sistema-otica-api

# Instale as dependências do PHP
composer install

# Copie o arquivo de ambiente
cp .env.example .env

# Configure as variáveis de ambiente no .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=otica_db
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

JWT_SECRET=sua_chave_jwt_secreta

# Gere a chave da aplicação
php artisan key:generate

# Gere a chave JWT
php artisan jwt:secret

# Execute as migrations
php artisan migrate

# (Opcional) Execute os seeders para dados de teste
php artisan db:seed

# Inicie o servidor
php artisan serve
```

### Frontend (React)

```bash
# Navegue para o diretório do frontend
cd frontend

# Instale as dependências
npm install

# Configure a URL da API no arquivo .env
REACT_APP_API_URL=http://localhost:8000/api

# Inicie o servidor de desenvolvimento
npm start
```

## 🔧 Configuração do Ambiente

### Variáveis de Ambiente (.env)

```env
APP_NAME="Sistema Ótica"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=otica_db
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=
JWT_TTL=1440

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@otica.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## 📚 Documentação da API

### Autenticação

A API utiliza JWT (JSON Web Tokens) para autenticação. Inclua o token no header de todas as requisições protegidas:

```bash
Authorization: Bearer {seu_token_jwt}
```

### Exemplo de Uso

```javascript
// Login
const response = await axios.post('/api/auth/login', {
  email: 'usuario@email.com',
  password: 'senha123'
});

const token = response.data.access_token;

// Usar o token nas próximas requisições
const config = {
  headers: { Authorization: `Bearer ${token}` }
};

const users = await axios.get('/api/users', config);
```

## 🧪 Testes

```bash
# Execute os testes
php artisan test

# Execute os testes com coverage
php artisan test --coverage
```

## 📱 Screenshots

### Dashboard Principal
*[Adicione screenshots do sistema aqui]*

### Gestão de Estoque
*[Adicione screenshots da tela de estoque]*

### Relatórios
*[Adicione screenshots dos relatórios]*

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`)
3. Commit suas mudanças (`git commit -am 'Adiciona nova feature'`)
4. Push para a branch (`git push origin feature/nova-feature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👨‍💻 Autores

- **Seu Nome** - *Desenvolvedor Principal* - [Seu GitHub](https://github.com/seu-usuario)
- **Nome do Colaborador** - *Colaborador* - [GitHub do Colaborador](https://github.com/colaborador)

## 🆘 Suporte

Se você encontrar algum problema ou tiver dúvidas:

1. Verifique as [Issues abertas](https://github.com/seu-usuario/sistema-otica-api/issues)
2. Abra uma nova issue se necessário
3. Entre em contato: seu-email@exemplo.com

## 🔄 Changelog

### [1.0.0] - 2024-XX-XX
- Versão inicial
- Sistema de autenticação JWT
- CRUD completo para usuários, clientes, lentes e armações
- Sistema de vendas
- Relatórios básicos

---

⭐ **Se este projeto foi útil para você, deixe uma estrela!**
