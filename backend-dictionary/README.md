# Back-end Challenge - Dictionary

>  This is a challenge by [Coodesh](https://coodesh.com/)

## Tecnologias

- O projeto foi criado usando PHP na versão 8.2 e laravel na versao 11
- Para a geração de token foi utilizado o Sactum do proprio laravel.
- Para realizar chamada na api [FreeDictionary](https://dictionaryapi.dev/) foi utilizado o Guzzle
- A Documentação dos endpoints foi escrita utilizando [Scribe](https://scribe.knuckles.wtf/laravel/)
- Para rodar a aplicação foi utilizado Docker
- No banco de dados foi utilizado PostgreSql
- Para armazenar o cache da aplicação foi utilizado o Redis

<hr>

## Instalação

Há duas formas de iniciar o projeto, sendo via docker ou instalando as ferramentas necessarias a parte

- ### *Utilzando Docker*
  - Com o docker e docker compose instalado no sistema operacional, e com o arquivo .env configurado, basta entrar no diretorio base da aplicação e rodar o comando a seguir 
    
    ``` 
        docker compose up --build
    ```

- ### *Sem utilizar docker*
  - ***Necessario instalar***
    - PHP 8.2 ou maior
    - Composer
    - PostgreSql  
    - Redis
  - Após instalar as ferramentas necessarias e configurar o arquivo .env, rodar os seguintes codigos
    ```
        composer install              //Instalar as dependecias do framework
        php artisan key:generate      //Gerar a chave da aplicação
        php artisan migrate           //Gerar as tabelas necessarias no banco de dados
        php artisan register:words    //Registrar as palavras fornecidas pela api para popular o banco de dados
        php artisan scribe:generate   //Gerar a documentação das rotas
        php artisan serve             //Rodar a aplicação
    ```
   
<hr>  

### Processos 

- **Request Time**
    - Para Realizar a captura do tempo da requisição, optei por criar um middleware globlal, que monitora o inicio e fim da requisição, e registra esse intervalo no header da respota
- **Autenticação**
  - Foi utilizado o Laravel Sanctum para realizar a geração e validação do token
- **Paginação**
  - Foi utilizado um helper proprio do laravel para paginar com cursores
- **Retornos**
  - Os retornos de erros foram centralizado na classe GeneralExceptionJson para deixa-los padronizados
