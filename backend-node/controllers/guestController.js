const pool = require('../config/db');
const bcrypt = require('bcryptjs');

// GET /api/events  – ambil event aktif
exports.getActiveEvents = async (_req, res) => {
  try {
    const [rows] = await pool.query(
      `SELECT event_id, name, date, time, location, speaker,
              poster_url, registration_fee, max_participants
       FROM events
       WHERE is_active = 1
       ORDER BY date, time`
    );
    res.json(rows);
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};

// POST /api/register – guest → member
exports.registerMember = async (req, res) => {
  const { name, email, password } = req.body;
  if (!name || !email || !password)
    return res.status(400).json({ message: 'Nama, email, dan password wajib diisi' });

  try {
    // cek email unik
    const [exist] = await pool.query('SELECT 1 FROM users WHERE email = ?', [email]);
    if (exist.length)
      return res.status(409).json({ message: 'Email sudah terdaftar' });

    const hash = await bcrypt.hash(password, 10);

    const [result] = await pool.query(
      `INSERT INTO users (name, email, password, role, status)
       VALUES (?,?,?,?,?)`,
      [name, email, hash, 'Member', 'ACTIVE']
    );

    res.status(201).json({
      message: 'Registrasi berhasil',
      user_id: result.insertId
    });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};
