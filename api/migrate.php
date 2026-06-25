<?php
/**
 * Standalone migration script to add file storage columns to tbl_siswa.
 * Access via: /api/migrate.php
 * DELETE THIS FILE after migration is complete!
 */

// Get TiDB connection info from environment
$host = getenv('TIDB_HOST') ?: 'localhost';
$user = getenv('TIDB_USER') ?: 'root';
$pass = getenv('TIDB_PASSWORD') ?: '';
$db = (getenv('TIDB_DB') && getenv('TIDB_DB') !== 'sys') ? getenv('TIDB_DB') : 'test';
$port = getenv('TIDB_PORT') ?: 3306;

header('Content-Type: text/html; charset=utf-8');
echo "<h2>TiDB Migration - Add file columns to tbl_siswa</h2>";

try {
    // Connect with SSL for TiDB Cloud
    $conn = new mysqli();
    $flags = 0;
    if (getenv('TIDB_HOST')) {
        $conn->ssl_set(NULL, NULL, NULL, NULL, NULL);
        $flags = MYSQLI_CLIENT_SSL | MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT;
    }
    $conn->real_connect($host, $user, $pass, $db, (int) $port, NULL, $flags);

    if ($conn->connect_error) {
        die("<p style='color:red'>Connection failed: " . $conn->connect_error . "</p>");
    }
    echo "<p style='color:green'>Connected to TiDB successfully!</p>";

    // Ensure CI database session table exists for Vercel serverless session persistence
    $sessionSql = "CREATE TABLE IF NOT EXISTS ci_sessions (
        id VARCHAR(128) NOT NULL,
        ip_address VARCHAR(45) NOT NULL,
        timestamp INT(10) UNSIGNED NOT NULL DEFAULT 0,
        data BLOB NOT NULL,
        PRIMARY KEY (id),
        KEY ci_sessions_timestamp (timestamp)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    if ($conn->query($sessionSql)) {
        echo "<p style='color:green'>✅ ci_sessions table exists or was created.</p>";
    } else {
        echo "<p style='color:red'>❌ Failed to create ci_sessions table: " . $conn->error . "</p>";
    }

    echo "<hr>";

    // CHECK USERS
    echo "<h3>Current Users in tbl_user:</h3><ul>";
    $result = $conn->query("SELECT * FROM tbl_user");
    while ($row = $result->fetch_assoc()) {
        echo "<li>Username: <b>" . htmlspecialchars($row['username']) . "</b> | Password: <b>" . htmlspecialchars($row['password']) . "</b></li>";
    }
    echo "</ul><hr>";

    // Columns to add
    $columns = [
        "foto_kk VARCHAR(255) DEFAULT ''",
        "foto_kk_data LONGTEXT DEFAULT NULL",
        "foto_ktp VARCHAR(255) DEFAULT ''",
        "foto_ktp_data LONGTEXT DEFAULT NULL",
        "foto_skl VARCHAR(255) DEFAULT ''",
        "foto_skl_data LONGTEXT DEFAULT NULL",
        "foto_ijazah VARCHAR(255) DEFAULT ''",
        "foto_ijazah_data LONGTEXT DEFAULT NULL",
        "pas_foto VARCHAR(255) DEFAULT ''",
        "pas_foto_data LONGTEXT DEFAULT NULL",
    ];

    foreach ($columns as $col) {
        $col_name = explode(' ', $col)[0];

        // Check if column exists
        $check = $conn->query("SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_siswa' AND COLUMN_NAME = '{$col_name}'");
        $row = $check->fetch_assoc();

        if ($row['cnt'] > 0) {
            echo "<p>✅ Column <b>{$col_name}</b> already exists, skipped.</p>";
            continue;
        }

        $sql = "ALTER TABLE tbl_siswa ADD COLUMN {$col}";
        if ($conn->query($sql)) {
            echo "<p style='color:green'>✅ Added column: <b>{$col_name}</b></p>";
        } else {
            echo "<p style='color:red'>❌ Failed: {$col_name} - " . $conn->error . "</p>";
        }
    }

    // Ensure id_siswa is the primary key and has AUTO_INCREMENT
    $pk_check = $conn->query("SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_siswa' AND INDEX_NAME = 'PRIMARY' AND COLUMN_NAME = 'id_siswa'");
    $pk_row = $pk_check->fetch_assoc();
    if ($pk_row['cnt'] == 0) {
        if ($conn->query("ALTER TABLE tbl_siswa ADD PRIMARY KEY (id_siswa)")) {
            echo "<p style='color:green'>✅ Added PRIMARY KEY on id_siswa</p>";
        } else {
            echo "<p style='color:red'>❌ Failed to add PRIMARY KEY on id_siswa: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>✅ Primary key on id_siswa already exists.</p>";
    }

    if ($conn->query("ALTER TABLE tbl_siswa MODIFY id_siswa INT(100) NOT NULL AUTO_INCREMENT")) {
        echo "<p style='color:green'>✅ Ensured AUTO_INCREMENT on id_siswa</p>";
    } else {
        $err = $conn->error;
        echo "<p style='color:orange'>⚠️ MODIFY failed, trying CHANGE: " . $err . "</p>";
        if ($conn->query("ALTER TABLE tbl_siswa CHANGE id_siswa id_siswa INT(100) NOT NULL AUTO_INCREMENT")) {
            echo "<p style='color:green'>✅ Ensured AUTO_INCREMENT on id_siswa using CHANGE</p>";
        } else {
            echo "<p style='color:red'>❌ Failed to ensure AUTO_INCREMENT on id_siswa: " . $conn->error . "</p>";
        }
    }

    $conn->close();

    echo "<br><b style='color:green'>Migration complete! Delete this file now.</b>";

} catch (Exception $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
