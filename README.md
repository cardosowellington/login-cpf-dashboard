# login-cpf-dashboard

## Login Inteligente via CPF + Dashboard + Controle de Viagens

## Sobre o Projeto

Este plugin permite que usuários façam login utilizando apenas o CPF (sem necessidade de e-mail/usuário tradicional).
Após a autenticação validada, o usuário é redirecionado automaticamente para um Dashboard personalizado.

- Cadastro de usuários feito apenas pelo admin no painel WordPress.
- Validação de CPF integrada.
- Área interna protegida e acessível somente após login.

## Funcionalidades

- Login unificado por CPF — sem necessidade de senha
- Criação de usuário pelo admin com o CPF
- Tabela de viagens (wp_travel_bookings) com suporte a:
  - Voos de ida e volta
  - Paradas (escalas)
  - Associação a CPF ou user_id
    - Sincronização automática entre reservas e usuários
    - Máscara e validação de CPF no front-end (jQuery)
    - Dashboard do usuário com shortcode [user_trips]
    - Painel administrativo para gerenciar viagens (Travel Bookings)
    - Sistema de login via AJAX (seguro, sem recarregar a página)

## Instalação

1. Baixe o plugin como .zip

2. No painel WordPress, acesse:
  - Plugins → Adicionar Novo → Enviar Plugin → Selecionar arquivo → Ativar

- Opção:

1. Clone este repositório ou baixe o arquivo .zip:

  git clone https://github.com/cardosowellington/login-cpf-dashboard

2. Copie a pasta para:

  /wp-content/plugins/login-cpf-dashboard

3. Ative o plugin em Plugins > Ativar no painel do WordPress.

## Como Usar

1. O usuário informa o CPF no formulário [cpf_login_form].

2. O sistema valida o CPF (formato + existência):
  - Se o CPF estiver vinculado a um usuário (wp_usermeta), faz login direto.
  - Se o CPF existir apenas em wp_travel_bookings, o sistema cria automaticamente um usuário e vincula as reservas.

3. O usuário é autenticado e redirecionado para /dashboard/.

4. No dashboard, o shortcode [user_trips] exibe as viagens cadastradas.

## Estrutura do Banco de Dados

Tabela personalizada: wp_travel_bookings

## Requisitos

- WordPress 6.0+
- PHP 8.0+
- MySQL/MariaDB 5.7+
- Extensão mbstring e json habilitadas

## Shortcodes Disponíveis

- [cpf_login_form]
  - Exibe o formulário de login via CPF
- [user_trips]
  - Mostra as viagens do usuário logado

## Roadmap

- Primeira parte:
  - Cadastro público de usuários (com aprovação do admin).
  - Opção de personalização do Dashboard pelo admin.

- Segunda parte:
  - Logs de tentativas de login.
  - Integração com APIs oficiais de validação de CPF.
  - Integração com APIs de companhias aéreas (dados em tempo real)
  - Área do cliente com edição de reservas
  - Exportação de relatórios em CSV/PDF
  - Logs detalhados de tentativas de login
  - Painel de métricas para administradores

### Contribuindo
Pull Requests são bem-vindos!
Para grandes mudanças, abra uma issue antes para discutirmos o que você gostaria de alterar.

  # Fork, branch, commit e pull request
  git checkout -b feature/nome-da-funcionalidade
  git commit -m "Adiciona nova funcionalidade"
  git push origin feature/nome-da-funcionalidade

### Autor

- Desenvolvido por Cardoso Wellington
- [LinkedIn](https://www.linkedin.com/in/cardoso-wellington/)