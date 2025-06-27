const express = require('express');
const router = express.Router();
const keuanganController = require('../controllers/keuanganController');
const verifyToken = require('../middleware/verifyToken');

router.get('/payments', verifyToken, keuanganController.getAllPayments);
router.post('/payments/:id/verify', verifyToken, keuanganController.verifyPayment);
router.post('/payments/:id/reject', verifyToken, keuanganController.rejectPayment);

module.exports = router;
// This code defines the routes for handling financial transactions related to event registrations.