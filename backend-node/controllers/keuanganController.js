const KeuanganModel = require('../models/KeuanganModel');

const getAllPayments = (req, res) => {
  KeuanganModel.getAllPayments((err, results) => {
    if (err) return res.status(500).json({ message: 'Gagal mengambil data pembayaran' });
    res.status(200).json({ payments: results });
  });
};

const verifyPayment = (req, res) => {
  const { id } = req.params;
  KeuanganModel.verifyPayment(id, (err, result) => {
    if (err) return res.status(500).json({ message: 'Gagal memverifikasi pembayaran' });
    res.status(200).json({ message: 'Pembayaran diverifikasi' });
  });
};

const rejectPayment = (req, res) => {
  const { id } = req.params;
  KeuanganModel.rejectPayment(id, (err, result) => {
    if (err) return res.status(500).json({ message: 'Gagal menolak pembayaran' });
    res.status(200).json({ message: 'Pembayaran ditolak' });
  });
};

module.exports = {
  getAllPayments,
  verifyPayment,
  rejectPayment
};