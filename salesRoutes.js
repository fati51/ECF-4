const express = require('express');
const Sale = require('../models/Sale');
const auth = require('../middleware/auth');
const router = express.Router();

// Route pour récupérer les ventes
router.get('/', auth, async (req, res) => {
  try {
    const sales = await Sale.find();
    res.json(sales);
  } catch (error) {
    res.status(400).json({ message: error.message });
  }
});

module.exports = router;
