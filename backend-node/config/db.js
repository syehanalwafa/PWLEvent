// db.js
const mysql = require('mysql2');
require('dotenv').config();

const pool = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT,
});

const db = pool.promise(); // langsung bisa pakai async/await

// Tes koneksi
db.getConnection()
  .then(connection => {
    console.log('Database connection successful');
    connection.release(); // Melepaskan koneksi
  })
  .catch(err => {
    console.error('Database connection failed:', err);
  }); 

module.exports = db;
