# 🛠️ API de Controle de Chamados de Manutenção

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat\&logo=php\&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat\&logo=mysql\&logoColor=white)
![PDO](https://img.shields.io/badge/PDO-777BB4?style=flat)
![JSON](https://img.shields.io/badge/JSON-000000?style=flat\&logo=json\&logoColor=white)
![Status](https://img.shields.io/badge/status-em%20desenvolvimento-yellow)

## 📌 Sobre o projeto

API REST desenvolvida em **PHP**, com o objetivo de facilitar o controle de chamados de manutenção de equipamentos de uma empresa.

Atualmente, os problemas podem ser informados por mensagens ou anotações em papel, dificultando o acompanhamento dos serviços e a identificação dos chamados mais urgentes.

A API centraliza essas informações em um banco de dados, permitindo **registrar, consultar, atualizar e excluir chamados** por meio de requisições HTTP.

O projeto utiliza **PHP, PDO, MySQL e JSON**, implementando as quatro operações básicas de um **CRUD**.

Projeto desenvolvido como atividade prática do curso técnico em **Desenvolvimento de Sistemas (SENAI)**.

---

## 📑 Sumário

* [Tecnologias utilizadas](#️-tecnologias-utilizadas)
* [Pré-requisitos](#-pré-requisitos)
* [Como executar](#-como-executar)
* [Banco de dados](#️-banco-de-dados)
* [Conexão](#-conexão)
* [Endpoints da API](#-endpoints-da-api)
* [Testes realizados](#-testes-realizados)
* [Demonstração](#-demonstração)
* [Conceitos aplicados](#-conceitos-aplicados)
* [Melhorias futuras](#-melhorias-futuras)
* [Estrutura de entrega](#-estrutura-de-entrega)
* [Estrutura de arquivos](#-estrutura-de-arquivos)

---

## 🛠️ Tecnologias utilizadas

* 🐘 PHP
* 🗄️ MySQL
* 🔌 PDO
* 📦 JSON
* 🧪 Thunder Client
* 🌐 HTTP / API REST

---

## 📋 Pré-requisitos

Para executar o projeto, é necessário possuir:

* PHP instalado com a extensão **PDO** e o driver **pdo_mysql** habilitados
* MySQL instalado e em execução
* Thunder Client, Insomnia ou Postman para realizar os testes da API
* Um navegador ou cliente HTTP para realizar requisições

---

## ▶️ Como executar

### 1️⃣ Criar o banco de dados

Crie o banco de dados `manutencao` no MySQL:

```sql
CREATE DATABASE manutencao;
```

### 2️⃣ Criar a tabela

Selecione o banco:

```sql
USE manutencao;
```

Depois crie a tabela:

```sql
CREATE TABLE chamados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipamento VARCHAR(100) NOT NULL,
    setor VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    prioridade VARCHAR(20) NOT NULL,
    status VARCHAR(30) NOT NULL
);
```

### 3️⃣ Configurar a conexão

Configure o arquivo `conexao.php` com os dados do seu banco de dados.

### 4️⃣ Iniciar o servidor

Na pasta do projeto, execute:

```bash
php -S localhost:8000
```

### 5️⃣ Acessar a API

A API poderá ser acessada através de:

```text
http://localhost:8000/chamados.php
```

---

## 🗄️ Banco de dados

**Banco:** `manutencao`
**Tabela:** `chamados`

| Coluna        | Tipo    | Observação                                 |
| ------------- | ------- | ------------------------------------------ |
| `id`          | INT     | 🔑 Chave primária e auto incremento        |
| `equipamento` | VARCHAR | 🖥️ Equipamento relacionado ao chamado     |
| `setor`       | VARCHAR | 🏢 Setor relacionado                       |
| `descricao`   | TEXT    | 📝 Descrição do problema                   |
| `prioridade`  | VARCHAR | ⚠️ `baixa`, `media` ou `alta`              |
| `status`      | VARCHAR | 📌 `aberto`, `em andamento` ou `concluido` |

### ⚠️ Valores permitidos

**Prioridade:**

```text
baixa
media
alta
```

**Status:**

```text
aberto
em andamento
concluido
```

---

## 🔌 Conexão

O arquivo `conexao.php` é responsável pela conexão da aplicação com o banco de dados `manutencao`.

> ⚠️ Por segurança, as credenciais reais do banco de dados não devem ser enviadas para o GitHub.

Exemplo de estrutura:

```php
<?php

$host = "localhost";
$dbname = "manutencao";
$user = "seu_usuario";
$senha = "sua_senha";

$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $user,
    $senha
);
```

---

# 📡 Endpoints da API

## 🟢 POST — Cadastrar chamado

Utilizado para registrar um novo chamado de manutenção.

### 📤 Requisição

```json
{
  "equipamento": "mouse",
  "setor": "TI",
  "descricao": "problema no mouse",
  "prioridade": "baixa",
  "status": "aberto"
}
```

### 📥 Resposta

```json
{
  "mensagem": "Chamado cadastrado com sucesso!"
}
```

> 💡 O campo `id` não precisa ser enviado no `POST`, pois ele é gerado automaticamente pelo banco de dados.

---

## 🔵 GET — Listar chamados

Utilizado para consultar todos os chamados cadastrados.

### 📥 Resposta

```json
[
  {
    "id": 3,
    "equipamento": "mouse",
    "setor": "TI",
    "descricao": "problema no mouse",
    "prioridade": "baixa",
    "status": "em andamento"
  }
]
```

---

## 🟡 PUT — Atualizar chamado

Utilizado para atualizar as informações de um chamado existente.

O chamado é localizado através do seu `id`.

### 📤 Requisição

```json
{
  "equipamento": "mouse",
  "setor": "TI",
  "descricao": "problema no mouse",
  "prioridade": "alta",
  "status": "em andamento",
  "id": 3
}
```

### 📥 Resposta

```json
{
  "mensagem": "Chamado atualizado com sucesso!"
}
```

---

## 🔴 DELETE — Excluir chamado

Utilizado para excluir um chamado através do seu `id`.

### 📤 Requisição

```json
{
  "id": 3
}
```

### 📥 Resposta

```json
{
  "mensagem": "Chamado excluído com sucesso!"
}
```

---

## 🔄 Fluxo do CRUD

```text
              🛠️ API DE MANUTENÇÃO
                       │
        ┌──────────────┼──────────────┐
        │              │              │
       POST           GET            PUT
        │              │              │
        ▼              ▼              ▼
   ➕ Cadastrar    📋 Listar      ✏️ Atualizar
        │              │              │
        └──────────────┼──────────────┘
                       │
                     DELETE
                       │
                       ▼
                  🗑️ Excluir
```

---

## ✅ Testes realizados

Os testes da API são realizados utilizando o **Thunder Client**, enviando requisições no formato JSON.

### 🧪 Exemplo utilizado

| Campo           | Valor               |
| --------------- | ------------------- |
| 🖥️ Equipamento | `mouse`             |
| 🏢 Setor        | `TI`                |
| 📝 Descrição    | `problema no mouse` |
| ⚠️ Prioridade   | `baixa`             |
| 📌 Status       | `em andamento`      |
| 🔑 ID           | `3`                 |

### Operações do CRUD

* [x] 🟢 `POST` — Cadastrar chamado
* [x] 🔵 `GET` — Listar chamados
* [x] 🟡 `PUT` — Atualizar chamado
* [x] 🔴 `DELETE` — Excluir chamado

---

## 🎥 Demonstração

> 📹 Vídeo de demonstração da API será adicionado posteriormente.

---

## 🧠 Conceitos aplicados

Durante o desenvolvimento da API foram aplicados conceitos importantes de **desenvolvimento Back-End**:

* 🌐 Criação de uma **API REST**
* 🐘 Desenvolvimento utilizando **PHP**
* 🔌 Conexão com banco de dados utilizando **PDO**
* 🗄️ Utilização do **MySQL**
* 🔄 Implementação de operações **CRUD**
* 📡 Utilização dos métodos HTTP:

  * `POST`
  * `GET`
  * `PUT`
  * `DELETE`
* 📦 Manipulação de dados em **JSON**
* 🔍 Leitura de requisições através de `php://input`
* ⚙️ Identificação do método HTTP através de `$_SERVER["REQUEST_METHOD"]`
* 🛡️ Utilização de *prepared statements*
* 🔑 Chave primária com incremento automático
* ✅ Verificação de dados obrigatórios

---

## 🚀 Melhorias futuras

Algumas melhorias que podem ser implementadas futuramente:

* [ ] 🔎 Adicionar filtros por prioridade e status
* [ ] 📊 Criar uma interface visual para gerenciamento dos chamados
* [ ] ⚠️ Melhorar o tratamento de erros
* [ ] 📡 Utilizar códigos de status HTTP apropriados
* [ ] 🔐 Adicionar autenticação de usuários
* [ ] 📈 Criar um painel com estatísticas dos chamados
* [ ] 🔍 Permitir pesquisa por equipamento ou setor

---

## 📂 Estrutura de entrega

* [x] 🗄️ Banco de dados `manutencao`
* [x] 📋 Tabela `chamados`
* [x] 🔌 `conexao.php`
* [x] 🐘 `chamados.php`
* [x] 🟢 Operação `POST`
* [x] 🔵 Operação `GET`
* [x] 🟡 Operação `PUT`
* [x] 🔴 Operação `DELETE`
* [x] 🧪 Testes da API
* [ ] 🎥 Vídeo de demonstração

---

## 🗂️ Estrutura de arquivos

```text
atividade_api_manutencao/
│
├── 📄 conexao.php       # Conexão com o banco MySQL
├── 📄 chamados.php      # Endpoints da API
└── 📄 README.md         # Documentação do projeto
```

---

## 👨‍💻 Autor

**Caio Martins marcellino**

🎓 Estudante de **Desenvolvimento de Sistemas — SENAI-SP**

---

<p align="center">
  🛠️ <strong>API de Controle de Chamados de Manutenção</strong>
  <br>
  Desenvolvido com PHP, MySQL, PDO e JSON
</p>
