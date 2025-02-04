# Gestão de Estágios

<p align="center">
  <img src="public/images/white_icon.png"  height="200">
</p>

This project aims to create a platform to simplify the process of assigning, monitoring, and evaluating internships, allowing for easy and efficient interaction between students, coordinators, companies, and internship supervisors. The platform will be designed to ensure transparency, automation, and security in processes related to internships, minimizing the use of paper documents and facilitating real-time access to information.

## 🗃️ Requirements

Before running the project, please ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [GitHub](https://docs.github.com/en/desktop/installing-and-authenticating-to-github-desktop/installing-github-desktop)

## ➡️ Installation

Follow the steps below to clone the repository and install dependencies:

```bash
# Clone the repository
git clone https://github.com/cesar-daniel15/gestao-estagios

# Navigate to the project folder
cd gestao-estagios

```

## 🛠️ Environment Configuration
Create a .env file in the root of the project with the following content:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=gestao-estagios
DB_USERNAME=admin
DB_PASSWORD=root
```

## 🐳 Create Container
To start the container, execute one of the following commands:

```bash
docker up --build
```
### Or

```bash
docker pull cesardaniel15/gestao-estagios
```

### Docker Image Link

You can access the Docker image through the following link:


https://hub.docker.com/repository/docker/cesardaniel15/gestao-estagios/general

## 🔑 API

To view the API documentation, click the link below:


[API Documentation](Api.md)


## 📦 DataBase (PHP My Admin)

http://127.0.0.1:8080/