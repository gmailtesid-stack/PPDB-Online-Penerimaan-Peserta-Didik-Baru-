const fs = require('fs');
const mysql = require('mysql2/promise');

async function importDb() {
    let sqlFile = fs.readFileSync('db/ppdbonline.sql', 'utf8');

    sqlFile = sqlFile.replace(/ENGINE=MyISAM/gi, 'ENGINE=InnoDB');
    sqlFile = sqlFile.replace(/CHARSET=latin1/gi, 'CHARSET=utf8mb4');
    sqlFile = sqlFile.replace(/COLLATE=latin1_swedish_ci/gi, 'COLLATE=utf8mb4_general_ci');
    sqlFile = sqlFile.replace(/CHARACTER SET latin1 COLLATE latin1_swedish_ci/gi, 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
    sqlFile = sqlFile.replace(/COLLATE latin1_swedish_ci/gi, 'COLLATE utf8mb4_general_ci');

    // Add IF NOT EXISTS
    sqlFile = sqlFile.replace(/CREATE TABLE `/gi, 'CREATE TABLE IF NOT EXISTS `');

    // Handle TiDB limitations with ALTER TABLE AUTO_INCREMENT
    sqlFile = sqlFile.replace(/ALTER TABLE[^;]+;/gi, '');
    sqlFile = sqlFile.replace(/(`id_[a-z_]+` int\(\d+\) NOT NULL),/gi, '$1 AUTO_INCREMENT PRIMARY KEY,');

    // Make inserts idempotent
    sqlFile = sqlFile.replace(/INSERT INTO/gi, 'INSERT IGNORE INTO');

    // Remove comments
    sqlFile = sqlFile.replace(/--.*/g, '');
    sqlFile = sqlFile.replace(/\/\*[\s\S]*?\*\//g, '');

    const conn = await mysql.createConnection({
        host: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com',
        port: 4000,
        user: 'ZxsGDx7pr8JMMQ4.root',
        password: '32jRZmHrIDyXRDuA',
        database: 'test',
        ssl: { rejectUnauthorized: false },
        multipleStatements: true
    });

    const queries = sqlFile.split(/;\s*$/m).filter(q => q.trim().length > 0);

    for (let i = 0; i < queries.length; i++) {
        try {
            await conn.query(queries[i]);
        } catch (e) {
            if (e.code === 'ER_TABLE_EXISTS_ERROR') continue; // Ignore
            console.error('FAILED ON QUERY:\n' + queries[i].substring(0, 100) + '...\nERROR: ' + e.message);
            process.exit(1);
        }
    }
    console.log('Import successful.');
    await conn.end();
}

importDb();
