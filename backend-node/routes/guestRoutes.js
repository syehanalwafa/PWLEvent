const express = require('express');
const router  = express.Router();
const guest   = require('../controllers/guestController');

router.get('/events', guest.getActiveEvents);
router.post('/register', guest.registerMember);

module.exports = router;
