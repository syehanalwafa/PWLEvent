const pool = require('../config/db');
const multer = require('multer');
const path = require('path');
const QRCode = require('qrcode');

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

// Fungsi untuk registrasi event + generate QR
exports.registerEvent = async (req, res) => {
  const id = req.user.id; // id user dari token JWT
  const eventId = req.params.event_id;

  try {
    const qrText = `${eventId}-${id}-${Date.now()}`;
    const qrCode = await QRCode.toDataURL(qrText);

    await pool.query(
      'INSERT INTO event_registrations (id, event_id, qr_code) VALUES (?, ?, ?)',
      [id, eventId, qrCode]
    );

    res.status(201).json({ message: 'Registrasi berhasil', qr_code: qrCode });
  } catch (err) {
    res.status(500).json({ error: 'Registrasi gagal', details: err.message });
  }
};

// Fungsi untuk upload bukti pembayaran
exports.uploadPaymentProof = async (req, res) => {
  const { registration_id } = req.params;
  const filePath = `/uploads/${req.file.filename}`;

  try {
    await pool.query(
      'UPDATE event_registrations SET payment_proof = ?, updated_at = NOW() WHERE registration_id = ?',
      [filePath, registration_id]
    );
    res.json({ message: 'Bukti pembayaran diunggah', file: filePath });
  } catch (err) {
    res.status(500).json({ error: 'Upload gagal', details: err.message });
  }
};

// Fungsi untuk verifikasi pembayaran
exports.verifyPayment = async (req, res) => {
  const { id } = req.params;
  const { status } = req.body;

  try {
    await pool.query(
      'UPDATE event_registrations SET payment_status = ?, updated_at = NOW() WHERE registration_id = ?',
      [status, id]
    );
    res.json({ message: 'Status diperbarui' });
  } catch (err) {
    res.status(500).json({ error: 'Verifikasi gagal', details: err.message });
  }
};

// Fungsi untuk check-in kehadiran
exports.attendEvent = async (req, res) => {
  const { registration_id, scanned_by } = req.body;

  try {
    await pool.query(
      'INSERT INTO attendances (registration_id, scanned_by) VALUES (?, ?)',
      [registration_id, scanned_by]
    );
    res.json({ message: 'Check-in berhasil' });
  } catch (err) {
    res.status(500).json({ error: 'Check-in gagal', details: err.message });
  }
};
