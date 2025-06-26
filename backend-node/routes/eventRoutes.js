const express = require('express');
const router = express.Router();
const eventController = require('../controllers/eventController');
const upload = require('../config/multerConfig'); // ✅ Sudah cukup
const { authenticateToken } = require('../middleware/auth'); // Middleware auth

// Route untuk mendapatkan semua event
router.get('/', eventController.getEvents);

// Route untuk mendapatkan event berdasarkan ID
router.get('/:id', eventController.getEventById);

// Update event
router.put('/:id', upload.single('poster_url'), eventController.updateEvent);

// Create event
router.post('/create', authenticateToken, upload.single('poster_url'), eventController.createEvent);

// Method spoofing (Laravel form)
router.post('/:id', upload.single('poster_url'), eventController.updateEvent);

// Hapus event
router.delete('/:id', eventController.deleteEvent);

// Upload bukti pembayaran
router.post('/payment-proof/:registration_id', upload.single('proof'), eventController.uploadPaymentProof);

// Verifikasi pembayaran
router.put('/payment-verification/:id', eventController.verifyPayment);

// Kehadiran
router.post('/attend', eventController.attendEvent);

// Registrasi event
router.post('/:event_id/register', eventController.registerEvent);

module.exports = router;
