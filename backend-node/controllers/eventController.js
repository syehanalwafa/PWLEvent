const db = require('../config/db');

exports.getAllEvents = (req, res) => {
  db.query('SELECT * FROM event', (err, results) => {
    if (err) return res.status(500).json({ error: err });
    res.json(results);
  });
};
