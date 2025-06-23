const express = require('express');
const router = express.Router();
const eventController = require('../controllers/eventController');
const upload = require('../config/multerConfig');  // Mengimpor konfigurasi multer

// Route untuk mendapatkan semua event
router.get('/', eventController.getEvents);

// Route untuk mendapatkan event berdasarkan ID
router.get('/:id', eventController.getEventById);

// Route untuk update event dengan method PUT (misalnya lewat Postman atau frontend JS)
router.put('/:id', upload.single('poster_url'), eventController.updateEvent);

// Route tambahan untuk method spoofing dari Laravel (POST + _method=PUT)
router.post('/:id', upload.single('poster_url'), eventController.updateEvent);

// Route untuk menghapus event
router.delete('/:id', eventController.deleteEvent);

// Rute untuk membuat event dengan gambar
router.post('/create', upload.single('poster_url'), eventController.createEvent);



module.exports = router;
