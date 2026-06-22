<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Controller to serve uploaded files stored as base64 in TiDB database.
 * Usage: /berkas/serve/{no_pendaftaran}/{field_name}
 * Example: /berkas/serve/2025-1747590183/foto_kk
 */
class Berkas extends CI_Controller
{
    public function serve($no_pendaftaran = '', $field = '')
    {
        $allowed_fields = ['foto_kk', 'foto_ktp', 'foto_skl', 'foto_ijazah', 'pas_foto'];

        if (empty($no_pendaftaran) || !in_array($field, $allowed_fields)) {
            show_404();
            return;
        }

        $data_field = $field . '_data';
        $this->db->select("{$field}, {$data_field}");
        $this->db->where('no_pendaftaran', $no_pendaftaran);
        $row = $this->db->get('tbl_siswa')->row();

        if (!$row || empty($row->$data_field)) {
            show_404();
            return;
        }

        // Decode base64 data
        $file_data = base64_decode($row->$data_field);
        $filename = $row->$field;

        // Determine content type from extension
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $mime_types = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];
        $content_type = isset($mime_types[$ext]) ? $mime_types[$ext] : 'application/octet-stream';

        // Output the file
        header('Content-Type: ' . $content_type);
        header('Content-Length: ' . strlen($file_data));
        header('Cache-Control: public, max-age=86400');
        echo $file_data;
    }
}
