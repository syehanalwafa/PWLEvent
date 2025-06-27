const express = require('express');
const cors = require('cors');
require('dotenv').config();
const app = express();
const methodOverride = require('method-override');
const authRoutes = require('./routes/authRoutes'); // Import file route auth
const path = require('path');

// Konfigurasi CORS yang lebih spesifik (contoh)
const corsOptions = {
  origin: ['http://localhost:8000', 'http://127.0.0.1:8000'], // Menambahkan kedua origin untuk mengatasi masalah CORS
  optionsSuccessStatus: 200, // Mendukung status preflight request
}

app.use(cors(corsOptions)); // Gunakan opsi CORS

app.use(express.json());  

app.use('/api', require('./routes/guestRoutes'));

app.use('/api/auth', require('./routes/authRoutes'));

app.use('/api/admin', require('./routes/adminRoutes')); // Menambahkan admin routes

app.use('/api/events', require('./routes/eventRoutes'));  // Menambahkan rute event

// Menyajikan file di dalam folder 'uploads' untuk dapat diakses publik
app.use('/uploads', express.static('uploads'));

app.use('/api/auth', authRoutes); // Menghubungkan route auth ke aplikasi


// Untuk mendukung override via _method field di form POST (x-www-form-urlencoded atau multipart)
app.use(methodOverride('_method'));

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(`Backend on port ${PORT}`));
    
const eventController = require('./controllers/eventController');

app.use('/api/events', require('./routes/eventRoutes'));

app.use('/api/keuangan', require('./routes/keuanganRoutes'));