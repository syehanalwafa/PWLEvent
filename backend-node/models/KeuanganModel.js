const db = require('../config/db');

const KeuanganModel = {
  getAllPayments: (callback) => {
    const query = `
      SELECT 
        event_registrations.registration_id,
        users.name AS user_name,
        users.email,
        events.name AS event_name,
        events.registration_fee,
        event_registrations.payment_status,
        event_registrations.payment_proof,
        event_registrations.registered_at
      FROM event_registrations
      JOIN users ON users.id = event_registrations.id
      JOIN events ON events.event_id = event_registrations.event_id
    `;
    db.query(query, callback);
  },

  verifyPayment: (registration_id, callback) => {
    const query = `
      UPDATE event_registrations 
      SET payment_status = 'verified'
      WHERE registration_id = ?
    `;
    db.query(query, [registration_id], callback);
  },

  rejectPayment: (registration_id, callback) => {
    const query = `
      UPDATE event_registrations 
      SET payment_status = 'rejected'
      WHERE registration_id = ?
    `;
    db.query(query, [registration_id], callback);
  }
};

module.exports = KeuanganModel;