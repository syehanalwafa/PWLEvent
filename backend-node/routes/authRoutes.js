const express = require('express');
const router = express.Router();
const authController = require('../controllers/authController');

router.post('/login', authController.login);

router.post('/register', authController.register);

router.post('/logout', (req, res) => {
    res.clearCookie('token'); // Menghapus token yang ada di cookie
    res.redirect('/login'); // Redirect ke halaman login setelah logout
});

module.exports = router;
