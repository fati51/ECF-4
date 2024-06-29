const mongoose = require('mongoose');

const orderSchema = new mongoose.Schema({
  customerName: { type: String, required: true },
  status: { type: String, enum: ['VALIDÉ', 'LIVRÉ'], default: 'VALIDÉ' },
  items: [{ name: String, price: Number, quantity: Number }],
  createdAt: { type: Date, default: Date.now }
});

module.exports = mongoose.model('Order', orderSchema);
