    const express = require('express');
    const cors = require('cors');
    require('dotenv').config();

    const app = express();

    // Konfigurasi CORS yang lebih spesifik (contoh)
    const corsOptions = {
      origin: 'http://localhost:8000', // Ganti dengan URL aplikasi Laravel Anda
      optionsSuccessStatus: 200 // beberapa browser lama membutuhkan ini
    }

    app.use(cors(corsOptions)); // Gunakan opsi CORS
    app.use(express.json());

    app.use('/api', require('./routes/guestRoutes'));
    app.use('/api/auth', require('./routes/authRoutes'));


    const PORT = process.env.PORT || 5000;
    app.listen(PORT, () => console.log(`Backend on port ${PORT}`));
    