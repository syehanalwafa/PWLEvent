// controllers/adminController.js
const User = require('../models/User'); // Mengimpor model User
const bcrypt = require('bcryptjs');

// Fungsi untuk mendapatkan semua pengguna
exports.getUsers = async (req, res) => {
    try {
        const users = await User.getUsersByRole(['Tim Keuangan', 'panitia pelaksana kegiatan']);
        console.log("Users fetched:", users);  // Log users yang diterima
        res.json({ users });
    } catch (error) {
        console.error('Error fetching users:', error);
        res.status(500).json({ message: 'Gagal mengambil data pengguna' });
    }
};


// Fungsi untuk menambahkan pengguna baru
exports.addUser = async (req, res) => {
    const { name, email, password, role, status } = req.body;

    // Validasi role harus tim keuangan atau panitia pelaksana kegiatan
    if (role !== 'Tim Keuangan' && role !== 'panitia pelaksana kegiatan') {
        return res.status(400).json({ message: 'Role tidak valid' });
    }

    try {
        // Hash password
        const hashedPassword = await bcrypt.hash(password, 10); // Hash password dengan bcrypt

        // Simpan pengguna baru ke database
        const newUser = await User.addUser(name, email, hashedPassword, role, status); 
        res.status(201).json(newUser); // Return response dengan data pengguna baru
    } catch (error) {
        console.error('Error adding user:', error);
        res.status(500).json({ message: 'Gagal menambahkan pengguna' });
    }
};


// Fungsi untuk mendapatkan semua pengguna dengan role 'Tim Keuangan' dan 'Panitia Kegiatan'
exports.getUsersByRole = async (req, res) => {
    try {
        const roles = ['Tim Keuangan', 'panitia  pelaksana pegiatan'];
        const users = await User.getUsersByRole(roles);
        res.json({ users });
    } catch (error) {
        console.error('Error fetching users:', error);
        res.status(500).json({ message: 'Gagal mengambil data pengguna' });
    }
};

// Fungsi untuk mendapatkan pengguna berdasarkan ID
exports.getUserById = async (req, res) => {
    const { id } = req.params;
    try {
        const user = await User.getUserById(id);  // Mengambil data pengguna berdasarkan ID
        res.json({ user });  // Mengirimkan data pengguna
    } catch (error) {
        console.error('Error fetching user:', error);
        res.status(500).json({ message: 'Gagal mengambil data pengguna' });
    }
};


// Fungsi untuk mengupdate pengguna
exports.updateUser = async (req, res) => {
    const { id } = req.params;
    const { name, email, role, status } = req.body;

    try {
        const updatedUser = await User.updateUser(id, name, email, role, status); // Fungsi update user
        res.json(updatedUser);
    } catch (error) {
        console.error('Error updating user:', error);
        res.status(500).json({ message: 'Gagal memperbarui pengguna' });
    }
};

// Fungsi untuk menghapus pengguna
exports.deleteUser = async (req, res) => {
    const { id } = req.params;

    try {
        await User.deleteUser(id);  // Menghapus pengguna dari database
        res.status(204).send();  // Mengembalikan status 204 (No Content)
    } catch (error) {
        console.error('Error deleting user:', error);
        res.status(500).json({ message: 'Gagal menghapus pengguna' });
    }
};

// Fungsi untuk menonaktifkan pengguna
exports.deactivateUser = async (req, res) => {
    const { id } = req.params;
    try {
        const result = await User.deactivateUser(id);  // Memanggil fungsi menonaktifkan pengguna
        console.log("User status updated to INACTIVE:", result);  // Menambahkan log untuk debugging
        res.json({ message: 'Pengguna berhasil dinonaktifkan' });
    } catch (error) {
        console.error('Error deactivating user:', error);
        res.status(500).json({ message: 'Gagal menonaktifkan pengguna' });
    }
};

// Fungsi untuk mengaktifkan kembali pengguna
exports.activateUser = async (req, res) => {
    const { id } = req.params;
    try {
        const result = await User.activateUser(id); // Mengaktifkan pengguna
        res.json({ message: 'Pengguna berhasil diaktifkan kembali' });
    } catch (error) {
        console.error('Error activating user:', error);
        res.status(500).json({ message: 'Gagal mengaktifkan pengguna' });
    }
};