<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web extends CI_Controller
{

    public function index()
    {
        $data['web_ppdb']    = $this->web->web_utama();
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
            $nama_berkas = array('foto_kk'=>'', 'foto_ktp'=>'', 'foto_skl'=>'', 'foto_ijazah'=>'', 'pas_foto'=>'');
            $list_upload = ['foto_kk', 'foto_ktp', 'foto_skl', 'foto_ijazah', 'pas_foto'];

            // FIX: Looping upload dengan initialize() setiap iterasi agar config di-reset ulang
            foreach ($list_upload as $berkas) {
                if (!empty($_FILES[$berkas]['name'])) {
                    // FIX: Gunakan initialize() bukan load->library() agar config diterapkan ulang
                    // setiap kali upload (library sudah di-autoload, sehingga load ulang tidak berpengaruh)
                    $config_upload = array(
                        'upload_path'   => './assets/berkas/',
                        'allowed_types' => 'jpg|jpeg|png',
                        'max_size'      => 5120,
                        'encrypt_name'  => TRUE,
                    );
                    $this->upload->initialize($config_upload);

                    if ($this->upload->do_upload($berkas)) {
                        $nama_berkas[$berkas] = $this->upload->data('file_name');
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

            // Panggil fungsi simpan ke database di Model
            $acts = $this->web->pendaftaran('daftar', $this->input, $nama_berkas);

            $this->session->set_userdata('no_pendaftaran', $this->input->post('nis'));
            redirect('panel_siswa');
            return;
        }

        // 2. TAMPILKAN HALAMAN FORM
        $data = array(
            'id_daftar'         => $this->web->pendaftaran('id_baru'),
            'web_ppdb'          => $this->web->pendaftaran('status_ppdb'),
            'v_pdd'             => $this->web->pendaftaran('v_pdd'),
            'v_penghasilan'     => $this->web->pendaftaran('v_penghasilan'),
            'v_pekerjaan_ayah'  => $this->web->pendaftaran('v_pekerjaan_ayah'),
            'v_komp'            => $this->web->pendaftaran('v_komp'),
            'v_pekerjaan_ibu'   => $this->web->pendaftaran('v_pekerjaan_ibu'),
            'v_pekerjaan_wali'  => $this->web->pendaftaran('v_pekerjaan_wali')
        );

        if ($data['web_ppdb']->status_ppdb == 'tutup') {
            redirect('404');
        }

        $this->load->view('web/pendaftaran', $data);
    }

    public function logcs()
    {
        $data['web_ppdb']    = $this->web->pendaftaran('status_ppdb');
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