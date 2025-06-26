const pool = require('../config/db');

exports.register = async ({ id, event_id, qr_code }) => {
  return pool.query(
    'INSERT INTO event_registrations (id, event_id, qr_code) VALUES (?, ?, ?)',
    [id, event_id, qr_code]
  );
};

exports.updatePaymentProof = async ({ registration_id, filePath }) => {
  return pool.query(
    'UPDATE event_registrations SET payment_proof = ?, updated_at = NOW() WHERE registration_id = ?',
    [filePath, registration_id]
  );
};
exports.verifyPayment = async ({ id, status }) => {
  return pool.query(
    'UPDATE event_registrations SET payment_status = ?, updated_at = NOW() WHERE registration_id = ?',
    [status, id]
  );
};