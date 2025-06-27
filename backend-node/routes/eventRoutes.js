const express = require('express');
const router = express.Router();
const eventController = require('../controllers/eventController');
const upload = require('../config/multerConfig');
const { authenticateToken } = require('../middleware/auth');

// Public
router.get('/', eventController.getEvents);

// Detail event (hanya bisa diakses user login)
router.get('/:id', authenticateToken, eventController.getEventById);

// Create event (panitia)
router.post('/create', authenticateToken, upload.single('poster_url'), eventController.createEvent);

// Update event (panitia)
router.put('/:id', upload.single('poster_url'), eventController.updateEvent);

// Laravel method spoofing
router.post('/:id', upload.single('poster_url'), eventController.updateEvent);

// Delete event (panitia)
router.delete('/:id', eventController.deleteEvent);

// Registrasi event (member)
router.post('/:event_id/register', authenticateToken, eventController.registerEvent);

// Upload bukti pembayaran
router.post('/payment-proof/:registration_id', upload.single('proof'), eventController.uploadPaymentProof);

// Verifikasi pembayaran (admin atau tim keuangan)
router.put('/payment-verification/:id', eventController.verifyPayment);

// Check-in peserta (panitia)
router.post('/attend', eventController.attendEvent);

module.exports = router;
