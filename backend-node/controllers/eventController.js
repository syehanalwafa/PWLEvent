const pool = require('../config/db');
const multer = require('multer');
const path = require('path');

// Konfigurasi multer (sama seperti createEvent)
const storage = multer.diskStorage({
  destination: (req, file, cb) => cb(null, 'uploads/'),
  filename: (req, file, cb) => cb(null, Date.now() + path.extname(file.originalname))
});
const upload = multer({ storage });

// Fungsi untuk membuat event
exports.createEvent = async (req, res) => {
    try {
        console.log('Uploaded file:', req.file);  // Debugging: Pastikan file terupload
        console.log('User from token:', req.user);

        const { name, date, time, location, speaker, registration_fee, max_participants } = req.body;
        const poster_url = req.file ? req.file.filename : null; // Jika ada gambar, simpan nama file gambar
        const created_by = req.user ? req.user.user_id : null; // Menyimpan ID pengguna yang sedang login

        const [result] = await pool.query(
            'INSERT INTO events (name, date, time, location, speaker, registration_fee, max_participants, created_at, updated_at, poster_url, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?)',
            [name, date, time, location, speaker, registration_fee, max_participants, poster_url, created_by]
        );

        console.log('Event created with ID:', result.insertId);
        return res.redirect('/panitia-kegiatan/events');
    } catch (err) {
        console.error('Error inserting event:', err);
        return res.status(500).json({ message: 'Failed to create event', error: err.message });
    }
};


// Fungsi untuk mendapatkan semua event
exports.getEvents = async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM events');
    res.json(rows);  // Mengembalikan list event
  } catch (err) {
    res.status(500).json({ message: 'Failed to fetch events', error: err.message });
  }
};

// Fungsi untuk mendapatkan satu event berdasarkan ID
exports.getEventById = async (req, res) => {
  const { id } = req.params;
  try {
    const [rows] = await pool.query('SELECT * FROM events WHERE event_id = ?', [id]);
    if (rows.length === 0) {
      return res.status(404).json({ message: 'Event not found' });
    }
    res.json(rows[0]);  // Mengembalikan satu event berdasarkan ID
  } catch (err) {
    res.status(500).json({ message: 'Failed to fetch event', error: err.message });
  }
};

// Fungsi untuk memperbarui event
exports.updateEvent = async (req, res) => {
  const { id } = req.params;
  const { name, date, time, location, speaker, registration_fee, max_participants } = req.body;

  try {
    let query = `
      UPDATE events
      SET name = ?, date = ?, time = ?, location = ?, speaker = ?, registration_fee = ?, max_participants = ?, updated_at = NOW()
    `;
    const params = [name, date, time, location, speaker, registration_fee, max_participants];

    // Tambahkan poster_url jika ada file baru
    if (req.file) {
      query += ', poster_url = ?';
      params.push(req.file.filename);
    }

    query += ' WHERE event_id = ?';
    params.push(id);

    const [result] = await pool.query(query, params);

    if (result.affectedRows === 0) {
      return res.status(404).json({ message: 'Event not found' });
    }

    // ✅ Kirim JSON redirect
    return res.status(200).json({ redirectUrl: '/panitia-kegiatan/events' });

  } catch (err) {
    console.error('Error updating event:', err);
    return res.status(500).json({ message: 'Failed to update event', error: err.message });
  }
};


// Fungsi untuk menghapus event
exports.deleteEvent = async (req, res) => {
  const { id } = req.params;
  try {
    const [result] = await pool.query('DELETE FROM events WHERE event_id = ?', [id]);
    if (result.affectedRows === 0) {
      return res.status(404).json({ message: 'Event not found' });
    }
    res.json({ message: 'Event deleted successfully' });
  } catch (err) {
    res.status(500).json({ message: 'Failed to delete event', error: err.message });
  }
};
