const path = require('path');

module.exports = (app, config, mysql) => {

  app.get('/admin', (req, res) => {
    let admin_path = path.resolve(config.CLIENT_ADMIN_DIR, 'build', 'index.html');
    res.sendFile(admin_path);
  });

  app.get('/admin/state', (req, res) => {
    mysql.query("SELECT * FROM dc_meta", (err, results) => {
      if ( err ) {
        return res.send(err);
      }
      return res.json({
        state: results
      });
    });
  });

  app.post('/admin', (req, res) => {
    res.status(200).json({
      message: 'Yes it works !'
    });
  });

}