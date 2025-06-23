const multer = require('multer');
const path = require('path');

// Menyimpan file di folder 'uploads/'
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'uploads/');  // Menyimpan file di folder 'uploads'
    },
    filename: (req, file, cb) => {
        const fileExtension = path.extname(file.originalname);
        const filename = Date.now() + fileExtension;
        cb(null, filename);  // Menyimpan file dengan nama unik
    }
});

const upload = multer({ 
    storage,
    fileFilter: (req, file, cb) => {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        const fileExtension = path.extname(file.originalname).toLowerCase();  // Dapatkan ekstensi file
        if (allowedTypes.includes(file.mimetype) && ['.jpg', '.jpeg', '.png', '.gif'].includes(fileExtension)) {
            cb(null, true);
        } else {
            cb(new Error('Only image files are allowed'), false);
        }
    },
    limits: { fileSize: 5 * 1024 * 1024 }  // Maksimal 5MB
});

module.exports = upload;
