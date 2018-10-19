var path = require('path');
var appDir = path.dirname(require.main.filename);

module.exports = {
  ROOT_DIR: appDir,
  CLIENT_ADMIN_DIR: appDir + '/client/admin',
  CLIENT_USER_DIR: appDir + '/client/user'
};