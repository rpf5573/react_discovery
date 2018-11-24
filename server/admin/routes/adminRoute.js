const path = require('path');

module.exports = (app, config, DCQuery, upload) => {

  app.get('/admin', (req, res) => {
    let admin_path = path.resolve(config.CLIENT_ADMIN_DIR, 'build', 'index.html');
    res.sendFile(admin_path);
  });

  app.get('/admin/state', async (req, res) => {
    // var result = await mysql.query("SELECT * FROM dc_meta");
    var team_passwords = await DCQuery.teamPasswords.getAll();
    if ( team_passwords.err ) {
      return res.send(err);
    }
    return res.json({
      team_passwords: team_passwords
    });
  });

  app.post('/admin', (req, res) => {
    res.status(200).json({
      message: 'Yes it works !'
    });
  });

  app.post('/admin/post/team_passwords', async (req, res) => {
    let teamPasswords = req.body.team_passwords;
    if ( teamPasswords.length > 0 ) {
      let result = await DCQuery.teamPasswords.update(teamPasswords);
      console.log( 'result : ', result );
      res.sendStatus(201);
      return;
    }
    
    res.sendStatus(401);
    return;
  });

  app.post('/admin/upload', async (req, res) => {
    upload(req, res, (err) => {
      if ( err ) {
        res.status(401).send(err);
      } else {
        if ( req.files == undefined ) {
          res.send(402).send('no file');
        } else {
          console.log( 'req.files.companyImage : ', req.files.companyImage );
          if ( req.files.companyImage !== undefined ) {
            DCQuery.meta.update('company_image', req.files.companyImage[0].originalname);
          }
          res.sendStatus(201);
        }
      }
    });
  });

}