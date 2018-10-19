const path = require('path');
const config = require('./config.js');

// express
const express = require('express');
const app = express();
const bodyParser = require('body-parser');
app.use(bodyParser.json());

// admin route
app.use(express.static('client'));
require('./server/admin/routes/adminRoute')(app, config);

// user route
const PORT = process.env.PORT || 8080;
app.listen(PORT);