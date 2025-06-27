const pool = require('../config/db');
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');

// Fungsi login
exports.login = async (req, res) => {
  const { email, password } = req.body;

  try {
    const [rows] = await pool.query('SELECT * FROM users WHERE email = ?', [email]);
    if (!rows.length) return res.status(401).json({ message: 'Email tidak ditemukan' });

    const user = rows[0];
    const valid = await bcrypt.compare(password, user.password);
    if (!valid) return res.status(401).json({ message: 'Password salah' });

    const token = jwt.sign({ id: user.id, role: user.role }, process.env.JWT_SECRET, {
      expiresIn: '1h'
    });

    // Tentukan URL pengalihan berdasarkan role
    let redirectUrl;
    switch(user.role) {
      case 'Administrator':
        redirectUrl = '/admin';
        break;
      case 'Member':
        redirectUrl = '/member';
        break;
      case 'Tim Keuangan':
        redirectUrl = '/tim-keuangan';
        break;
      case 'panitia pelaksana kegiatan':
        redirectUrl = '/panitia-kegiatan';
        break;
      default:
        redirectUrl = '/login';  // fallback ke halaman login
    }

    // ✅ Tambahkan 'id' ke dalam response agar Laravel tidak error
    res.json({ 
      token,
      id: user.id, // ⬅️ Ini yang paling penting
      role: user.role,
      name: user.name,
      email: user.email,
      redirectUrl
    });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};

// Fungsi registrasi
exports.register = async (req, res) => {
  const { name, email, password } = req.body;

  // Validasi input
  if (!name || !email || !password) {
    return res.status(400).json({ message: 'Semua field wajib diisi' });
  }

  try {
    console.log('Received registration data:', { name, email, password });

    const [existingUser] = await pool.query('SELECT * FROM users WHERE email = ?', [email]);
    if (existingUser.length > 0) {
      return res.status(400).json({ message: 'Email sudah digunakan' });
    }

    const hashedPassword = await bcrypt.hash(password, 10);

    console.log('Inserting user data into DB:', { name, email, hashedPassword });

    const [result] = await pool.query(
      'INSERT INTO users (name, email, password, role, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())',
      [name, email, hashedPassword, 'Member', 'ACTIVE']
    );

    console.log('Insert result:', result);

    const token = jwt.sign({ id: result.insertId, role: 'Member' }, process.env.JWT_SECRET, {
      expiresIn: '1h'
    });

    res.status(201).json({
      token,
      id: result.insertId, // ⬅️ Pastikan ini tetap ada
      role: 'Member',
      name
    });
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
  }
};
