# 🌐 API Documentation

## 🛠️ Base URL
```
http://localhost:8000/api
```

---

## 📋 Endpoints

### 1️⃣ List Users
🔗 **URL:** `/users`  
📤 **Method:** `GET`  
📝 **Description:** Retrieves a list of all users.  

**✅ Response Example:**
```json
[
  {
    "id": 1,
    "name": "César Sá",
    "email": "cesarsa@gmail.com",
    "created_at": "2025-01-01T12:00:00Z",
    "updated_at": "2025-01-10T12:00:00Z"
  },
  {
    "id": 2,
    "name": "Rúben Benedito",
    "email": "rubenbenedito@gmail.com",
    "created_at": "2025-01-05T15:00:00Z",
    "updated_at": "2025-01-12T15:00:00Z"
  }
]


⚠️ Possible Errors:
Error (500 Internal Server Error):
{
  "error": "An unexpected error occurred"
}

```

---

### 2️⃣ Get User Details
🔗 **URL:** `/users/{user}`  
📤 **Method:** `GET`  
📝 **Description:** Retrieves the details of a specific user by their ID.  

**🔢 Path Parameters:**
- `user` (integer): The ID of the user.

**✅ Response Example:**
```json
{
  "id": 1,
  "name": "César Sá",
  "email": "cesarsa@gmail.com",
  "created_at": "2025-01-01T12:00:00Z",
  "updated_at": "2025-01-10T12:00:00Z"
}


⚠️ Possible Errors:
Error (404 Not Found):
{
  "error": "User not found"
}

Error (500 Internal Server Error):
{
  "error": "An unexpected error occurred"
}


```

---

### 3️⃣ Create a New User
🔗 **URL:** `/users`  
📤 **Method:** `POST`  
📝 **Description:** Creates a new user.  

**📥 Request Body Example:**
```json
{
  "name": "César Sá",
  "email": "cesarsa@gmail.com",
  "password": "password123"
}
```

**✅ Response Example:**
```json
{
  "id": 3,
  "name": "César Sá",
  "email": "cesarsa@gmail.com",
  "created_at": "2025-01-15T14:00:00Z",
  "updated_at": "2025-01-15T14:00:00Z"
}

⚠️ Possible Errors:
Error (400 Bad Request):
{
  "error": "Invalid email address"
}

Error (500 Internal Server Error):
{
  "error": "An unexpected error occurred"
}
```

---

### 4️⃣ Update a User
🔗 **URL:** `/users/{user}`  
📤 **Method:** `PUT`  
📝 **Description:** Updates the details of an existing user.  

**🔢 Path Parameters:**
- `user` (integer): The ID of the user.

**📥 Request Body Example:**
```json
{
  "name": "César Ribeiro Sá",
  "email": "cesarribeirosa@gmail.com"
}
```

**✅ Response Example:**
```json
{
  "id": 1,
  "name": "César Ribeiro Sá",
  "email": "cesarribeirosa@gmail.com",
  "created_at": "2025-01-01T12:00:00Z",
  "updated_at": "2025-01-15T16:00:00Z"
}


⚠️ Possible Errors:

Error (400 Bad Request):
{
  "error": "Invalid data"
}

Error (404 Not Found):
{
  "error": "User not found"
}

Error (500 Internal Server Error):
{
  "error": "An unexpected error occurred"
}

```

---

### 5️⃣ Delete a User
🔗 **URL:** `/users/{user}`  
📤 **Method:** `DELETE`  
📝 **Description:** Deletes an existing user by their ID.  

**🔢 Path Parameters:**
- `user` (integer): The ID of the user.

**✅ Response Example:**
```json
{
  "message": "User deleted successfully."
}


⚠️ Possible Errors:

Error (404 Not Found):
{
  "error": "User not found"
}

Error (500 Internal Server Error):
{
  "error": "An unexpected error occurred"
}
