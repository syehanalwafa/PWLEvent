// routes/adminRoutes.js
const express = require('express');
const router = express.Router();
const adminController = require('../controllers/adminController');

// Route untuk mendapatkan semua pengguna
router.get('/users', adminController.getUsers);

// Route untuk menampilkan halaman form pembuatan pengguna (GET method)
router.get('/users/create', (req, res) => {
    res.render('administrator.create');  // Ganti 'administrator.create' dengan path template yang sesuai
});

// Route untuk menambahkan pengguna (POST method)
router.post('/users', adminController.addUser);

// Route untuk memperbarui pengguna berdasarkan ID
router.put('/users/:id', adminController.updateUser);

// Route untuk mendapatkan data pengguna berdasarkan ID
router.get('/users/:id', adminController.getUserById);  // Menampilkan data pengguna yang akan diubah


// Route untuk menghapus pengguna berdasarkan ID
router.delete('/users/:id', adminController.deleteUser);

// Route untuk menonaktifkan pengguna berdasarkan ID
router.post('/users/:id/deactivate', adminController.deactivateUser);

// Rute untuk mengaktifkan pengguna kembali
router.post('/users/:id/activate', adminController.activateUser);

module.exports = router;
