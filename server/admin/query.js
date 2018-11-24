class DCQuery {
  constructor(mysql) {
    this.mysql = mysql;
    this.tables = {
      meta: 'dc_meta',
      teamPasswords: 'dc_team_passwords'
    }
    this.meta = new Meta(this.tables.meta, this.mysql);
    this.teamPasswords = new TeamPasswords(this.tables.teamPasswords, this.mysql);
  }
}

class Meta {
  constructor(table, mysql) {
    this.table = table;
    this.mysql = mysql;
  }
  // team passwords
  async get(key) {
    const sql = `SELECT meta_value FROM ${this.table} WHERE meta_key = ${key}`;
    const result = await this.mysql.query(sql);
    console.log( 'result : ', result );
    return result;
  }
  async update(key, value) {
    const sql = `UPDATE ${this.table} SET meta_value = '${value}' WHERE meta_key = '${key}'`;
    console.log( 'update sql : ', sql );
    const result = await this.mysql.query(sql);
    return result;
  }
}

class TeamPasswords {
  constructor(table, mysql) {
    this.table = table;
    this.mysql = mysql;
  }
  async getAll() {
    const sql = `SELECT * FROM ${this.table}`;
    const result = await this.mysql.query(sql);
    console.log( 'result - teamPasswords - getAll : ', result );
    return result;
  }
  async update(teamPasswords) {
    var values = "";
    let last = teamPasswords.length - 1;
    for ( var i = 0; i < last; i++ ) {
      values += `('${teamPasswords[i].team}', '${teamPasswords[i].password}'), `;
    }
    values += `('${teamPasswords[last].team}', '${teamPasswords[last].password}')`; // except ','
    const sql = `INSERT INTO ${this.table} (team, password) VALUES ${values} ON DUPLICATE KEY UPDATE password=VALUES(password)`;
    const result = await this.mysql.query(sql);
    return result;
  }
}

module.exports = DCQuery;