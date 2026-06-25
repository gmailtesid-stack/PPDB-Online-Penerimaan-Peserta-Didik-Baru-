<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Migration controller to add file storage columns to tbl_siswa in TiDB.
 * Run once via: /migrate/add_file_columns
 */
class Migrate extends CI_Controller
{
    public function add_file_columns()
    {
        // Add filename columns (VARCHAR) and file data columns (LONGTEXT for base64)
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

        $success = [];
        $errors = [];

        foreach ($columns as $col) {
            $col_name = explode(' ', $col)[0];
            // Check if column already exists
            $check = $this->db->query("SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_siswa' AND COLUMN_NAME = '{$col_name}'");
            if ($check->row()->cnt > 0) {
                $success[] = "Column {$col_name} already exists, skipped.";
                continue;
            }

            $sql = "ALTER TABLE tbl_siswa ADD COLUMN {$col}";
            if ($this->db->query($sql)) {
                $success[] = "Added column: {$col_name}";
            } else {
                $errors[] = "Failed to add column: {$col_name}";
            }
        }

        // Ensure id_siswa is the primary key and has AUTO_INCREMENT
        $pk_check = $this->db->query("SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tbl_siswa' AND INDEX_NAME = 'PRIMARY' AND COLUMN_NAME = 'id_siswa'");
        if ($pk_check->row()->cnt == 0) {
            if ($this->db->query("ALTER TABLE tbl_siswa ADD PRIMARY KEY (id_siswa)")) {
                $success[] = "Ensured PRIMARY KEY on id_siswa.";
            } else {
                $errors[] = "Failed to ensure PRIMARY KEY on id_siswa.";
            }
        } else {
            $success[] = "PRIMARY KEY on id_siswa already exists.";
        }

        if ($this->db->query("ALTER TABLE tbl_siswa MODIFY id_siswa INT(100) NOT NULL AUTO_INCREMENT")) {
            $success[] = "Ensured AUTO_INCREMENT on id_siswa.";
        } else {
            $errors[] = "Failed to ensure AUTO_INCREMENT on id_siswa.";
        }

        // Create CI session table if using database sessions
        $sessionTableSql = "CREATE TABLE IF NOT EXISTS ci_sessions (
            id VARCHAR(128) NOT NULL,
            ip_address VARCHAR(45) NOT NULL,
            timestamp INT(10) UNSIGNED NOT NULL DEFAULT 0,
            data BLOB NOT NULL,
            PRIMARY KEY (id),
            KEY ci_sessions_timestamp (timestamp)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        if ($this->db->query($sessionTableSql)) {
            $success[] = "Ensured ci_sessions database session table exists.";
        } else {
            $errors[] = "Failed to ensure ci_sessions session table exists.";
        }

        echo "<h2>Migration Results</h2>";
        echo "<h3>Success:</h3><ul>";
        foreach ($success as $s)
            echo "<li style='color:green'>{$s}</li>";
        echo "</ul>";
        if ($errors) {
            echo "<h3>Errors:</h3><ul>";
            foreach ($errors as $e)
                echo "<li style='color:red'>{$e}</li>";
            echo "</ul>";
        }
        echo "<br><b>Migration complete!</b>";
    }
}
