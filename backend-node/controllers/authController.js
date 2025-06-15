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

    const token = jwt.sign({ user_id: user.user_id, role: user.role }, process.env.JWT_SECRET, {
      expiresIn: '1h'
    });

     // Debugging data user yang ditemukan
    console.log(user);  // Debug output user
    console.log("Returned data:", {
      name: user.name,
      role: user.role,
      token: token
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
            case 'Tim Panitia Kegiatan':
                redirectUrl = '/panitia-kegiatan';
                break;
            default:
                redirectUrl = '/login';  // fallback ke halaman login
        }

    res.json({ 
      token, 
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
    // Log data yang diterima
    console.log('Received registration data:', { name, email, password });

    // Cek jika email sudah terdaftar
    const [existingUser] = await pool.query('SELECT * FROM users WHERE email = ?', [email]);
    if (existingUser.length > 0) {
      return res.status(400).json({ message: 'Email sudah digunakan' });
    }

    // Hash password dengan bcrypt
    const hashedPassword = await bcrypt.hash(password, 10);

    // Log data yang akan disimpan
    console.log('Inserting user data into DB:', { name, email, hashedPassword });


    // Simpan pengguna baru ke dalam database dengan role 'Member' secara otomatis
    const [result] = await pool.query('INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)', [
      name,
      email,
      hashedPassword,
      'Member', // Set role ke Member secara default
      'ACTIVE'  // Status aktif
    ]);

    
    // Log hasil query
    console.log('Insert result:', result);


    // Generate token JWT
    const token = jwt.sign({ user_id: result.insertId, role: 'Member' }, process.env.JWT_SECRET, { expiresIn: '1h' });

    // Kirim response dengan token dan data pengguna
    res.status(201).json({
      token,
      role: 'Member', // Role yang dikembalikan adalah 'Member'
      name
    });
  } catch (err) {
    console.error(err);
    res.status(500).json({ message: 'Terjadi kesalahan pada server' });
  }
};