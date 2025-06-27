const jwt = require('jsonwebtoken');

const verifyToken = (req, res, next) => {
    const authHeader = req.headers['authorization'];

    if (!authHeader) {
        return res.status(401).json({ message: 'Token tidak ditemukan di header' });
    }

    const token = authHeader.split(' ')[1]; // Format: "Bearer <token>"

    if (!token) {
        return res.status(403).json({ message: 'Token tidak valid' });
    }

    try {
        const decoded = jwt.verify(token, process.env.JWT_SECRET); // Sesuaikan dengan key rahasia
        req.user = decoded; // user info sekarang ada di req.user
        next(); // lanjut ke controller
    } catch (err) {
        return res.status(403).json({ message: 'Token tidak valid atau sudah kedaluwarsa' });
    }
};

module.exports = verifyToken;