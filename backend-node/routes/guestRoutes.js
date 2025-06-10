const express = require('express');
const router = express.Router();
const guestController = require('../controllers/guestController');

router.post('/login', guestController.login);

module.exports = router;
