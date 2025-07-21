# 📘 Simple PHP CRUD Application

This is a **basic PHP CRUD** (Create, Read, Update, Delete) application for managing student data using **MySQLi**.

---

## 🧰 Tech Stack

- PHP (Procedural + OOP)  
- MySQL / MariaDB  
- HTML & Minimal CSS  
- phpMyAdmin (for DB setup)

---

## 📂 Features

✅ Add new student record  
✅ Edit student data  
✅ Delete student record  
✅ View all records in a table  
✅ Simple alert-based feedback

---

## 📁 Folder Structure

```
php-crud-app/
│
├── index.php        → Main PHP CRUD logic  
├── data.sql         → MySQL dump file  
└── README.md        → You’re here!
```

---

## 🏁 Getting Started

### 📌 1. Clone the Repository

```bash
git clone https://github.com/your-username/php-crud-app.git
cd php-crud-app
```

### 🛠️ 2. Import the Database

1. Open **phpMyAdmin**  
2. Create a database named: `db_crud_example`  
3. Import the `data.sql` file

### 🧪 3. Run Locally

If you're using **XAMPP**, place the folder inside:

```
C:\xampp\htdocs\
```

Then open your browser and go to:

```
http://localhost/php-crud-app/index.php
```

---

## 🧾 Sample Table Structure (`emp`)

| Column         | Type         |
|----------------|--------------|
| `nim`          | INT(12)      |
| `nama_lengkap` | VARCHAR(150) |
| `alamat`       | TEXT         |
| `jurusan`      | VARCHAR(150) |

---

## 👨‍💻 Author

**Suthapalli Yaswanth Srinivas**  
🔗 [GitHub Profile](https://github.com/suthapalliyaswanth)

---

## 📜 License

This project is open-source and free to use.
