# Gestão de Estágios

<p align="center">
  <img src="public/images/white_icon.png"  height="200">
</p>


Este projeto, tem como principal objetivo criar uma plataforma com a finalidade de simplificar 
o processo de atribuição, acompanhamento e avaliação de estágios, permitindo uma 
interação fácil e eficiente entre alunos, coordenadores, empresas e responsáveis de estágio.  
A plataforma será concebida com o foco em garantir a transparência, automação e segurança 
dos processos relacionados com os estágios, minimizando o uso de documentos em papel e 
facilitando o acesso à informação em tempo real.

## Requisitos

Antes de executar o projeto, verifique se você possui os seguintes requisitos instalados:

- [Docker](https://www.docker.com/get-started)
- [GitHub](https://docs.github.com/en/desktop/installing-and-authenticating-to-github-desktop/installing-github-desktop)

## Instalação

Siga os passos abaixo para clonar o repositório e instalar as dependências:

```bash
# Clone o repositório
git clone https://github.com/cesar-daniel15/gestao-estagios

# Navegue até a pasta do projeto
cd gestao-estagios

```


##  Configuração do Ambiente
Crie um ficheiro .env na raiz do projeto:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=gestao-estagios
DB_USERNAME=admin
DB_PASSWORD=root
```

## Criar Container
Para iniciar o contêiner, execute um dos seguintes comandos:


```bash
docker up --build
```
### Ou


```bash
docker pull cesardaniel15/gestao-estagios
```

### Link da imagem do dokcer

https://hub.docker.com/repository/docker/cesardaniel15/gestao-estagios/general

## API

Para visualizar a documentação da API, clique no link abaixo:

[Documentação da API](API.md)


