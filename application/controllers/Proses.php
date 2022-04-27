<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function user()
    {
        $data['title'] = 'Daftar User';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $edit = $this->input->post('edit');
        if ($edit) {
            $email_user = $this->input->post('email');
            $level_id_lama = $this->db->get_where('user', ['email' => $email_user])->row()->level_id;
            $is_active_lama = $this->db->get_where('user', ['email' => $email_user])->row()->is_active;
            $level_id = $this->input->post('level_id');
            $is_active = $this->input->post('is_active');

            if ($level_id_lama != $level_id or $is_active_lama != $is_active) {
                $this->db->set('level_id', $level_id);
                $this->db->set('is_active', $is_active);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->where('email', $email_user);
                $this->db->update('user');

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
                                                Data User sudah diupdate
                                            </div>
                                        </div> </div>'
                );
            }
        }

        $delete = $this->input->post('delete');
        if ($delete) {
            $email_user = $this->input->post('email');
            $this->db->where('email', $email_user);
            $this->db->delete('user');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('proses/user', $data);
        $this->load->view('templates/footer');
    }



    public function progres_naskah()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Progres Naskah';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $level_id = $this->db->get_where('user', ['email' => $email])->row()->level_id;
        $nama_unit_kerja = $this->db->get_where('user_level', ['level_id' => $level_id])->row()->nama_unit_kerja;
        $data['error1'] = '';
        $this->db->select_max('id');
        $this->db->where('user_email', $email);
        $id = $this->db->get('progres_naskah')->row()->id;

        $cari = FALSE;
        if (!$id) {
            $data['naskah'] = [
                'nojob' => '',
                'judul' => '',
                'jilid' => '',
                'penulis' => '',
                'standar_pc_id' => ''
            ];
            $data['versi'] = '';
            $data['tombol_aktif'] = FALSE;
            $data['error1'] = '';
            $data['alur_kerja_id'] = '';
            $cari = FALSE;
            $atur = FALSE;
            $tambah = FALSE;
            $tombol_mulai = FALSE;
            $tombol_selesai = FALSE;
            $data['posisi_mulai'] = FALSE;
            $data['ada_rencana_produksi'] = FALSE;
            $data['lihat'] = FALSE;
            $cari = $this->input->post('cari');
            $data['tglmulai'] = 0;
            $data['status'] = 'SELESAI';
        } else {
            $this->db->where('id', $id);
            $proses = $this->db->get('progres_naskah')->row_array();
            $status = $proses['status'];

            switch ($status) {
                case 'MULAI':
                    $nojob = $proses['nojob'];
                    $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
                    $data['tombol_aktif'] = TRUE;

                    $this->db->order_by('last_update DESC');
                    $this->db->where('nojob', $nojob);
                    $naskah_rencana_produksi = $this->db->get('naskah_rencana_produksi')->row_array();
                    $cari = FALSE;
                    $data['lihat'] = TRUE;
                    $id = $naskah_rencana_produksi['id'];
                    $versi = $naskah_rencana_produksi['versi'];
                    $alur_kerja_id = $naskah_rencana_produksi['alur_kerja_id'];
                    $data['versi'] = $versi;
                    $data['alur_kerja_id'] = $alur_kerja_id;
                    $data['ada_rencana_produksi'] = TRUE;
                    $data['status'] = $status;
                    $data['posisi_mulai'] = TRUE;
                    break;
                case 'TUNDA':
                    $data['naskah'] = [
                        'nojob' => '',
                        'judul' => '',
                        'jilid' => '',
                        'penulis' => '',
                        'standar_pc_id' => ''
                    ];
                    $data['versi'] = '';
                    $data['tombol_aktif'] = FALSE;
                    $data['error1'] = '';
                    $data['alur_kerja_id'] = '';
                    $cari = FALSE;
                    $atur = FALSE;
                    $tambah = FALSE;
                    $tombol_mulai = FALSE;
                    $tombol_selesai = FALSE;
                    $data['posisi_mulai'] = FALSE;
                    $data['ada_rencana_produksi'] = FALSE;
                    $data['lihat'] = FALSE;
                    $cari = $this->input->post('cari');
                    $data['tglmulai'] = 0;
                    $data['status'] = $status;
                    break;
                case 'LANJUT':
                    $nojob = $proses['nojob'];
                    $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
                    $data['tombol_aktif'] = TRUE;

                    $this->db->order_by('last_update DESC');
                    $this->db->where('nojob', $nojob);
                    $naskah_rencana_produksi = $this->db->get('naskah_rencana_produksi')->row_array();

                    $data['lihat'] = TRUE;
                    $id = $naskah_rencana_produksi['id'];
                    $versi = $naskah_rencana_produksi['versi'];
                    $data['versi'] = $versi;
                    $alur_kerja_id = $naskah_rencana_produksi['alur_kerja_id'];
                    $data['alur_kerja_id'] = $alur_kerja_id;
                    $data['ada_rencana_produksi'] = TRUE;
                    $data['posisi_mulai'] = TRUE;
                    $data['status'] = $status;
                    break;
                case 'SELESAI':
                    $data['naskah'] = [
                        'nojob' => '',
                        'judul' => '',
                        'jilid' => '',
                        'penulis' => '',
                        'standar_pc_id' => ''
                    ];
                    $data['versi'] = '';
                    $data['tombol_aktif'] = FALSE;
                    $data['error1'] = '';
                    $data['alur_kerja_id'] = '';
                    $cari = FALSE;
                    $atur = FALSE;
                    $tambah = FALSE;
                    $tombol_mulai = FALSE;
                    $tombol_selesai = FALSE;
                    $data['posisi_mulai'] = FALSE;
                    $data['ada_rencana_produksi'] = FALSE;
                    $data['lihat'] = FALSE;
                    $cari = $this->input->post('cari');
                    $data['tglmulai'] = 0;
                    $data['status'] = $status;
                    break;
            }
        }
        if ($cari) {
            $this->form_validation->set_rules(
                'nojob',
                'No Job',
                'required',
                array(
                    'required'      => '*) tidak ada %s yang dicari.'
                )
            );
            if (!$this->form_validation->run() == FALSE) {
                $status = $this->input->post('status');
                $nojob = $this->input->post('nojob');
                $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
                $data['tombol_aktif'] = TRUE;
                if (!isset($data['naskah'])) {
                    $data['naskah'] = [
                        'nojob' => $nojob,
                        'judul' => '',
                        'jilid' => '',
                        'penulis' => '',
                        'standar_pc_id' => ''
                    ];
                    $data['error1'] = '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            No Job tersebut belum terdaftar
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';
                    $data['tombol_aktif'] = FALSE;
                } else {
                    $this->db->order_by('last_update DESC');
                    $this->db->where('nojob', $nojob);
                    $naskah_rencana_produksi = $this->db->get('naskah_rencana_produksi')->row_array();

                    if (!isset($naskah_rencana_produksi)) {
                        $data['lihat'] = TRUE;
                        $data['tombol_aktif'] = FALSE;
                        $data['ada_rencana_produksi'] = FALSE;
                    } else {
                        $data['lihat'] = TRUE;
                        $id = $naskah_rencana_produksi['id'];
                        $versi = $naskah_rencana_produksi['versi'];
                        $data['versi'] = $versi;
                        $alur_kerja_id = $naskah_rencana_produksi['alur_kerja_id'];
                        $data['alur_kerja_id'] = $alur_kerja_id;
                        $data['ada_rencana_produksi'] = TRUE;
                        $data['posisi_mulai'] = FALSE;
                        $this->db->where('nojob', $nojob);
                        $this->db->where('user_email', $email);
                        $ada = $this->db->get('progres_naskah')->row_array();

                        if ($ada) {
                            $this->db->select_max('id');
                            $this->db->where('nojob', $nojob);
                            $this->db->where('user_email', $email);
                            $id = $this->db->get('progres_naskah')->row()->id;
                            $status = $this->db->get_where('progres_naskah', ['id' => $id])->row()->status;
                            $data['status'] = $status;
                        } else {
                            $status = "";
                            $data['status'] = $status;
                        }
                    }
                }
            }
        }
        $tombol_mulai = $this->input->post('tombol_mulai');
        if ($tombol_mulai) {

            $this->form_validation->set_rules(
                'nama_objek_kerja',
                'Nama Objek Kerja',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'nama_level_kerja',
                'Nama Level Kerja',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $nojob = $this->input->post('nojob');
                $status = $this->input->post('status');

                $nama_objek_kerja = $this->input->post('nama_objek_kerja');
                $nama_level_kerja = $this->input->post('nama_level_kerja');
                $level_kerja = $this->db->get_where('level_kerja', ['nama_level_kerja' => $nama_level_kerja])->row_array();
                $level_kerja_id = $level_kerja['level_kerja_id'];
                $inisial_level_kerja = $level_kerja['inisial_level_kerja'];
                $naskah_rencana_produksi_id = $this->input->post('naskah_rencana_produksi_id');
                $alur_kerja_id = $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row()->alur_kerja_id;
                $versi = $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row()->versi;

                $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                $this->db->where('inisial_level_kerja', $inisial_level_kerja);
                $this->db->where('alur_kerja_id', $alur_kerja_id);
                $detail_alur_kerja = $this->db->get('detail_alur_kerja')->row_array();


                $detail_alur_kerja_id = $detail_alur_kerja['detail_alur_kerja_id'];
                $urutan = $detail_alur_kerja['urutan'];
                $urutan_sebelumnya = $urutan - 1;

                if ($urutan_sebelumnya != 0) {
                    $this->db->where('alur_kerja_id', $alur_kerja_id);
                    $this->db->where('urutan', $urutan_sebelumnya);
                    $this->db->where('nama_objek_kerja', $nama_objek_kerja);

                    $detail_alur_kerja_sebelumnya = $this->db->get('detail_alur_kerja')->row_array();
                    $detail_alur_kerja_id_sebelumnya = $detail_alur_kerja_sebelumnya['detail_alur_kerja_id'];
                    $inisial_level_kerja_sebelumnya =  $detail_alur_kerja_sebelumnya['inisial_level_kerja'];

                    $this->db->where('inisial_level_kerja', $inisial_level_kerja_sebelumnya);
                    $nama_level_kerja_sebelumnya = $this->db->get('level_kerja')->row()->nama_level_kerja;

                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id_sebelumnya);
                    $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                    $status_sebelumnya = $this->db->get('detail_rencana_produksi')->row()->status;


                    if ($status_sebelumnya != 'SELESAI') {
                        $data['error1'] = '
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    ' . 'Tidak bisa diproses: ' . $nama_level_kerja_sebelumnya . '  untuk ' . $nama_objek_kerja . ' belum selesai ' . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            ';
                        $tombol_mulai = FALSE;
                    } else {
                        $this->db->where('inisial_level_kerja', $inisial_level_kerja);
                        $this->db->where('alur_kerja_id', $alur_kerja_id);
                        $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                        $nama_unit_kerja_daftar = $this->db->get('detail_alur_kerja')->row()->nama_unit_kerja;


                        $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                        $status_pilihan_ini = $this->db->get('detail_rencana_produksi')->row()->status;

                        if ($status_pilihan_ini == 'SELESAI') {
                            $data['error1'] = '
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            ' . 'Tidak bisa diproses: ' . $nama_level_kerja . ' untuk ' . $nama_objek_kerja . ' sudah selesai ' . '
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    ';
                            $tombol_mulai = FALSE;
                        } else {
                            $urutan = $detail_alur_kerja['urutan'];
                            $mulai = now('Asia/Jakarta');
                            $mulai_real = date('d-m-Y', $mulai);

                            $last_update = now('Asia/Jakarta');
                            $user_email = $email;
                            $level_id = $this->db->get_where('user', ['email' => $user_email])->row()->level_id;
                            $nama_unit_kerja = $this->db->get_where('user_level', ['level_id' => $level_id])->row()->nama_unit_kerja;
                            $detail_alur_kerja_id = $alur_kerja_id . $nama_objek_kerja . $urutan;


                            $this->db->where('nojob', $nojob);
                            $this->db->where('user_email', $user_email);
                            $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                            $this->db->where('nama_level_kerja', $nama_level_kerja);
                            $this->db->where('nama_unit_kerja', $nama_unit_kerja);
                            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                            $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                            $this->db->where('versi', $versi);
                            $this->db->set('is_active', 0);
                            $this->db->update('progres_naskah');

                            $this->db->set('nojob', $nojob);
                            $this->db->set('user_email', $user_email);
                            $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                            $this->db->set('nama_level_kerja', $nama_level_kerja);
                            $this->db->set('nama_unit_kerja', $nama_unit_kerja);
                            $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                            $this->db->set('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                            $this->db->set('versi', $versi);
                            $this->db->set('mulai_real', $mulai_real);
                            $this->db->set('mulai_real_int', now('Asia/Jakarta'));
                            $this->db->set('last_update', $last_update);
                            $this->db->set('status', $status);
                            $this->db->set('is_active', 1);
                            $this->db->insert('progres_naskah');

                            $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                            $mulai_real_data = $this->db->get('detail_rencana_produksi')->row()->mulai_real;

                            if ($mulai_real_data == '') {
                                $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                $this->db->where('is_active', 1);
                                $this->db->set('mulai_real', $mulai_real);
                                $this->db->set('mulai_real_int', now('Asia/Jakarta'));
                                $this->db->set('status', 'MULAI');
                                $this->db->set('last_update', $last_update);
                                $this->db->set('update_oleh', $email);
                                $this->db->update('detail_rencana_produksi');
                            } else {
                                $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                $this->db->where('is_active', 1);
                                $this->db->set('status', $status);
                                $this->db->set('last_update', $last_update);
                                $this->db->set('update_oleh', $email);
                                $this->db->update('detail_rencana_produksi');
                            }

                            $data['baru'] = [
                                'nama_objek_kerja' => $nama_objek_kerja,
                                'nama_level_kerja' => $nama_level_kerja
                            ];

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
                                                Anda ' . $status . ' ' . $nama_level_kerja . ' No Job ' . $nojob . '
                                            </div>
                                        </div>
                                    </div>'
                            );
                        }
                    }
                } else {
                    $this->db->where('inisial_level_kerja', $inisial_level_kerja);
                    $this->db->where('alur_kerja_id', $alur_kerja_id);
                    $nama_unit_kerja_daftar = $this->db->get('detail_alur_kerja')->row()->nama_unit_kerja;


                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                    $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                    $status_pilihan_ini = $this->db->get('detail_rencana_produksi')->row()->status;

                    if ($status_pilihan_ini == 'SELESAI') {
                        $data['error1'] = "Tidak bisa diproses: " . $nama_level_kerja . " untuk " . $nama_objek_kerja . " sudah selesai";
                        $data['error1'] = '
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            ' . 'Tidak bisa diproses: ' . $nama_level_kerja . ' untuk ' . $nama_objek_kerja . ' sudah selesai' . '
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                ';
                        $tombol_mulai = FALSE;
                    } else {
                        $urutan = $detail_alur_kerja['urutan'];
                        $mulai = now('Asia/Jakarta');
                        $mulai_real = date('d-m-Y', $mulai);

                        $last_update = now('Asia/Jakarta');
                        $user_email = $email;
                        $level_id = $this->db->get_where('user', ['email' => $user_email])->row()->level_id;
                        $nama_unit_kerja = $this->db->get_where('user_level', ['level_id' => $level_id])->row()->nama_unit_kerja;
                        $detail_alur_kerja_id = $alur_kerja_id . $nama_objek_kerja . $urutan;


                        $this->db->where('nojob', $nojob);
                        $this->db->where('user_email', $user_email);
                        $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                        $this->db->where('nama_level_kerja', $nama_level_kerja);
                        $this->db->where('nama_unit_kerja', $nama_unit_kerja);
                        $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                        $this->db->where('versi', $versi);

                        $this->db->set('is_active', 0);
                        $this->db->update('progres_naskah');

                        $this->db->set('nojob', $nojob);
                        $this->db->set('user_email', $user_email);
                        $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                        $this->db->set('nama_level_kerja', $nama_level_kerja);
                        $this->db->set('nama_unit_kerja', $nama_unit_kerja);
                        $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $this->db->set('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                        $this->db->set('versi', $versi);
                        $this->db->set('mulai_real', $mulai_real);
                        $this->db->set('mulai_real_int', now('Asia/Jakarta'));
                        $this->db->set('last_update', $last_update);
                        $this->db->set('status', $status);
                        $this->db->set('is_active', 1);
                        $this->db->insert('progres_naskah');

                        $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                        $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $mulai_real_data = $this->db->get('detail_rencana_produksi')->row()->mulai_real;

                        if ($mulai_real_data == '') {
                            $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                            $this->db->set('mulai_real', $mulai_real);
                            $this->db->where('is_active', 1);
                            $this->db->set('mulai_real_int', now('Asia/Jakarta'));
                            $this->db->set('status', 'MULAI');
                            $this->db->set('last_update', $last_update);
                            $this->db->set('update_oleh', $email);
                            $this->db->update('detail_rencana_produksi');
                        } else {
                            $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                            $this->db->where('is_active', 1);
                            $this->db->set('status', $status);
                            $this->db->set('last_update', $last_update);
                            $this->db->set('update_oleh', $email);
                            $this->db->update('detail_rencana_produksi');
                        }

                        $data['baru'] = [
                            'nama_objek_kerja' => $nama_objek_kerja,
                            'nama_level_kerja' => $nama_level_kerja
                        ];

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
                                                Anda ' . $status . ' ' . $nama_level_kerja . ' No Job ' . $nojob . '
                                            </div>
                                        </div>
                                    </div>'
                        );
                    }
                }
            }
        }

        $tombol_selesai = $this->input->post('tombol_selesai');
        if ($tombol_selesai) {
            $nojob = $this->input->post('nojob');
            $status = $this->input->post('status');
            $nama_objek_kerja = $this->input->post('nama_objek_kerja');
            $nama_level_kerja = $this->input->post('nama_level_kerja');
            $level_kerja = $this->db->get_where('level_kerja', ['nama_level_kerja' => $nama_level_kerja])->row_array();
            $level_kerja_id = $level_kerja['level_kerja_id'];
            $inisial_level_kerja = $level_kerja['inisial_level_kerja'];
            $naskah_rencana_produksi_id = $this->input->post('naskah_rencana_produksi_id');
            $alur_kerja_id = $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row()->alur_kerja_id;
            $versi = $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row()->versi;
            $this->db->where('nama_objek_kerja', $nama_objek_kerja);
            $this->db->where('inisial_level_kerja', $inisial_level_kerja);
            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $detail_alur_kerja = $this->db->get('detail_alur_kerja')->row_array();
            $urutan = $detail_alur_kerja['urutan'];
            $selesai = now('Asia/Jakarta');
            $selesai_real = date('d-m-Y', $selesai);
            $last_update = now('Asia/Jakarta');
            $user_email = $email;
            $detail_alur_kerja_id = $alur_kerja_id . $nama_objek_kerja . $urutan;

            if ($status == "LANJUT") {

                $this->db->where('nojob', $nojob);
                $this->db->where('user_email', $user_email);
                $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                $this->db->where('nama_level_kerja', $nama_level_kerja);
                $this->db->where('nama_unit_kerja', $nama_unit_kerja);
                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                $this->db->where('versi', $versi);
                $this->db->where('status', 'TUNDA');
                $this->db->set('status', 'TUNDA-LANJUT');
                $this->db->set('is_active', 0);
                $this->db->update('progres_naskah');
            }

            $this->db->where('nojob', $nojob);
            $this->db->where('user_email', $user_email);
            $this->db->where('nama_objek_kerja', $nama_objek_kerja);
            $this->db->where('nama_level_kerja', $nama_level_kerja);
            $this->db->where('nama_unit_kerja', $nama_unit_kerja);
            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
            $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
            $this->db->set('last_update', $last_update);
            $this->db->set('is_active', 0);
            $this->db->update('progres_naskah');

            $this->db->set('nojob', $nojob);
            $this->db->set('user_email', $user_email);
            $this->db->set('nama_objek_kerja', $nama_objek_kerja);
            $this->db->set('nama_level_kerja', $nama_level_kerja);
            $this->db->set('nama_unit_kerja', $nama_unit_kerja);
            $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
            $this->db->set('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
            $this->db->set('versi', $versi);
            if ($status == 'SELESAI') {
                $this->db->set('selesai_real', $selesai_real);
                $this->db->set('selesai_real_int', now('Asia/Jakarta'));
                $this->db->set('halaman', $this->input->post('halaman'));
            }
            $this->db->set('status', $status);
            $this->db->set('last_update', $last_update);
            $this->db->set('is_active', 1);
            $this->db->insert('progres_naskah');

            $this->db->where('nojob', $nojob);
            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
            $this->db->where('is_active', 1);
            $this->db->where('status !=', 'SELESAI');
            $banyak_blm_selesai = $this->db->get('progres_naskah')->num_rows();

            $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);

            if ($status == 'SELESAI') {
                if ($banyak_blm_selesai == 0) {
                    $this->db->set('selesai_real', $selesai_real);
                    $this->db->set('selesai_real_int', now('Asia/Jakarta'));
                    $this->db->set('status', $status);
                }
            }
            $this->db->set('update_oleh', $email);
            $this->db->update('detail_rencana_produksi');

            if ($status == 'SELESAI') {
                if ($banyak_blm_selesai == 0) {
                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                    $this->db->where('nama_objek_kerja', $nama_objek_kerja);

                    $detail_alur_kerja = $this->db->get('detail_alur_kerja')->row_array();
                    $alur_kerja_id = $detail_alur_kerja['alur_kerja_id'];
                    $urutan = $detail_alur_kerja['urutan'];
                    $next_urutan = $urutan + 1;

                    $this->db->where('alur_kerja_id', $alur_kerja_id);
                    $this->db->where('urutan', $next_urutan);
                    $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                    $ada = $this->db->get('detail_alur_kerja')->row_array();

                    if (isset($ada)) {
                        $detail_alur_kerja_id_next = $ada['detail_alur_kerja_id'];
                        $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                        $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id_next);
                        $this->db->where('is_active', 1);

                        $this->db->set('antre', $selesai_real);
                        $this->db->set('status', 'ANTRE');
                        $this->db->set('update_oleh', $email);
                        $this->db->update('detail_rencana_produksi');
                    } else {


                        $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                        $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $this->db->where('is_active', 1);
                        $this->db->set('antre', $selesai_real);
                        $this->db->set('status', 'FINISH');
                        $this->db->set('update_oleh', $email);
                        $this->db->update('detail_rencana_produksi');
                    }
                }
            }


            $this->session->set_flashdata(
                'pesan',
                '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">
                                                <trong class="mr-auto">Sukses</trong>
                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Anda ' . $status . ' ' . $nama_level_kerja . ' No Job ' . $nojob . '
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        if ($tombol_mulai or $tombol_selesai) {

            $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
            $this->db->select_max('versi');
            $versi = $this->db->get_where('naskah_rencana_produksi', ['nojob' => $nojob])->row()->versi;
            $data['naskah_rencana_produksi_id'] = $this->db->get_where('naskah_rencana_produksi', ['nojob' => $nojob, 'versi' => $versi])->row()->naskah_rencana_produksi_id;
            $data['tampil'] = TRUE;

            $data['baru'] = [
                'nama_objek_kerja' => $nama_objek_kerja,
                'inisial_level_kerja' => $inisial_level_kerja
            ];
        }

        $notif = FALSE;
        $notif = $this->input->post('notif');

        if ($notif) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('proses/progres_naskah_baru', $data);
            $this->load->view('templates/footer');
        } else {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('proses/progres_naskah', $data);
            $this->load->view('templates/footer');
        }
    }

    public function progres_naskah_baru()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Job Baru';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['nojob'] = $this->input->post('nojob');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('proses/progres_naskah_baru', $data);
        $this->load->view('templates/footer');
    }



    public function kirim_naskah()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Kirim Naskah';

        $data['teks'] = "Kirim";
        $kirim2 = FALSE;
        $bagi = FALSE;
        $kirim2 = $this->input->post('kirim2');
        $bagi = $this->input->post('bagi');


        $data['kirim2'] = $kirim2;
        $data['bagi'] = $bagi;
        if ($bagi) {
            $data['title'] = 'Bagi Naskah';
            $data['teks'] = "Bagi";
            $data['pic_real'] = $this->input->post('pic_real');
        }

        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $id = $this->input->post('id');
        $detail_rencana_produksi = $this->db->get_where('detail_rencana_produksi', ['id' => $id])->row_array();

        $naskah_rencana_produksi_id = $detail_rencana_produksi['naskah_rencana_produksi_id'];

        $nojob = $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row()->nojob;
        $judul = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->judul;
        $jilid = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->jilid;
        $penulis = $this->db->get_where('naskah', ['nojob' => $nojob])->row()->penulis;

        $detail_alur_kerja_id = $detail_rencana_produksi['detail_alur_kerja_id'];
        $detail_alur_kerja = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id' => $detail_alur_kerja_id])->row_array();
        $nama_objek_kerja = $detail_alur_kerja['nama_objek_kerja'];
        $nama_level_kerja = $this->db->get_where('level_kerja', ['inisial_level_kerja' => $detail_alur_kerja['inisial_level_kerja']])->row()->nama_level_kerja;
        $pic_email = $detail_rencana_produksi['pic'];
        if ($pic_email == 'tentatif') {
            $nama_pic = "Tentatif";
        } else {
            $nama_pic = $this->db->get_where('user', ['email' => $pic_email])->row()->nama;
        }
        $nama_unit_kerja = $detail_rencana_produksi['nama_unit_kerja'];
        $level_id = $this->db->get_where('user_level', ['nama_unit_kerja' => $nama_unit_kerja])->row()->level_id;
        $user_unit_kerja = $this->db->get_where('user', ['level_id' => $level_id])->result_array();

        $data['rencana'] = [
            'nojob' => $nojob,
            'judul' => $judul,
            'jilid' => $jilid,
            'penulis' => $penulis,
            'id' => $id,
            'nama_objek_kerja' => $nama_objek_kerja,
            'nama_level_kerja' => $nama_level_kerja,
            'pic_email' => $pic_email,
            'nama_pic' => $nama_pic,
            'nama_unit_kerja' => $nama_unit_kerja

        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('proses/kirim_naskah', $data);
        $this->load->view('templates/footer');
    }

    public function order_cetak()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Daftar Order Cetak';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $nonaktifkan = FALSE;
        $nonaktifkan = $this->input->post('nonaktifkan');
        if ($nonaktifkan) {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->set('is_active', 0);
            $this->db->update('order_cetak');
        }
        $aktifkan = FALSE;
        $aktifkan = $this->input->post('aktifkan');
        if ($aktifkan) {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->set('is_active', 1);
            $this->db->update('order_cetak');
        }

        $dari_daftar_buku = FALSE;
        $dari_daftar_buku = $this->input->post('dari_daftar_buku');

        if ($dari_daftar_buku) {
            $data['kode'] = $this->input->post('kode');
        }
        $data['dari_daftar_buku'] =  $dari_daftar_buku;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('proses/order_cetak', $data);
        $this->load->view('templates/footer');
    }

    public function order_cetak_baru()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Order Cetak Baru';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $order = FALSE;
        $cari = FALSE;
        $data['tombol_order'] = FALSE;
        $data['error1'] = '';

        $data['buku'] = [
            'kode' => '',
            'judul' => '',
            'jilid' => '',
            'penulis' => '',
        ];

        $cari = $this->input->post('cari');
        if ($cari) {
            $kode = $this->input->post('kode');
            $data['buku'] = $this->db->get_where('buku', ['kode' => $kode])->row_array();
            if (isset($data['buku'])) {
                $data['tombol_order'] = TRUE;
            } else {
                $data['buku'] = [
                    'kode' => '',
                    'judul' => '',
                    'jilid' => '',
                    'penulis' => '',
                ];
                $data['error1'] = '<div class="alert alert-danger"  role="alert">
                                        Kode tersebut belum terdaftar!
                                    </div>';
            }
        }
        $order_sukses = FALSE;
        $order = $this->input->post('order');
        if ($order) {
            $this->form_validation->set_rules(
                'no_reff',
                'No Reff',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'nama_pemasok',
                'Pemasok',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'tiras',
                'Tiras',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $kode = $this->input->post('kode');
                $tgl_po = $this->input->post('tgl_po');
                $no_reff = $this->input->post('no_reff');
                $nama_pemasok = $this->input->post('nama_pemasok');
                $tiras = $this->input->post('tiras');

                $this->db->set('kode', $kode);
                $this->db->set('no_po', $no_reff);
                $this->db->set('order_tgl', strtotime($tgl_po));
                $this->db->set('qty', $tiras);
                $this->db->set('kode', $kode);
                $this->db->set('nama_pemasok', $nama_pemasok);
                $this->db->set('order_oleh', $email);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('order_cetak');
                $order_sukses = TRUE;
            }
        }
        $dari_daftar_buku = FALSE;
        $dari_daftar_buku = $this->input->post('dari_daftar_buku');

        $data['dari_daftar_buku'] =  $dari_daftar_buku;

        if ($order_sukses) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('proses/order_cetak', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('proses/order_cetak_baru', $data);
            $this->load->view('templates/footer');
        }
    }

    public function transaksi_stok_keluar()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Transaksi Stok Keluar';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['error1'] = '';
        $data['buku'] = [
            'kode' => '',
            'judul' => '',
            'jilid' => '',
            'penulis' => ''

        ];
        $cari = FALSE;
        $cari = $this->input->post('cari');
        if ($cari) {
            $kode = $this->input->post('kode');
            $data['buku'] = $this->db->get_where('buku', ['kode' => $kode])->row_array();
            if (!isset($data['buku'])) {

                $data['buku'] = [
                    'kode' =>  $kode,
                    'judul' => '',
                    'jilid' => '',
                    'penulis' => ''
                ];
                $data['error1'] = "*) Kode tersebut belum terdaftar";
                $cari = FALSE;
                $tambah = FALSE;
            }
        }


        $tambah = FALSE;
        $tambah = $this->input->post('tambah');
        if ($tambah) {

            $this->form_validation->set_rules(
                'gudang_id',
                'Nama Gudang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            $this->form_validation->set_rules(
                'pelanggan_id',
                'Nama pelanggan',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            $this->form_validation->set_rules(
                'tipe_buku_keluar_id',
                'Tipe Buku Keluar',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'qty',
                'Qty',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );




            if (!$this->form_validation->run() == FALSE) {

                $kode = $this->input->post('kode');
                $data['buku'] = $this->db->get_where('buku', ['kode' => $kode])->row_array();

                $gudang_id = $this->input->post('gudang_id');
                $gudang_id = $this->input->post('gudang_id');
                $pelanggan_id = $this->input->post('pelanggan_id');

                $tipe_buku_keluar_id = $this->input->post('tipe_buku_keluar_id');

                $tanggal_transaksi = $this->input->post('tanggal_transaksi');
                $qty = $this->input->post('qty');
                $ada = $this->db->get_where('transaksi_stok', ['kode' => $kode, 'gudang_id' => $gudang_id])->num_rows();
                if ($ada != 0) {
                    $this->db->select_max('last_update');
                    $this->db->where('kode', $kode);
                    $this->db->where('gudang_id', $gudang_id);
                    $last_update = $this->db->get('transaksi_stok')->row()->last_update;


                    $this->db->where('last_update', $last_update);
                    $this->db->where('kode', $kode);
                    $this->db->where('gudang_id', $gudang_id);

                    $stok_akhir = $this->db->get('transaksi_stok')->row()->stok_akhir;
                } else {
                    $stok_akhir = 0;
                }
                $stok_akhir = $stok_akhir - $qty;
                $this->db->set('kode', $kode);
                $this->db->set('gudang_id', $gudang_id);
                $this->db->set('tanggal', $tanggal_transaksi);
                $this->db->set('masuk_keluar', 'KELUAR');
                $this->db->set('qty', $qty);
                $this->db->set('pemasok_pelanggan_id', $pelanggan_id);
                $this->db->set('tipe_transaksi_id', $tipe_buku_keluar_id);
                $this->db->set('stok_akhir', $stok_akhir);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('transaksi_stok');
                $this->db->order_by('last_update DESC');

                $id = $this->db->get('transaksi_stok')->row()->id;
                $nama_pelanggan = $this->db->get_where('pelanggan', ['id' => $pelanggan_id])->row()->nama_pelanggan;
                $nama_gudang = $this->db->get_where('gudang', ['id' => $gudang_id])->row()->nama_gudang;
                $nama_tipe_buku_keluar = $this->db->get_where('tipe_buku_keluar', ['id' => $tipe_buku_keluar_id])->row()->nama_tipe_buku_keluar;

                $data['rekap'] = [
                    'nama_gudang' => $nama_gudang,
                    'tanggal' => $tanggal_transaksi,
                    'id' => $id,
                    'nama_tipe_buku_keluar' => $nama_tipe_buku_keluar,
                    'nama_pelanggan' => $nama_pelanggan,
                    'qty' => $qty,
                    'stok_akhir' => $stok_akhir
                ];
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">
                                                <trong class="mr-auto">Sukses</trong>
                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                            Transaksi Buku Keluar
                                            </div>
                                        </div>
                                    </div>'
                );
                $cari = TRUE;

                $gudang_id = $this->input->post('gudang_id');
                $dari_tgl = date('d-m-Y');
                $sampai_tgl = date('d-m-Y');

                $dari_tgl_int = strtotime($dari_tgl . ' 00:00');
                $sampai_tgl_int = strtotime($sampai_tgl . ' 24:00');

                $this->db->where('masuk_keluar', 'KELUAR');
                $this->db->where('gudang_id', $gudang_id);
                $this->db->where('last_update >=', $dari_tgl_int);
                $this->db->where('last_update <=', $sampai_tgl_int);
                $this->db->order_by('last_update DESC');
                $data['kartu_stok'] = $this->db->get('transaksi_stok')->result_array();

                $data['nama_gudang'] = $this->db->get_where('gudang', ['id' => $gudang_id])->row()->nama_gudang;

                $data['buku_keluar'] = [
                    'gudang_id' => $gudang_id,
                    'dari_tgl' => $dari_tgl,
                    'sampai_tgl' => $sampai_tgl

                ];
                $data['tampilkan'] = TRUE;
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('laporan/buku_keluar', $data);
                $this->load->view('templates/footer');
            }
        }
        if (!$tambah) {



            $data['tambah'] = $tambah;
            $data['cari'] = $cari;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('proses/transaksi_stok_keluar', $data);
            $this->load->view('templates/footer');
        }
    }

    public function transaksi_stok_masuk()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Transaksi Stok Masuk';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['error1'] = '';

        $data['pencarian'] = [
            'kode' => '',
            'gudang_id' => '',
            'pemasok_id' => '',
            'tipe_buku_masuk_id' => '',
            'tanggal_transaksi' => date('d-m-Y')
        ];
        $data['buku'] = [
            'kode' => '',
            'judul' => '',
            'jilid' => '',
            'penulis' => ''

        ];
        $cari = FALSE;
        $cari = $this->input->post('cari');
        if ($cari) {
            $this->form_validation->set_rules(
                'kode',
                'Kode',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'gudang_id',
                'Nama Gudang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            $this->form_validation->set_rules(
                'pemasok_id',
                'Nama Pemasok',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            $this->form_validation->set_rules(
                'tipe_buku_masuk_id',
                'Tipe Buku Masuk',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            if (!$this->form_validation->run() == FALSE) {
                $gudang_id = $this->input->post('gudang_id');
                $pemasok_id = $this->input->post('pemasok_id');
                $tipe_buku_masuk_id = $this->input->post('tipe_buku_masuk_id');
                $tanggal_transaksi = $this->input->post('tanggal_transaksi');

                $kode = $this->input->post('kode');
                $kode = $this->input->post('kode');
                $data['buku'] = $this->db->get_where('buku', ['kode' => $kode])->row_array();
                $data['pencarian'] = [
                    'kode' => $kode,
                    'gudang_id' => $gudang_id,
                    'pemasok_id' => $pemasok_id,
                    'tipe_buku_masuk_id' => $tipe_buku_masuk_id,
                    'tanggal_transaksi' => $tanggal_transaksi
                ];
                if (!isset($data['buku'])) {
                    $data['buku'] = [
                        'kode' =>  $kode,
                        'judul' => '',
                        'jilid' => '',
                        'penulis' => ''
                    ];
                    $data['error1'] = "*) Kode tersebut belum terdaftar";
                    $cari = FALSE;
                    $tambah = FALSE;
                } else {
                    $cari = TRUE;
                    $tambah = FALSE;
                }
            }
        }

        $tambah = FALSE;
        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $cari = TRUE;
            $gudang_id = $this->input->post('gudang_id');
            $pemasok_id = $this->input->post('pemasok_id');
            $tipe_buku_masuk_id = $this->input->post('tipe_buku_masuk_id');
            $tanggal_transaksi = $this->input->post('tanggal_transaksi');

            $kode = $this->input->post('kode');
            $kode = $this->input->post('kode');
            $data['buku'] = $this->db->get_where('buku', ['kode' => $kode])->row_array();
            $data['pencarian'] = [
                'kode' => $kode,
                'gudang_id' => $gudang_id,
                'pemasok_id' => $pemasok_id,
                'tipe_buku_masuk_id' => $tipe_buku_masuk_id,
                'tanggal_transaksi' => $tanggal_transaksi
            ];
            $this->form_validation->set_rules(
                'qty',
                'Qty',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            if (!$this->form_validation->run() == FALSE) {

                $kode = $this->input->post('kode');
                $data['buku'] = $this->db->get_where('buku', ['kode' => $kode])->row_array();

                $gudang_id = $this->input->post('gudang_id');
                $pemasok_id = $this->input->post('pemasok_id');
                $id_reff = $this->input->post('id_reff');
                $no_reff = $this->input->post('no_reff');

                $tipe_buku_masuk_id = $this->input->post('tipe_buku_masuk_id');

                $tanggal_transaksi = $this->input->post('tanggal_transaksi');
                $qty = $this->input->post('qty');
                $ada = $this->db->get_where('transaksi_stok', ['kode' => $kode, 'gudang_id' => $gudang_id])->num_rows();
                if ($ada != 0) {
                    $this->db->select_max('last_update');
                    $this->db->where('kode', $kode);
                    $this->db->where('gudang_id', $gudang_id);
                    $last_update = $this->db->get('transaksi_stok')->row()->last_update;


                    $this->db->where('last_update', $last_update);
                    $this->db->where('kode', $kode);
                    $this->db->where('gudang_id', $gudang_id);

                    $stok_akhir = $this->db->get('transaksi_stok')->row()->stok_akhir;
                } else {
                    $stok_akhir = 0;
                }
                $stok_akhir = $stok_akhir + $qty;
                $this->db->set('kode', $kode);
                $this->db->set('id_reff', $id_reff);
                $this->db->set('no_reff', $no_reff);

                $this->db->set('gudang_id', $gudang_id);
                $this->db->set('tanggal', $tanggal_transaksi);
                $this->db->set('masuk_keluar', 'MASUK');
                $this->db->set('qty', $qty);
                $this->db->set('pemasok_pelanggan_id', $pemasok_id);
                $this->db->set('tipe_transaksi_id', $tipe_buku_masuk_id);
                $this->db->set('stok_akhir', $stok_akhir);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('transaksi_stok');

                $this->db->order_by('last_update DESC');

                $id = $this->db->get('transaksi_stok')->row()->id;
                $nama_pemasok = $this->db->get_where('pemasok', ['id' => $pemasok_id])->row()->nama_pemasok;
                $nama_gudang = $this->db->get_where('gudang', ['id' => $gudang_id])->row()->nama_gudang;
                $nama_tipe_buku_masuk = $this->db->get_where('tipe_buku_masuk', ['id' => $tipe_buku_masuk_id])->row()->nama_tipe_buku_masuk;

                $data['rekap'] = [
                    'nama_gudang' => $nama_gudang,
                    'tanggal' => $tanggal_transaksi,
                    'id' => $id,
                    'nama_tipe_buku_masuk' => $nama_tipe_buku_masuk,
                    'nama_pemasok' => $nama_pemasok,
                    'qty' => $qty,
                    'stok_akhir' => $stok_akhir
                ];
                $this->session->set_flashdata(
                    'pesan',
                    '<div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
                                        <div id="liveToast" class="toast hide text-white bg-success" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                                            <div class="toast-header">
                                                <trong class="mr-auto">Sukses</trong>
                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                            Transaksi Buku Masuk
                                            </div>
                                        </div>
                                    </div>'
                );
                $cari = TRUE;

                $gudang_id = $this->input->post('gudang_id');
                $dari_tgl = date('d-m-Y');
                $sampai_tgl = date('d-m-Y');

                $dari_tgl_int = strtotime($dari_tgl . ' 00:00');
                $sampai_tgl_int = strtotime($sampai_tgl . ' 24:00');

                $this->db->where('masuk_keluar', 'MASUK');
                $this->db->where('gudang_id', $gudang_id);
                $this->db->where('last_update >=', $dari_tgl_int);
                $this->db->where('last_update <=', $sampai_tgl_int);
                $this->db->order_by('last_update DESC');
                $data['kartu_stok'] = $this->db->get('transaksi_stok')->result_array();

                $data['nama_gudang'] = $this->db->get_where('gudang', ['id' => $gudang_id])->row()->nama_gudang;

                $data['buku_masuk'] = [
                    'gudang_id' => $gudang_id,
                    'dari_tgl' => $dari_tgl,
                    'sampai_tgl' => $sampai_tgl

                ];
                $data['tampilkan'] = TRUE;


                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
                $this->load->view('templates/topbar', $data);
                $this->load->view('laporan/buku_masuk', $data);
                $this->load->view('templates/footer');
            }
        }


        if (!$tambah) {

            $data['tambah'] = $tambah;
            $data['cari'] = $cari;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('proses/transaksi_stok_masuk', $data);
            $this->load->view('templates/footer');
        }
    }
}
