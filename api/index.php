<?php
// Mengubah direktori aktif ke root project agar CodeIgniter bisa mendeteksi /system dan /application
chdir(__DIR__ . '/../');
require_once __DIR__ . '/../index.php';
