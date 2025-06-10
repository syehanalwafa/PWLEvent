const express = require('express');
const cors    = require('cors');
require('dotenv').config();

const app = express();
app.use(cors());
app.use(express.json());

app.use('/api', require('./routes/guestRoutes'));

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => console.log(` Backend on port ${PORT}`));
