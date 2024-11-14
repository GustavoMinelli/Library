<h1> Sistema de gerenciamento de uma Biblioteca </h1>

<h2>Como Executar o Projeto</h2>
<p>Siga os passos abaixo para executar o projeto em sua máquina local:</p>

<h3>Pré-requisitos</h3>
<ul>
    <li>PHP ^8.2</li>
    <li>Composer</li>
    <li>Node.js ^18.20</li>
    <li>NPM</li>
</ul>

<h3>Instalação</h3>
<ol>
    <li>Clone o repositório para sua máquina local:
        <pre><code>git clone https://github.com/GustavoMinelli/Library.git</code></pre>
    </li>
    <li>Entre no diretório do projeto:
        <pre><code>cd seu-repositorio</code></pre>
    </li>
    <li>Copie o arquivo de exemplo do ambiente:
        <pre><code>cp .env.example .env</code></pre>
    </li>
    <li>Instale as dependências do PHP:
        <pre><code>composer install</code></pre>
    </li>
    <li>Instale as dependências do Node.js:
        <pre><code>npm install</code></pre>
    </li>
    <li>Gere a chave da aplicação:
        <pre><code>php artisan key:generate</code></pre>
    </li>
    <li>Execute as migrações do banco de dados:
        <pre><code>php artisan migrate</code></pre>
    </li>
    <li>Inicie o servidor de desenvolvimento:
        <pre><code>php artisan serve</code></pre>
    </li>
</ol>

<p>Agora você pode acessar o projeto em <a href="http://localhost:8000">http://localhost:8000</a>.</p>