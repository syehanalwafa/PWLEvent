const multer = require('multer');
const path = require('path');

// Set the storage destination for uploaded images
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, 'uploads/');  // Menyimpan di folder 'uploads'
    },
    filename: (req, file, cb) => {
        const fileExtension = path.extname(file.originalname); // Ekstensi file
        const filename = Date.now() + fileExtension; // Nama file unik berdasarkan timestamp
        cb(null, filename);  // Menyimpan file dengan nama unik
    }
});

// Filter untuk hanya mengizinkan jenis file tertentu
const fileFilter = (req, file, cb) => {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (allowedTypes.includes(file.mimetype)) {
        cb(null, true);  // Izinkan file jika tipe MIME cocok
    } else {
        cb(new Error('Only image files are allowed'), false);
    }
};

// Initialize multer middleware
const upload = multer({ 
    storage, 
    fileFilter, 
    limits: { fileSize: 5 * 1024 * 1024 } // Maksimal 5MB untuk setiap file
});

module.exports = upload;
