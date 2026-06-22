<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web extends CI_Controller
{

    public function index()
    {
        $data['web_ppdb'] = $this->web->web_utama();
        $this->load->view('web/index', $data);
    }

    public function idbaru($value = '')
    {
        echo $this->web->pendaftaran('id_baru');
    }

    public function pendaftaran()
    {
        // 1. PROSES UPLOAD DAN SIMPAN DULU
        if (isset($_POST['btndaftar'])) {
            $nama_berkas = array('foto_kk' => '', 'foto_ktp' => '', 'foto_skl' => '', 'foto_ijazah' => '', 'pas_foto' => '');
            $data_berkas = array('foto_kk_data' => '', 'foto_ktp_data' => '', 'foto_skl_data' => '', 'foto_ijazah_data' => '', 'pas_foto_data' => '');
            $list_upload = ['foto_kk', 'foto_ktp', 'foto_skl', 'foto_ijazah', 'pas_foto'];

            foreach ($list_upload as $berkas) {
                if (!empty($_FILES[$berkas]['name'])) {
                    $upload_dir = '/tmp/';
                    if (!getenv('VERCEL') && is_dir('./assets/berkas/')) {
                        $upload_dir = './assets/berkas/';
                    }
                    $config_upload = array(
                        'upload_path' => $upload_dir,
                        'allowed_types' => 'jpg|jpeg|png',
                        'max_size' => 5120,
                        'encrypt_name' => TRUE,
                    );
                    $this->upload->initialize($config_upload);

                    if ($this->upload->do_upload($berkas)) {
                        $upload_data = $this->upload->data();
                        $nama_berkas[$berkas] = $upload_data['file_name'];

                        // Read file and encode as base64 for DB storage
                        $file_path = $upload_data['full_path'];
                        if (file_exists($file_path)) {
                            $file_content = file_get_contents($file_path);
                            $data_berkas[$berkas . '_data'] = base64_encode($file_content);
                            // Clean up temp file on Vercel
                            if (getenv('VERCEL')) {
                                @unlink($file_path);
                            }
                        }
                    } else {
                        $error = $this->upload->display_errors('', '');
                        echo "<div style='font-family:sans-serif; text-align:center; margin-top:50px;'>";
                        echo "<h2>Gagal upload berkas: <b>$berkas</b></h2>";
                        echo "<p style='color:red;'>Pesan Error: <b>" . $error . "</b></p>";
                        echo "</div>";
                        die();
                    }
                }
            }

            // Panggil fungsi simpan ke database di Model (merge filename + file data)
            $acts = $this->web->pendaftaran('daftar', $this->input, array_merge($nama_berkas, $data_berkas));

            $this->session->set_userdata('no_pendaftaran', $this->input->post('nis'));
            redirect('panel_siswa');
            return;
        }

        // 2. TAMPILKAN HALAMAN FORM
        $data = array(
            'id_daftar' => $this->web->pendaftaran('id_baru'),
            'web_ppdb' => $this->web->pendaftaran('status_ppdb'),
            'v_pdd' => $this->web->pendaftaran('v_pdd'),
            'v_penghasilan' => $this->web->pendaftaran('v_penghasilan'),
            'v_pekerjaan_ayah' => $this->web->pendaftaran('v_pekerjaan_ayah'),
            'v_komp' => $this->web->pendaftaran('v_komp'),
            'v_pekerjaan_ibu' => $this->web->pendaftaran('v_pekerjaan_ibu'),
            'v_pekerjaan_wali' => $this->web->pendaftaran('v_pekerjaan_wali')
        );

        if ($data['web_ppdb']->status_ppdb == 'tutup') {
            redirect('404');
        }

        $this->load->view('web/pendaftaran', $data);
    }

    public function logcs()
    {
        $data['web_ppdb'] = $this->web->pendaftaran('status_ppdb');
        if ($data['web_ppdb']->status_ppdb == 'tutup') {
            redirect('404');
        }

        if ($this->session->userdata('no_pendaftaran') != NULL) {
            redirect('panel_siswa');
        } else {
            $this->load->view('web/index', $data);

            if (isset($_POST['btnlogin'])) {
                $send = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->input->post('password')
                );
                $auth = $this->web->auth('cek-masuk', $send);

                if ($auth['sum'] == 0) {
                    $this->session->set_flashdata('msg', $this->err->wrong_auth());
                    redirect('logcs');
                } else {
                    $this->session->set_userdata('no_pendaftaran', $auth['res']->no_pendaftaran);
                    redirect('panel_siswa');
                }
            }
        }
    }

    public function cari()
    {
        $data['siswa'] = $this->SiswaModel->view();
        $this->load->view('web/cari', $data);
    }

    function error_not_found()
    {
        $this->load->view('404_content');
    }
}