## Documentação da API

### Autenticação
Esta rota é utilizada para obter o token de acesso à API. Você precisa fornecer o email e senha do usuário cadastrado anteriormente.

#### Solicitação

```http
  POST /api/authenticate
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `email` | `string` | **Obrigatório**. Email do usuário |
| `password` | `string` | **Obrigatório**. Senha do usuário |

- Exemplo de Solicitação
```http
curl -X POST http://localhost:8000/api/authenticate \
  -H "Content-Type: application/json" \
  -d 'email=seu-email@example.com' \
  -d 'password=sua-senha' 
```

#### Resposta

Retorna o token de acesso à api. Este token não possui expiração definida.
- Exemplo de resposta

```Json
{
  "token": "seu-token-de-acesso"
}
```

### Verificar autenticação
Esta rota é utilizada para verificar se o token está autorizado na aplicação.

#### Solicitação

```http
  GET /api/user
```

Esta rota não recebe nenhum parâmetro. Porem é necessário que a requisição contenha o token de autorização no header da requisição (assim como todas as outras rotas exceto a de autorização)

- Exemplo de Solicitação
```http
curl -X GET http://localhost:8000/api/user \
  -H "Content-Type: application/json" \
  -H 'Authorization: Bearer seu-token-de-acesso'
```

#### Resposta

Retorna os dados do Usuário logado
- Resposta

```Json
{
  "id": 2,
  "name": "Administrador",
  "email": "admin@admin.com",
  "email_verified_at": null,
  "created_at": "2024-05-02T00:13:00.000000Z",
  "updated_at": "2024-05-02T00:13:00.000000Z"
}
```

### Listagem de Pacotes
Esta rota é utilizada listar os pacotes cadastrados na aplicação com seus eventos.

#### Solicitação

```http
  GET /api/list-packages
```

- Exemplo de Solicitação
```http
curl -X GET http://localhost:8000/api/list-packages \
  -H "Content-Type: application/json" \
  -H 'Authorization: Bearer seu-token-de-acesso'
```

#### Resposta

Retorna os dados dos pacotes e seus eventos.
- Exemplo de resposta

```Json
[
  {
    "id": 102,
    "codigo": "XX123456789BR",
    "host": "mr",
    "time": "0.203",
    "quantidade": 6,
    "servico": null,
    "ultimo": "2024-01-11 19:38",
    "created_at": "2024-05-02T12:27:45.000000Z",
    "updated_at": "2024-05-03T13:44:20.000000Z",
    "package_event": [
      {
        "id": 313,
        "package_id": 102,
        "data": "2024-01-11 16:38:02",
        "local": "Agência dos Correios - XXXXXX/XX",
        "status": "Objeto entregue ao destinatário",
        "sub_status": [
          "Origem: Agência dos Correios - XXXXXX/XX"
        ],
        "created_at": "2024-05-03T13:44:20.000000Z",
        "updated_at": "2024-05-03T13:44:20.000000Z"
      },
    ]
  }
]
```

### Adição de pacotes
Esta rota é utilizada adicionar pacotes na aplicação.

#### Solicitação

```http
  POST /api/store-packages
```

| Parâmetro   | Tipo       | Descrição                           |
| :---------- | :--------- | :---------------------------------- |
| `codigos` | `string` | **Obrigatório**. Códigos de pacotes, separados por virgula, a serem armazenados. Cada código precisa ser uma string única. |

- Exemplo de Solicitação
```http
curl -X POST http://seu-endereco-da-api/api/store-packages \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN_AQUI" \
  -d '{
    "codigos": "XX123456789BR,XX987654321BR"
  }'
```

#### Resposta

Retorna os dados dos pacotes e seus eventos.
- Exemplo de resposta

```Json
{
  "message": "Pacotes criados com sucesso!"
}
```

### Atualizar pacote específico
Esta rota é utilizada buscar informações atualizadas de um pacote específico

#### Solicitação

```http
  GET /api/update-package/{Código-do-pacote}
```

- Exemplo de Solicitação
```http
curl -X GET http://seu-endereco-da-api/api/update-package/{Código-do-pacote} \
  -H "Authorization: Bearer SEU_TOKEN_AQUI"
```

#### Resposta

Retorna os dados do pacote e seus eventos.
- Exemplo de resposta

```Json
{
    "id": 102,
    "codigo": "XX123456789BR",
    "host": "mr",
    "time": "0.203",
    "quantidade": 6,
    "servico": null,
    "ultimo": "2024-01-11 19:38",
    "created_at": "2024-05-02T12:27:45.000000Z",
    "updated_at": "2024-05-03T13:44:20.000000Z",
    "package_event": [
      {
        "id": 313,
        "package_id": 102,
        "data": "2024-01-11 16:38:02",
        "local": "Agência dos Correios - XXXXXX/XX",
        "status": "Objeto entregue ao destinatário",
        "sub_status": [
          "Origem: Agência dos Correios - XXXXXX/XX"
        ],
        "created_at": "2024-05-03T13:44:20.000000Z",
        "updated_at": "2024-05-03T13:44:20.000000Z"
      },
    ]
}
```