const express = require('express');
const Order = require('../models/Order');
const Sale = require('../models/Sale');
const auth = require('../middleware/auth');
const router = express.Router();

// Route pour récupérer les commandes avec le statut "VALIDÉ"
router.get('/', auth, async (req, res) => {
  try {
    const orders = await Order.find({ status: 'VALIDÉ' });
    res.json(orders);
  } catch (error) {
    res.status(400).json({ message: error.message });
  }
});

// Route pour mettre à jour le statut des commandes de "VALIDÉ" à "LIVRÉ"
router.put('/:id', auth, async (req, res) => {
  try {
    if (req.user.role !== 'employee') {
      return res.status(403).json({ message: 'Access denied' });
    }
    const order = await Order.findById(req.params.id);
    if (!order) {
      return res.status(404).json({ message: 'Order not found' });
    }
    if (order.status === 'LIVRÉ') {
      return res.status(400).json({ message: 'Order is already delivered' });
    }
    order.status = 'LIVRÉ';
    await order.save();

    // Incrémenter les ventes pour chaque article
    for (const item of order.items) {
      const sale = new Sale({
        itemName: item.name,
        price: item.price,
        date: new Date()
      });
      await sale.save();
    }

    res.json({ message: 'Order status updated to LIVRÉ' });
  } catch (error) {
    res.status(400).json({ message: error.message });
  }
});

module.exports = router;
