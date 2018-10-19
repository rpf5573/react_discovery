const path = require('path');

module.exports = (app, config) => {
  app.get('/admin', (req, res) => {
    res.sendFile(path.resolve(config.CLIENT_ADMIN_DIR, 'build', 'index.html'));
  });
}