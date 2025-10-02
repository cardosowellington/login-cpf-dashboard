# login-cpf-dashboard

## Login com CPF + Dashboard (WordPress Plugin)

## Sobre o Projeto

Este plugin permite que usuários façam login utilizando apenas o CPF (sem necessidade de e-mail/usuário tradicional).
Após a autenticação validada, o usuário é redirecionado automaticamente para um Dashboard personalizado.

- Cadastro de usuários feito apenas pelo admin no painel WordPress.
- Validação de CPF integrada.
- Área interna protegida e acessível somente após login.

## Funcionalidades

- Login com CPF único.
- Validação automática do CPF informado.
- Gerenciamento de usuários feito pelo administrador.
- Redirecionamento para o Dashboard restrito.
- Integração transparente ao fluxo nativo de autenticação do WordPress.

## Instalação

1. Clone este repositório ou baixe o arquivo .zip:

  git clone https://github.com/cardosowellington/login-cpf-dashboard

2. Copie a pasta para:

  /wp-content/plugins/login-cpf-dashboard

3. Ative o plugin em Plugins > Ativar no painel do WordPress.

## Como Usar

1. O admin cadastra usuários no WordPress, incluindo o campo CPF.

2. O usuário acessa a página de login por CPF criada pelo plugin.

3. Após login válido, o usuário é redirecionado ao Dashboard interno.

## Requisitos

- WordPress 6.0+
- PHP 8.0+
- MySQL/MariaDB 5.7+

## Roadmap

- Cadastro público de usuários (com aprovação do admin).
- Integração com APIs oficiais de validação de CPF.
- Logs de tentativas de login.
- Opção de personalização do Dashboard pelo admin.

### Contribuindo
Pull Requests são bem-vindos!
Para grandes mudanças, abra uma issue antes para discutirmos o que você gostaria de alterar.

### Autor

- Desenvolvido por Cardoso Wellington
- [LinkedIn](https://www.linkedin.com/in/cardoso-wellington/)