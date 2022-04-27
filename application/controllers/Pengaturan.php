<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }
    public function standar_pracetak()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Standar Naskah';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'jenjang_id',
                'Jenjang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'mapel_id',
                'Mapel',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'kategori_id',
                'kategori',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $jenjang_id = $this->input->post('jenjang_id');
                $mapel_id = $this->input->post('mapel_id');
                $kategori_id = $this->input->post('kategori_id');
                $standar_pc_id = $jenjang_id . $mapel_id . $kategori_id;
                $ada = $this->db->get_where('standar_pracetak', ['standar_pc_id' => $standar_pc_id])->result_array();


                if (!$ada) {
                    $this->db->set('jenjang_id', $jenjang_id);
                    $this->db->set('mapel_id', $mapel_id);
                    $this->db->set('kategori_id', $kategori_id);
                    $this->db->set('standar_pc_id', $standar_pc_id);
                    $this->db->set('last_update', now('Asia/Jakarta'));
                    $this->db->set('update_oleh', $email);
                    $this->db->insert('standar_pracetak');
                    $this->session->set_flashdata(
                        'pesan',


                        '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">

                                                <strong class="mr-auto">Sukses</strong>

                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Standar pracetak berhasil ditambah
                                            </div>
                                        </div>
                                    </div>'
                    );
                } else {
                    $this->session->set_flashdata(
                        'pesan',

                        '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">

                                                <strong class="mr-auto">Gagal</strong>

                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Standar tersebut sudah terdaftar
                                            </div>
                                        </div>
                                    </div>'
                    );
                }
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {
            $this->form_validation->set_rules(
                'jenjang_id',
                'Jenjang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'mapel_id',
                'Mapel',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'kategori_id',
                'kategori',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $id = $this->input->post('id');
                $jenjang_id = $this->input->post('jenjang_id');
                $mapel_id = $this->input->post('mapel_id');
                $kategori_id = $this->input->post('kategori_id');
                $standar_pc_id = $jenjang_id . $mapel_id . $kategori_id;

                $this->db->set('jenjang_id', $jenjang_id);
                $this->db->set('mapel_id', $mapel_id);
                $this->db->set('kategori_id', $kategori_id);
                $this->db->set('standar_pc_id', $standar_pc_id);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->where('id', $id);
                $this->db->update('standar_pracetak');
                $this->session->set_flashdata(
                    'pesan',


                    '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-primary" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">

                                                <strong class="mr-auto">Sukses</strong>

                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Standar pracetak berhasil diupdate
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }
        $delete = $this->input->post('delete');
        if ($delete) {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->delete('standar_pracetak');
            $this->session->set_flashdata(
                'pesan',
                '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">

                                                <strong class="mr-auto">Sukses</strong>

                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Standar pracetak berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $data['filter_jenjang_id'] = "semua";
        $data['filter_mapel_id'] = "semua";
        $data['filter_kategori_id'] = "semua";

        $filter = $this->input->post('filter');
        if ($filter) {
            $data['filter_jenjang_id'] = $this->input->post('jenjang_id');
            $data['filter_mapel_id'] = $this->input->post('mapel_id');
            $data['filter_kategori_id'] = $this->input->post('kategori_id');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengaturan/standar_pracetak', $data);
        $this->load->view('templates/footer');
    }

    public function hak_akses()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Hak Akses';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $lihat = $this->input->post('lihat');
        if ($lihat) {
            $data['level_idx'] = $this->input->post('level_idx');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengaturan/hak_akses', $data);
            $this->load->view('templates/footer');
        }

        $update = $this->input->post('update');
        if ($update) {
            $level_idx = $this->input->post('level_idx');

            $data['level_idx'] = $this->input->post('level_idx');
            $menu = $this->db->get('menu')->result_array();
            foreach ($menu as $m) {
                $id = $m['id'];
                $hak = $this->input->post($id);
                if (!isset($hak)) {
                    $hak = 0;
                }
                $this->db->where('level_id', $level_idx);
                $this->db->where('menu_id', $id);
                $ada = $this->db->get('hak_akses')->row_array();

                if (isset($ada)) {
                    $this->db->set('hak', $hak);
                    $this->db->where('level_id', $level_idx);
                    $this->db->where('menu_id', $id);
                    $this->db->update('hak_akses');
                } else {
                    $this->db->set('hak', $hak);
                    $this->db->set('level_id', $level_idx);
                    $this->db->set('menu_id', $id);
                    $this->db->insert('hak_akses');
                }

                if ($hak == 1) {
                    $parent = $this->db->get_where('menu', ['id' => $m['id']])->row()->parent;
                    $this->db->where('level_id', $level_idx);
                    $this->db->where('menu_id', $parent);
                    $ada = $this->db->get('hak_akses')->row_array();

                    if (isset($ada)) {
                        $this->db->set('hak', 1);
                        $this->db->where('level_id', $level_idx);
                        $this->db->where('menu_id', $parent);
                        $this->db->update('hak_akses');
                    } else {
                        $this->db->set('hak', 1);
                        $this->db->set('level_id', $level_idx);
                        $this->db->set('menu_id', $parent);
                        $this->db->insert('hak_akses');
                    }
                }
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">

                                                <strong class="mr-auto">Sukses</strong>

                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Hak Akses sudah diupdate
                                            </div>
                                        </div> </div>'
                );
            }
            $data['level_idx'] = $this->input->post('level_idx');
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/user_level', $data);
            $this->load->view('templates/footer');
        }
    }

    public function standar_waktu()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Standar Waktu';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['standar_pc_id'] = $this->input->post('standar_pc_id');
        $tambah = $this->input->post('tambah');

        if ($tambah) {
            $alur_kerja_id = $this->input->post('alur_kerja_id');

            $this->form_validation->set_rules(
                'alur_kerja_id',
                'Model Alur Kerja',
                'required|callback_alur_kerja_id_check',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {

                $alur_kerja_id = $this->input->post('alur_kerja_id');
                $standar_pc_id = $this->input->post('standar_pc_id');
                $standar_model_id = $data['standar_pc_id'] . $alur_kerja_id;
                $this->db->set('standar_pc_id', $data['standar_pc_id']);
                $this->db->set('standar_model_id', $standar_model_id);
                $this->db->set('alur_kerja_id', $alur_kerja_id);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('standar_model_alur_kerja');

                $this->db->where('alur_kerja_id', $alur_kerja_id);
                $level_kerja = $this->db->get('detail_alur_kerja')->result_array();
                foreach ($level_kerja as $lk) : {
                        $detail_alur_kerja_id = $lk['detail_alur_kerja_id'];
                        $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $this->db->set('standar_pc_id', $standar_pc_id);
                        $this->db->set('last_update', now('Asia/Jakarta'));
                        $this->db->set('update_oleh', $email);
                        $this->db->set('is_active', 1);
                        $this->db->insert('standar_waktu');
                    }
                endforeach;

                $this->session->set_flashdata(
                    'pesan',
                    '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">

                                                <strong class="mr-auto">Sukses</strong>

                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Alur Kerja Sudah Ditambah
                                            </div>
                                        </div> </div>'
                );
            }
        }

        $delete = $this->input->post('delete');
        if ($delete) {
            $alur_kerja_id = $this->input->post('alur_kerja_id');
            $standar_pc_id = $this->input->post('standar_pc_id');
            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $this->db->where('standar_pc_id', $standar_pc_id);
            $this->db->delete('standar_model_alur_kerja');

            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $level_kerja = $this->db->get('detail_alur_kerja')->result_array();
            foreach ($level_kerja as $lk) : {
                    $detail_alur_kerja_id = $lk['detail_alur_kerja_id'];
                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                    $this->db->where('standar_pc_id', $standar_pc_id);
                    $this->db->delete('standar_waktu');
                }
            endforeach;

            $this->session->set_flashdata(
                'pesan',
                '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">

                                                <strong class="mr-auto">Sukses</strong>

                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Alur Kerja Sudah Dihapus
                                            </div>
                                        </div> </div>'
            );
        }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengaturan/standar_waktu', $data);
        $this->load->view('templates/footer');
    }

    public function alur_kerja_id_check()
    {
        $alur_kerja_id = $this->input->post('alur_kerja_id');
        $standar_pc_id = $this->input->post('standar_pc_id');

        $ada = $this->db->get_where('standar_model_alur_kerja', array('alur_kerja_id' => $alur_kerja_id, 'standar_pc_id' => $standar_pc_id))->num_rows();
        if ($ada != 0) {
            $this->form_validation->set_message('alur_kerja_id_check', '*) {field} sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function atur_standar_waktu()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Standar Waktu';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['standar_pc_id'] = $this->input->post('standar_pc_id');
        $data['alur_kerja_id'] = $this->input->post('alur_kerja_id');

        $standar_pc_id = $data['standar_pc_id'];
        $alur_kerja_id = $data['alur_kerja_id'];

        $update = FALSE;
        $update = $this->input->post('update');
        if ($update) {
            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();
            foreach ($detail_alur_kerja as $dak) : {
                    $detail_alur_kerja_id = $dak['detail_alur_kerja_id'];
                    $waktu = $this->input->post($detail_alur_kerja_id);

                    $this->db->where('standar_pc_id', $standar_pc_id);
                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                    $this->db->set('waktu', $waktu);
                    $this->db->set('last_update', now('Asia/Jakarta'));
                    $this->db->set('update_oleh', $email);
                    $this->db->update('standar_waktu');
                }
            endforeach;
            $this->session->set_flashdata(
                'pesan',
                '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-primary" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">

                                                <strong class="mr-auto">Sukses</strong>

                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Standar Waktu sudah terupdate
                                            </div>
                                        </div> </div>'
            );
        }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengaturan/atur_standar_waktu', $data);
        $this->load->view('templates/footer');
    }

    function addDay($date, $liburs) {
        // echo json_encode([date('d-m-Y', $date), in_array(date('d-m-Y', $date), $liburs)]) . '<br>';
        if (in_array(date('d-m-Y', $date), $liburs)) {
            $new_date = strtotime(date('d-m-Y', $date) . " +1 days");
            if ($date == $new_date) {
                return strtotime(date('d-m-Y', $new_date) . " +2 days");
            } else {
                return $this->addDay($new_date, $liburs);
            }
        } else {
            return $date;
        }
    }

    public function perencanaan_produksi() {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Perencanaan Produksi';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['naskah'] = [
            'nojob' => '',
            'judul' => '',
            'jilid' => '',
            'penulis' => '',
            'standar_pc_id' => ''
        ];
        $data['error1'] = '';
        $data['alur_kerja_id'] = '';
        $data['tampil'] = FALSE;
        $cari = FALSE;
        $atur = FALSE;
        $tambah = FALSE;
        $lihat = FALSE;
        $proses = FALSE;
        $cari = $this->input->post('cari');
        $data['tglmulai'] = 0;

        if ($cari) {
            $this->form_validation->set_rules(
                'nojob',
                'No Job',
                'required',
                array(
                    'required'      => 'Tidak ada %s yang dicari.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $nojob = $this->input->post('nojob');
                $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();

                if (!isset($data['naskah'])) {
                    $data['naskah'] = [
                        'nojob' => '',
                        'judul' => '',
                        'jilid' => '',
                        'penulis' => '',
                        'standar_pc_id' => ''
                    ];

                    $data['error1'] = '<div class="alert alert-danger" role="alert">
                                        No Job ' . $nojob . ' belum terdaftar
                                        </div>';
                }
            }
        }

        $atur = $this->input->post('atur');
        if ($atur) {
            $nojob = $this->input->post('nojob');
            $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
            $this->db->order_by('objek_kerja_id');
            $objek_kerja = $this->db->get('objek_kerja')->result_array();
            $alur_kerja_id = $this->input->post('alur_kerja_id');
            $data['alur_kerja_id'] =  $alur_kerja_id;

            $this->db->where('nojob', $nojob);
            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $banyak = $this->db->get('naskah_rencana_produksi')->num_rows();
            if ($banyak != 0) {
                $this->db->order_by('versi DESC');
                $this->db->where('nojob', $nojob);
                $this->db->where('alur_kerja_id', $alur_kerja_id);
                $naskah_rencana_produksi_id = $this->db->get('naskah_rencana_produksi')->row()->naskah_rencana_produksi_id;
                $banyak = $this->db->get_where('progres_naskah', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->num_rows();
                if ($banyak != 0) {

                    $data['error1'] = '<div class="alert alert-danger" role="alert">
                                        No Job ' . $nojob . ' sudah dalam proses.  Tidak bisa dibuat rencana baru
                                        </div>';

                    $data['tampil'] = FALSE;
                    $proses = FALSE;
                } else {
                    $proses = TRUE;
                    $urutan_hitung = 0;
                    $objek_refresh = '';
                    $mulai = now('Asia/Jakarta');
                }
            } else {
                $proses = TRUE;
                $urutan_hitung = 0;
                $mulai = now('Asia/Jakarta');
                $objek_refresh = '';
            }
        }

        $hitung_ulang = FALSE;
        $hitung_ulang = $this->input->post('hitung_ulang');
        if ($hitung_ulang) {
            $nojob = $this->input->post('nojob');
            $alur_kerja_id = $this->input->post('alur_kerja_id');
            $this->db->order_by('urutan ASC');
            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();

            $data['alur_kerja_id'] =  $alur_kerja_id;
            foreach ($detail_alur_kerja as $dak) : {
                $mulai_post[$dak['detail_alur_kerja_id']] = $this->input->post('mulai-' . $dak['detail_alur_kerja_id']);
                    $mulaix[$dak['detail_alur_kerja_id']] = strtotime($mulai_post[$dak['detail_alur_kerja_id']]);
                    $refresh[$dak['id']] = $this->input->post('refresh-' . $dak['detail_alur_kerja_id']);
                    if ($refresh[$dak['id']]) {
                        $objek_refresh = [$dak['nama_objek_kerja']];
                        $urutan_hitung = $dak['urutan'];
                        $proses = TRUE;
                    }
                }
            endforeach;
        }
        if ($proses) {
            $data['tampil'] = TRUE;
            $data['save'] = TRUE;
            $data['ada_standar'] = TRUE;
            $data['spek'] = TRUE;
            $this->db->order_by('objek_kerja_id');
            $objek_kerja = $this->db->get('objek_kerja')->result_array();
            foreach ($objek_kerja as $ok) : {
                    $mulai = now('Asia/Jakarta'); // inisialisasi tanggal

                    // perhitungan up from tgl libur
                    $get_near_libur = $this->db->select('str_tanggal')->where('tahun', date('Y', $mulai))->get('hari_libur')->result_array();
                    // turn to array
                    $liburs = [];
                    foreach ($get_near_libur as $libur) {
                        array_push($liburs, $libur['str_tanggal']);
                    }

                    $mulai = $this->addDay($mulai, $liburs);

                    //-
                    $id = $ok['id'];
                    $nama_objek_kerja = $ok['nama_objek_kerja'];
                    $inisial_objek_kerja = $ok['inisial_objek_kerja'];

                    if ($nojob == '') {
                        $jumlah_halaman = 0;
                    } else {
                        $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
                        $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                        $this->db->where('nojob', $nojob);
                        $ada_halaman = $this->db->get('spek_naskah')->row_array();
                        if (!isset($ada_halaman)) {
                            $jumlah_halaman = 0;
                        } else {
                            $jumlah_halaman = $ada_halaman['jumlah_halaman'];
                        }
                        $data['halaman'][$ok['id']] = $jumlah_halaman;
                    }

                    if ($ok['perhitungan_durasi'] == 'sat_hari') {
                        $perhitungan_durasi = $ok['satuan'] . "/hari";
                    } else {
                        if ($ok['perhitungan_durasi'] == 'hari_sat') {
                            $perhitungan_durasi = "hari/" . $ok['satuan'];
                        } else {
                            $perhitungan_durasi = "";
                        }
                    }

                    //-


                    $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                    $this->db->where('alur_kerja_id', $alur_kerja_id);
                    $this->db->order_by('urutan ASC');
                    $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();


                    foreach ($detail_alur_kerja as $key => $dak) : {
                            if ($dak['urutan'] <= $urutan_hitung) {
                                $detail_alur_kerja_id = $dak['detail_alur_kerja_id'];
                                $standar_pc_id = $data['naskah']['standar_pc_id'];
                                $pic = $this->input->post($detail_alur_kerja_id . 'pic');
                                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                $this->db->where('standar_pc_id', $standar_pc_id);

                                $standar_waktu = $this->db->get('standar_waktu')->row_array();

                                if (!isset($standar_waktu)) {
                                    $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                                    $this->db->set('standar_pc_id', $standar_pc_id);
                                    $this->db->set('waktu', 0);
                                    $this->db->set('last_update', now('Asia/Jakarta'));
                                    $this->db->set('update_oleh', $email);
                                    $this->db->insert('standar_waktu');
                                }
                                $mulai = $mulaix[$dak['detail_alur_kerja_id']];
                                $mulai0 = $mulai;
                                $printmulai0 = date('d-m-Y', $mulai0);

                                $kecepatan = $standar_waktu['waktu'];

                                if ($kecepatan != 0) {
                                    $save = TRUE;
                                    if ($ok['perhitungan_durasi'] == 'sat_hari') {
                                        $waktu = ceil($jumlah_halaman / $kecepatan);
                                    } else {
                                        if ($ok['perhitungan_durasi'] == 'hari_sat') {
                                            $waktu = ceil($kecepatan / $jumlah_halaman);
                                        }
                                    }

                                    $waktu0 = $waktu;
                                    $tambah_hari = $waktu - 1;
                                    $printmulai = date('d-m-Y', $mulai);
                                    $selesai = strtotime($printmulai . " +$tambah_hari days");
                                    $printselesai = date('d-m-Y', $selesai);

                                    $banyak_libur_total = 0;
                                    do {
                                        $this->db->where('tanggal >=', $mulai);
                                        $this->db->where('tanggal <=', $selesai);
                                        $banyak_libur = $this->db->count_all_results('hari_libur');
                                        if ($banyak_libur != 0) {
                                            $mulai = strtotime($printselesai . " +1 days");
                                            $waktu = $banyak_libur;
                                            $tambah_hari = $waktu - 1;
                                            $printmulai = date('d-m-Y', $mulai);
                                            $selesai = strtotime($printmulai . " +$tambah_hari days");
                                            $printselesai = date('d-m-Y', $selesai);
                                            $banyak_libur_total = $banyak_libur + $banyak_libur_total;
                                        }
                                    } while ($banyak_libur != 0);;
                                    $data['rencana'][$ok['nama_objek_kerja']][$dak['urutan']] = [
                                        'nama_objek_kerja' => $ok['nama_objek_kerja'],
                                        'urutan' => $dak['urutan'],
                                        'inisial_level_kerja' => $dak['inisial_level_kerja'],
                                        'mulai' => $printmulai0,
                                        'durasi' => $waktu0,
                                        'libur' => $banyak_libur_total,
                                        'kecepatan' => $kecepatan,
                                        'selesai' => $printselesai,
                                        'pic' => $pic
                                    ];
                                    $mulai = strtotime($printselesai . " +1 days");
                                } else {
                                    $save = FALSE;
                                    $data['ada_standar'] = FALSE;
                                    $data['rencana'][$ok['nama_objek_kerja']][$dak['urutan']] = [
                                        'nama_objek_kerja' => $ok['nama_objek_kerja'],
                                        'urutan' => $dak['urutan'],
                                        'inisial_level_kerja' => $dak['inisial_level_kerja'],
                                        'mulai' => 'Standar waktu blm ditentukan',
                                        'durasi' => 'Standar waktu blm ditentukan',
                                        'libur' => 'Standar waktu blm ditentukan',
                                        'kecepatan' => 'Standar waktu blm ditentukan',
                                        'selesai' => 'Standar waktu blm ditentukan',
                                        'pic' => ''
                                    ];
                                }
                            } else {
                                $detail_alur_kerja_id = $dak['detail_alur_kerja_id'];
                                $pic = $this->input->post($detail_alur_kerja_id . 'pic');
                                $standar_pc_id = $data['naskah']['standar_pc_id'];
                                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                $this->db->where('standar_pc_id', $standar_pc_id);

                                $standar_waktu = $this->db->get('standar_waktu')->row_array();

                                if (!isset($standar_waktu)) {
                                    $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                                    $this->db->set('standar_pc_id', $standar_pc_id);
                                    $this->db->set('waktu', 0);
                                    $this->db->set('last_update', now('Asia/Jakarta'));
                                    $this->db->set('update_oleh', $email);
                                    $this->db->insert('standar_waktu');
                                }
                                $mulai0 = $mulai;
                                $printmulai_ = date('d-m-Y', $mulai0);
                                $printmulai0 = $key == 0 ? $printmulai_ : date('d-m-Y', $this->addDay(strtotime($printmulai_), $liburs));
                                $kecepatan = $standar_waktu['waktu'];

                                if ($kecepatan != 0 and $jumlah_halaman != 0) {
                                    $save = TRUE;
                                    if ($ok['perhitungan_durasi'] == 'sat_hari') {
                                        $waktu = ceil($jumlah_halaman / $kecepatan);
                                    } else {
                                        if ($ok['perhitungan_durasi'] == 'hari_sat') {
                                            $waktu = ceil($kecepatan / $jumlah_halaman);
                                        }
                                    }


                                    $waktu0 = $waktu;
                                    $tambah_hari = $waktu - 1;
                                    $printmulai = date('d-m-Y', $mulai);
                                    $selesai = strtotime($printmulai . " +$tambah_hari days");
                                    $printselesai = date('d-m-Y', $selesai);

                                    $banyak_libur_total = 0;
                                    do {
                                        $this->db->where('tanggal >=', $mulai);
                                        $this->db->where('tanggal <=', $selesai);
                                        $banyak_libur = $this->db->count_all_results('hari_libur');
                                        if ($banyak_libur != 0) {
                                            $mulai = strtotime($printselesai . " +1 days");
                                            $waktu = $banyak_libur;
                                            $tambah_hari = $waktu - 1;
                                            $printmulai = date('d-m-Y', $mulai);
                                            $selesai = strtotime($printmulai . " +$tambah_hari days");
                                            $printselesai = date('d-m-Y', $selesai);
                                            $banyak_libur_total = $banyak_libur + $banyak_libur_total;
                                        }
                                    } while ($banyak_libur != 0);
                                    $data['rencana'][$ok['nama_objek_kerja']][$dak['urutan']] = [
                                        'nama_objek_kerja' => $ok['nama_objek_kerja'],
                                        'urutan' => $dak['urutan'],
                                        'inisial_level_kerja' => $dak['inisial_level_kerja'],
                                        'mulai' => $printmulai0,
                                        'durasi' => $waktu0,
                                        'libur' => $banyak_libur_total,
                                        'kecepatan' => $kecepatan,
                                        'selesai' => $printselesai,
                                        'pic' => $pic
                                    ];

                                    $mulai = strtotime($printselesai . " +1 days");
                                } else {
                                    if ($kecepatan == 0) {
                                        $data['save'] = FALSE;
                                        $data['ada_standar'] = FALSE;
                                        $data['rencana'][$ok['nama_objek_kerja']][$dak['urutan']] = [
                                            'nama_objek_kerja' => $ok['nama_objek_kerja'],
                                            'urutan' => $dak['urutan'],
                                            'inisial_level_kerja' => $dak['inisial_level_kerja'],
                                            'mulai' => '-',
                                            'durasi' => 'Standar waktu blm ditentukan',
                                            'libur' => 'Standar waktu blm ditentukan',
                                            'kecepatan' => 'Standar waktu blm ditentukan',
                                            'selesai' => 'Standar waktu blm ditentukan',
                                            'pic' => ''
                                        ];
                                    }
                                    if ($jumlah_halaman == 0) {
                                        $data['save'] = FALSE;
                                        $data['ada_standar'] = FALSE;
                                        $data['spek'] = FALSE;
                                        $data['rencana'][$ok['nama_objek_kerja']][$dak['urutan']] = [
                                            'nama_objek_kerja' => $ok['nama_objek_kerja'],
                                            'urutan' => $dak['urutan'],
                                            'inisial_level_kerja' => $dak['inisial_level_kerja'],
                                            'mulai' => '-',
                                            'durasi' => 'Spek 0 (nol): tidak bisa dihitung',
                                            'libur' => 'Edit Spek',
                                            'kecepatan' => $kecepatan,
                                            'selesai' => 'Atau ubah model alur kerja',
                                            'pic' => ''
                                        ];
                                    }
                                }
                            }
                        }
                    endforeach;
                }
            endforeach;
        }

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $nojob = $this->input->post('nojob');

            $alur_kerja_id = $this->input->post('alur_kerja_id');
            $this->db->where('nojob', $nojob);
            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $banyak = $this->db->get('naskah_rencana_produksi')->num_rows();
            if ($banyak == 0) {
                $versi = 1;
            } else {
                $this->db->select_max('versi');
                $this->db->where('nojob', $nojob);
                $this->db->where('alur_kerja_id', $alur_kerja_id);
                $versi = $this->db->get('naskah_rencana_produksi')->row()->versi;
                $versi = $versi + 1;
            }
            $naskah_rencana_produksi_id = $nojob . $alur_kerja_id . $versi;
            $this->db->set('nojob', $nojob);
            $this->db->set('alur_kerja_id', $alur_kerja_id);
            $this->db->set('versi', $versi);
            $this->db->set('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
            $this->db->set('last_update', now('Asia/Jakarta'));
            $this->db->set('update_oleh', $email);
            $this->db->set('is_active', 1);
            $this->db->insert('naskah_rencana_produksi');

            $this->db->where('substr(naskah_rencana_produksi_id,1,6)=', $nojob);
            $this->db->where('naskah_rencana_produksi_id !=', $naskah_rencana_produksi_id);
            $this->db->set('is_active', 0);
            $this->db->update('detail_rencana_produksi');

            $this->db->where('substr(naskah_rencana_produksi_id,1,6)=', $nojob);
            $this->db->where('naskah_rencana_produksi_id !=', $naskah_rencana_produksi_id);
            $this->db->set('is_active', 0);
            $this->db->update('pic_rencana');

            $this->db->where('alur_kerja_id', $alur_kerja_id);

            $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();

            foreach ($detail_alur_kerja as $dak) : {
                    $detail_alur_kerja_id = $dak['detail_alur_kerja_id'];
                    $nama_unit_kerja = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id' => $detail_alur_kerja_id])->row()->nama_unit_kerja;
                    $urutan = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id' => $detail_alur_kerja_id])->row()->urutan;
                    $mulai = $this->input->post($detail_alur_kerja_id . 'mulai');
                    $selesai = $this->input->post($detail_alur_kerja_id . 'selesai');
                    $pic = $this->input->post($detail_alur_kerja_id . 'pic');
                    $nama_objek_kerja = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id' => $detail_alur_kerja_id])->row()->nama_objek_kerja;

                    if ($urutan == 1) {
                        $this->db->set('antre', date('Y-m-d', strtotime($mulai)));
                        $this->db->set('status', 'ANTRE');
                    }

                    $this->db->set('urutan', $urutan);
                    $this->db->set('mulai', $mulai);
                    $this->db->set('mulai_int', strtotime($mulai . ' 00:00'));
                    $this->db->set('selesai', $selesai);
                    $this->db->set('selesai_int', strtotime($selesai . ' 23:59'));
                    $this->db->set('pic', $pic);
                    $this->db->set('pic_real', '-');
                    $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                    $this->db->set('nama_unit_kerja', $nama_unit_kerja);
                    $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                    $this->db->set('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                    $this->db->set('last_update', now('Asia/Jakarta'));
                    $this->db->set('update_oleh', $email);
                    $this->db->set('is_active', 1);
                    $this->db->insert('detail_rencana_produksi');

                    if ($pic != 'tentatif') {
                        $this->db->set('mulai', $mulai);
                        $this->db->set('mulai_int', strtotime($mulai . ' 00:00'));
                        $this->db->set('selesai', $selesai);
                        $this->db->set('selesai_int', strtotime($selesai . ' 23:59'));
                        $this->db->set('email', $pic);
                        $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);

                        $this->db->set('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                        $this->db->set('last_update', now('Asia/Jakarta'));
                        $this->db->set('update_oleh', $email);
                        $this->db->set('is_active', 1);
                        $this->db->insert('pic_rencana');
                    }
                }
            endforeach;
            $data['alur_kerja_id'] = $alur_kerja_id;
            $data['versi'] = $versi;
            $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
        }

        $lihat = $this->input->post('lihat');
        if ($lihat) {
            $nojob = $this->input->post('nojob');

            $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();

            $this->db->order_by('last_update DESC');
            $this->db->where('nojob', $nojob);
            $naskah_rencana_produksi = $this->db->get('naskah_rencana_produksi')->row_array();
            $id = $naskah_rencana_produksi['id'];

            $versi = $naskah_rencana_produksi['versi'];
            $data['versi'] = $versi;
            $alur_kerja_id = $naskah_rencana_produksi['alur_kerja_id'];
            $data['alur_kerja_id'] = $alur_kerja_id;

            $tambah = TRUE;
        }
        
        if ($tambah) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengaturan/tampil_perencanaan_produksi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pengaturan/perencanaan_produksi', $data);
            $this->load->view('templates/footer');
        }
    }

    public function hari_libur()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Hari Libur';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['tahun'] = date('Y');
        $rutin = FALSE;
        $rutin = $this->input->post('rutin');
        if ($rutin) {
            $tahun = $this->input->post('tahun');
            if ($tahun == '') {
                $data['tahun'] = date('Y');
            } else {
                $data['tahun'] = $tahun;
            }
            $this->db->where('keterangan', 'Rutin');
            $this->db->delete('hari_libur');

            $sabtu = $this->input->post('sabtu');
            $minggu = $this->input->post('minggu');
            if ($sabtu) {
                $tanggal_awal = "01-01-" . $data['tahun'];
                $tanggal_akhir = "31-12-" . $data['tahun'];
                $awal = strtotime($tanggal_awal);
                $akhir = strtotime($tanggal_akhir);
                $tanggal = $awal;
                while ($tanggal <= $akhir) {
                    $dayW = date('w', $tanggal);
                    $str_tanggal = date('d-m-Y', $tanggal);
                    if ($dayW == 6) {
                        $tahun = date('Y', $tanggal);
                        $sudah_ada = $this->db->get_where('hari_libur', ['str_tanggal' => $str_tanggal])->row_array();
                        if (!isset($sudah_ada)) {
                            $this->db->set('tahun', $tahun);
                            $this->db->set('tanggal', $tanggal);
                            $this->db->set('str_tanggal', $str_tanggal);
                            $this->db->set('keterangan', 'Rutin');
                            $this->db->insert('hari_libur');
                        }
                    }
                    $tanggal = strtotime($str_tanggal . " +1 days");

                    // $tanggal = $tanggal + 24 * 60 * 60;
                }
            } else {
                $tanggal_awal = "01-01-" . $data['tahun'];
                $tanggal_akhir = "31-12-" . $data['tahun'];
                $awal = strtotime($tanggal_awal);
                $akhir = strtotime($tanggal_akhir);
                $tanggal = $awal;
                while ($tanggal <= $akhir) {
                    $dayW = date('w', $tanggal);
                    $str_tanggal = date('d-m-Y', $tanggal);
                    if ($dayW == 6) {
                        $tahun = date('Y', $tanggal);
                        $this->db->where('str_tanggal', $str_tanggal);
                        $this->db->where('keterangan', 'Rutin');
                        $this->db->delete('hari_libur');
                    }
                    $tanggal = strtotime($str_tanggal . " +1 days");
                    //  $tanggal = $tanggal + 24 * 60 * 60;
                }
            }
            if ($minggu) {
                $tanggal_awal = "01-01-" . $data['tahun'];
                echo $tanggal_awal;
                $tanggal_akhir = "31-12-" . $data['tahun'];
                $awal = strtotime($tanggal_awal);
                $akhir = strtotime($tanggal_akhir);
                $tanggal = $awal;
                while ($tanggal <= $akhir) {
                    $dayW = date('w', $tanggal);
                    $str_tanggal = date('d-m-Y', $tanggal);
                    if ($dayW == 0) {
                        $tahun = date('Y', $tanggal);
                        $sudah_ada = $this->db->get_where('hari_libur', ['str_tanggal' => $str_tanggal])->row_array();
                        if (!isset($sudah_ada)) {
                            $this->db->set('tahun', $tahun);
                            $this->db->set('tanggal', $tanggal);
                            $this->db->set('str_tanggal', $str_tanggal);
                            $this->db->set('keterangan', 'Rutin');
                            $this->db->insert('hari_libur');
                        }
                    }
                    // $tanggal = $tanggal + 24 * 60 * 60;
                    $tanggal = strtotime($str_tanggal . " +1 days");
                }
            } else {
                $tanggal_awal = "01-01-" . $data['tahun'];
                $tanggal_akhir = "31-12-" . $data['tahun'];
                $awal = strtotime($tanggal_awal);
                $akhir = strtotime($tanggal_akhir);
                $tanggal = $awal;
                while ($tanggal <= $akhir) {
                    $dayW = date('w', $tanggal);
                    $str_tanggal = date('d-m-Y', $tanggal);
                    if ($dayW == 0) {
                        $tahun = date('Y', $tanggal);
                        $this->db->where('str_tanggal', $str_tanggal);
                        $this->db->where('keterangan', 'Rutin');
                        $this->db->delete('hari_libur');
                    }
                    //$tanggal = $tanggal + 24 * 60 * 60;
                    $tanggal = strtotime($str_tanggal . " +1 days");
                }
            }
        }
        $nasional = FALSE;
        $nasional = $this->input->post('nasional');
        if ($nasional) {
            $datepicker = $this->input->post('datepicker');
            $tanggal = strtotime($datepicker);
            $str_tanggal = date('d-m-Y', $tanggal);
            $tahun = date('Y', $tanggal);
            $keterangan = $this->input->post('keterangan');

            $sudah_ada = $this->db->get_where('hari_libur', ['tanggal' => $tanggal])->row_array();
            if (!isset($sudah_ada)) {
                $this->db->set('tahun', $tahun);
                $this->db->set('tanggal', $tanggal);
                $this->db->set('str_tanggal', $str_tanggal);
                $this->db->set('keterangan', $keterangan);
                $this->db->insert('hari_libur');
            } else {
                $this->db->where('tanggal', $tanggal);
                $this->db->set('str_tanggal', $str_tanggal);
                $this->db->set('keterangan', $keterangan);
                $this->db->set('tahun', $tahun);
                $this->db->update('hari_libur');
            }
        }

        $delete_nasional = FALSE;
        $delete_nasional = $this->input->post('delete_nasional');
        if ($delete_nasional) {
            $date = $this->input->post('date');
            $tanggal = date('d-m-Y', $date);
            $this->db->where('str_tanggal', $tanggal);
            $this->db->delete('hari_libur');
        }



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pengaturan/hari_libur', $data);
        $this->load->view('templates/footer');
    }

    public function adjustment()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Gudang';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $detail_rencana_produksi = $this->db->get('detail_rencana_produksi')->result_array();

        foreach ($detail_rencana_produksi as $drp) : {
                $id = $drp['id'];
                $detail_alur_kerja_id = $drp['detail_alur_kerja_id'];
                $nama_objek_kerja = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id' => $detail_alur_kerja_id])->row()->nama_objek_kerja;
                $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                $this->db->where('id', $id);
                $this->db->update('detail_rencana_produksi');
            }
        endforeach;

        redirect('user/index');
    }
}
