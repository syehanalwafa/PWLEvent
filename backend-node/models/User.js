const db = require('../config/db'); // Menggunakan pool dari db.js

// Mendefinisikan fungsi getAllUsers
const getAllUsers = async () => {
  try {
    const [rows] = await db.execute('SELECT * FROM users'); // Mengambil semua data pengguna
    return rows;
  } catch (error) {
    console.error('Error fetching users:', error);
    throw error;
  }
};

// Mendefinisikan fungsi lainnya (getUserById, addUser, dll.)
const getUserById = async (id) => {
  try {
    const [rows] = await db.execute('SELECT * FROM users WHERE id = ?', [id]);
    return rows[0];  // Mengembalikan pengguna pertama jika ditemukan
  } catch (error) {
    console.error('Error fetching user:', error);
    throw error;
  }
};

// Fungsi untuk menambahkan pengguna baru
const addUser = async (name, email, hashedPassword, role, status) => {
  try {
    const result = await db.execute(
      'INSERT INTO users (name, email, password, role, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())',
      [name, email, hashedPassword, role, status]
    );
    return result[0]; // Mengembalikan pengguna yang baru ditambahkan
  } catch (error) {
    console.error('Error adding user:', error);
    throw error;
  }
};

const updateUser = async (id, name, email, role, status) => {
  try {
    const result = await db.execute(
      'UPDATE users SET name = ?, email = ?, role = ?, status = ?, updated_at = NOW() WHERE id = ?', 
      [name, email, role, status, id]
    );
    return result[0];  // Mengembalikan pengguna yang diperbarui
  } catch (error) {
    console.error('Error updating user:', error);
    throw error;
  }
};

const deleteUser = async (id) => {
  try {
    const result = await db.execute('DELETE FROM users WHERE id = ?', [id]);
    return result[0];  // Mengembalikan hasil penghapusan
  } catch (error) {
    console.error('Error deleting user:', error);
    throw error;
  }
};

// Fungsi untuk menonaktifkan pengguna
const deactivateUser = async (id) => {
    try {
        const result = await db.execute(
            'UPDATE users SET status = ? WHERE id = ?', 
            ['INACTIVE', id]
        );
        return result[0];  // Mengembalikan hasil operasi
    } catch (error) {
        console.error('Error deactivating user:', error);
        throw error;
    }
};

// Fungsi untuk mengaktifkan kembali pengguna
const activateUser = async (id) => {
    try {
        const result = await db.execute(
            'UPDATE users SET status = ? WHERE id = ?', 
            ['ACTIVE', id]
        );
        return result[0];  // Mengembalikan hasil operasi
    } catch (error) {
        console.error('Error activating user:', error);
        throw error;
    }
};

const getUsersByRole = async (roles) => {
  // Pastikan roles adalah array
  if (!Array.isArray(roles)) {
    roles = [roles];  // Jika hanya satu role, buat array
  }

  // Buat placeholder (?) sesuai jumlah roles yang ada
  const placeholders = roles.map(() => '?').join(', ');

  const query = `SELECT * FROM users WHERE role IN (${placeholders})`;

  console.log('Roles array:', roles);  // Debugging output

  // Eksekusi query dengan array roles yang telah diproses
  const [rows] = await db.execute(query, roles);

  return rows;
};

module.exports = { getAllUsers, getUserById, addUser, updateUser, deleteUser, deactivateUser, getUsersByRole, activateUser};
