const path = require('path');
const config = require('./config.js');
const multer = require('multer');

// express
const express = require('express');
const app = express();
const cors = require('cors');
const bodyParser = require('body-parser');
app.use(bodyParser.json());
app.use(cors());
app.use(express.static('client'));

// mysql
const pool = require('./database');

// admin
require('./server/admin/init')(app, config, path, multer, pool);

// user route
const PORT = process.env.PORT || 8080;
app.listen(PORT);