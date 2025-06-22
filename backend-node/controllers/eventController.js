const pool = require('../config/db');
const multer = require('multer');
const path = require('path');

// Menangani penyimpanan file menggunakan multer
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'uploads/');  // Menyimpan file di folder 'uploads'
    },
    filename: (req, file, cb) => {
        const fileExtension = path.extname(file.originalname); // Ekstensi file
        const filename = Date.now() + fileExtension; // Nama file unik berdasarkan timestamp
        cb(null, filename);  // Menyimpan file dengan nama unik
    }
});

const upload = multer({ storage }).single('poster_url');  // Menangani file upload satu gambar

// Fungsi untuk membuat event
exports.createEvent = async (req, res) => {
    upload(req, res, async (err) => {
        if (err) {
            return res.status(500).json({ message: 'Failed to upload poster', error: err.message });
        }

        const { name, date, time, location, speaker, registration_fee, max_participants } = req.body;
        const poster_url = req.file ? req.file.filename : null; // Jika ada gambar, simpan nama file gambar
        const created_by = req.user ? req.user.id : null; // Menyimpan ID pengguna yang sedang login

        try {
            const [result] = await pool.query(
                'INSERT INTO events (name, date, time, location, speaker, registration_fee, max_participants, created_at, updated_at, poster_url, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?)',
                [name, date, time, location, speaker, registration_fee, max_participants, poster_url, created_by]
            );

            // Debugging: log jika insert sukses
            console.log('Event created with ID:', result.insertId);

            // Redirect ke halaman dashboard setelah event berhasil ditambahkan
            return res.redirect('/panitia-kegiatan/events');  // Pastikan ini mengarah ke URL yang benar
        } catch (err) {
            // Menangani error dengan benar
            console.error('Error inserting event:', err);
            return res.status(500).json({ message: 'Failed to create event', error: err.message });
        }
    });
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
    const [result] = await pool.query('UPDATE events SET name = ?, date = ?, time = ?, location = ?, speaker = ?, registration_fee = ?, updated_at = NOW(), max_participants = ? WHERE event_id = ?', [
      name, date, time, location, speaker, registration_fee, max_participants, id
    ]);
    if (result.affectedRows === 0) {
      return res.status(404).json({ message: 'Event not found' });
    }
    res.json({ message: 'Event updated successfully' });
  } catch (err) {
    res.status(500).json({ message: 'Failed to update event', error: err.message });
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
