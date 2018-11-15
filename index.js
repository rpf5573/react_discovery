const path = require('path');
const config = require('./config.js');

// express
const express = require('express');
const app = express();
const cors = require('cors');
const bodyParser = require('body-parser');
app.use(bodyParser.json());
app.use(cors());

// mysql
const mysql = require('mysql');
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'root',
  database: 'discovery'
});
connection.connect(err => {
  if ( err ) {
    console.log( 'err : ', err );
    return err;
  }
});

// admin route
app.use(express.static('client'));
require('./server/admin/routes/adminRoute')(app, config, connection);

// user route
const PORT = process.env.PORT || 8080;
app.listen(PORT);