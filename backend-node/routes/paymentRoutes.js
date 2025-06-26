const express = require('express');
const router = express.Router();
const eventController = require('../controllers/eventController');
const multer = require('multer');

// Konfigurasi multer untuk upload bukti bayar
const storage = multer.diskStorage({
  destination: (req, file, cb) => cb(null, 'uploads/'),
  filename: (req, file, cb) => cb(null, Date.now() + '-' + file.originalname)
});
const upload = multer({ storage });

router.post('/register/:event_id', eventController.registerEvent); // Member registrasi
router.post('/upload/:registration_id', upload.single('proof'), eventController.uploadPaymentProof); // Bukti pembayaran
router.put('/verify/:id', eventController.verifyPayment); // Tim keuangan verifikasi
router.post('/attend', eventController.attendEvent); // Panitia scan QR

module.exports = router;
