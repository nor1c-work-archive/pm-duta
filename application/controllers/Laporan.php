<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function job()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Laporan Job';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['naskah'] = [
            'nojob' => '',
            'judul' => '',
            'jilid' => '',
            'penulis' => '',
            'standar_pc_id' => ''
        ];

        $data['tombol_aktif'] = FALSE;
        $data['error1'] = '';
        $data['alur_kerja_id'] = '';
        $cari = FALSE;

        $cari = $this->input->post('cari');

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
                $nojob = $this->input->post('nojob');
                $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();
                if (!isset($data['naskah'])) {
                    $data['naskah'] = [
                        'nojob' => $nojob,
                        'judul' => '',
                        'jilid' => '',
                        'penulis' => '',
                        'standar_pc_id' => ''
                    ];
                    $data['tampil'] = FALSE;
                    $data['error1'] = "*) No Job tersebut belum terdaftar";
                } else {
                    $this->db->select_max('versi');
                    $versi = $this->db->get_where('naskah_rencana_produksi', ['nojob' => $nojob])->row()->versi;

                    if (!isset($versi)) {
                        $data['tampil'] = FALSE;
                        $data['error1'] = "*) Belum ada rencana produksi No job tersebut";
                    } else {
                        $data['naskah'] = $this->db->get_where('naskah', ['nojob' => $nojob])->row_array();


                        $naskah_rencana_produksi_id = $this->db->get_where('naskah_rencana_produksi', ['nojob' => $nojob, 'versi' => $versi])->row()->naskah_rencana_produksi_id;

                        $this->db->where('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
                        $detail_rencana_produksi = $this->db->get('detail_rencana_produksi')->result_array();

                        foreach ($detail_rencana_produksi as $drp) : {
                                $detail_alur_kerja_id = $drp['detail_alur_kerja_id'];
                                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                $detail_alur_kerja = $this->db->get('detail_alur_kerja')->row_array();
                                // $nama_objek_kerja = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id', $detail_alur_kerja_id])->row()->nama_objek_kerja;
                                //  $urutan = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id', $detail_alur_kerja_id])->row()->urutan;
                                $nama_objek_kerja = $detail_alur_kerja['nama_objek_kerja'];
                                $urutan = $detail_alur_kerja['urutan'];



                                $this->db->where('nojob', $nojob);
                                $this->db->group_by('user_email');
                                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                $banyak_pic = $this->db->get('progres_naskah')->num_rows();
                                if ($banyak_pic == 0) {
                                    $total_durasi_real = 0;
                                } else {
                                    $this->db->where('nojob', $nojob);
                                    $this->db->group_by('user_email');
                                    $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                    $pic_group = $this->db->get('progres_naskah')->result_array();
                                    $total_durasi_real = 0;
                                    foreach ($pic_group as $pg) : {
                                            $user_email = $pg['user_email'];
                                            $this->db->where('user_email', $user_email);
                                            $this->db->select_max('mulai_real_int');

                                            $this->db->where('nojob', $nojob);
                                            $this->db->group_by('user_email');
                                            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                            $progres_naskah = $this->db->get('progres_naskah')->row_array();
                                            $mulai_real_int = $progres_naskah['mulai_real_int'];


                                            $this->db->where('user_email', $user_email);

                                            $this->db->select_max('selesai_real_int');
                                            $this->db->where('nojob', $nojob);
                                            $this->db->group_by('user_email');
                                            $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id);
                                            $progres_naskah = $this->db->get('progres_naskah')->row_array();

                                            $selesai_real_int = $progres_naskah['selesai_real_int'];
                                            if ($selesai_real_int == 0) {
                                                $selesai_real_int = now('Asia/Jakarta');
                                            }

                                            $selesai_real = date('d-m-Y', $selesai_real_int);
                                            $mulai_real = date('d-m-Y', $mulai_real_int);

                                            $this->db->where('tanggal >=', $mulai_real_int);
                                            $this->db->where('tanggal <=', $selesai_real_int);
                                            $libur_real = $this->db->count_all_results('hari_libur');

                                            $firstDate  = new DateTime(date('d-m-Y', $mulai_real_int));
                                            $secondDate = new DateTime(date('d-m-Y', $selesai_real_int));
                                            $intvl = $firstDate->diff($secondDate);
                                            $durasi_bruto = $intvl->days;
                                            $durasi_real = $durasi_bruto  - $libur_real + 1;

                                            if ($mulai_real_int == 0) {
                                                $durasi_real = 0;
                                            }
                                        }

                                        $total_durasi_real = $total_durasi_real + $durasi_real;

                                    endforeach;
                                }
                                $data['rekap'][$detail_alur_kerja_id] = [
                                    'nama_objek_kerja' => $nama_objek_kerja,
                                    'urutan' => $urutan,
                                    'banyak_pic' => $banyak_pic,
                                    'total_durasi_real' => round($total_durasi_real)
                                ];
                            }
                        endforeach;
                        $data['naskah_rencana_produksi_id'] = $naskah_rencana_produksi_id;
                        $data['tampil'] = TRUE;
                    }
                }
            }
        }
        if ($data['naskah']['nojob'] == '') {
            $data['tampil'] = FALSE;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/job', $data);
        $this->load->view('templates/footer');
    }

    public function personal()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Laporan Job';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['cari'] = [
            'user_email' => '',
            'dari_tgl' => '',
            'sampai_tgl' => ''
        ];

        $data['tampil'] = FALSE;
        $tampilkan = $this->input->post('tampilkan');

        if ($tampilkan) {
            $data['tampil'] = TRUE;
            $user_email = $this->input->post('user_email');
            $dari_tgl = $this->input->post('dari_tgl');
            $dari_int = strtotime($dari_tgl);
            $sampai_tgl = $this->input->post('sampai_tgl');
            $sampai_int = strtotime($sampai_tgl . ' 23:59');

            $this->db->order_by('last_update ASC');
            $this->db->where('user_email', $user_email);
            $this->db->where('last_update >=', $dari_int);
            $this->db->where('last_update <=', $sampai_int);
            $data['progres_naskah'] = $this->db->get('progres_naskah')->result_array();

            $data['cari'] = [
                'user_email' => $user_email,
                'dari_tgl' => $dari_tgl,
                'sampai_tgl' => $sampai_tgl
            ];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/personal', $data);
        $this->load->view('templates/footer');
    }

    public function saya()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Laporan Job';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['cari'] = [
            'user_email' => $email,
            'dari_tgl' => '',
            'sampai_tgl' => ''
        ];

        $data['tampil'] = FALSE;
        $tampilkan = $this->input->post('tampilkan');

        if ($tampilkan) {
            $data['tampil'] = TRUE;
            $user_email = $email;
            $dari_tgl = $this->input->post('dari_tgl');
            $dari_int = strtotime($dari_tgl);
            $sampai_tgl = $this->input->post('sampai_tgl');
            $sampai_int = strtotime($sampai_tgl . ' 23:59');

            $this->db->order_by('last_update ASC');
            $this->db->where('user_email', $user_email);

            $this->db->where('last_update >=', $dari_int);
            $this->db->where('last_update <=', $sampai_int);
            $data['progres_naskah'] = $this->db->get('progres_naskah')->result_array();

            $data['cari'] = [
                'user_email' => $user_email,
                'dari_tgl' => $dari_tgl,
                'sampai_tgl' => $sampai_tgl
            ];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/saya', $data);
        $this->load->view('templates/footer');
    }

    public function unit_kerja()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Laporan Job';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['cari'] = [
            'nama_unit_kerja' => '',
            'dari_tgl' => '',
            'sampai_tgl' => ''
        ];

        $data['tampil'] = FALSE;
        $tampilkan = $this->input->post('tampilkan');

        if ($tampilkan) {

            $data['tampil'] = TRUE;
            $nama_unit_kerja = $this->input->post('nama_unit_kerja');
            $dari_tgl = $this->input->post('dari_tgl');
            $dari_int = strtotime($dari_tgl);
            $sampai_tgl = $this->input->post('sampai_tgl');
            $sampai_int = strtotime($sampai_tgl . ' 23:59');

            $this->db->order_by('last_update ASC');
            $this->db->where('nama_unit_kerja', $nama_unit_kerja);
            $this->db->where('last_update >=', $dari_int);
            $this->db->where('last_update <=', $sampai_int);
            $data['progres_naskah'] = $this->db->get('progres_naskah')->result_array();

            $data['cari'] = [
                'nama_unit_kerja' => $nama_unit_kerja,
                'dari_tgl' => $dari_tgl,
                'dari_tgl' => $dari_tgl,
                'sampai_tgl' => $sampai_tgl
            ];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/unit_kerja', $data);
        $this->load->view('templates/footer');
    }

    public function antrian()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Antrean: ' . date('d-m-Y', now('Asia/Jakarta'));
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tampilkan = TRUE;
        $data['tampil'] = $tampilkan;
        $ke_antri = TRUE;

        $kirim = $this->input->post('kirim');
        if ($kirim) {
            $id = $this->input->post('id');
            $pic_email = $this->input->post('pic_email');

            $ke_antri = $this->input->post('ke_menu_antri');

            $detail_rencana_produksi = $this->db->get_where('detail_rencana_produksi', ['id' => $id])->row_array();

            $naskah_rencana_produksi_id = $detail_rencana_produksi['naskah_rencana_produksi_id'];

            $nojob = $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row()->nojob;
            $versi =  $this->db->get_where('naskah_rencana_produksi', ['naskah_rencana_produksi_id' => $naskah_rencana_produksi_id])->row()->versi;
            $detail_alur_kerja_id = $detail_rencana_produksi['detail_alur_kerja_id'];
            $nama_unit_kerja = $detail_rencana_produksi['nama_unit_kerja'];

            $detail_alur_kerja = $this->db->get_where('detail_alur_kerja', ['detail_alur_kerja_id' => $detail_alur_kerja_id])->row_array();
            $nama_objek_kerja = $detail_alur_kerja['nama_objek_kerja'];
            $nama_level_kerja = $this->db->get_where('level_kerja', ['inisial_level_kerja' => $detail_alur_kerja['inisial_level_kerja']])->row()->nama_level_kerja;

            $this->db->where('id', $id);
            $this->db->set('pic_real', $pic_email);
            $this->db->set('mulai_real', '');
            $this->db->set('status', 'BARU');
            $this->db->set('last_update', now('Asia/Jakarta'));
            $this->db->set('update_oleh', $email);
            $this->db->set('is_active', 1);
            $this->db->update('detail_rencana_produksi');
            echo 'update id = ' . $id;

            $this->db->set('user_email', $pic_email);
            $this->db->set('nojob', $nojob);
            $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
            $this->db->set('nama_unit_kerja', $nama_unit_kerja);
            $this->db->set('nama_objek_kerja', $nama_objek_kerja);
            $this->db->set('nama_level_kerja', $nama_level_kerja);
            $this->db->set('naskah_rencana_produksi_id', $naskah_rencana_produksi_id);
            $this->db->set('versi', $versi);
            $this->db->set('mulai_real', '');
            $this->db->set('selesai_real', '');
            $this->db->set('last_update', now('Asia/Jakarta'));
            $this->db->set('pengarah', $email);
            $this->db->set('update_oleh', $email);
            $this->db->set('is_active', 1);
            $this->db->set('status', 'BARU');
            $this->db->insert('progres_naskah');

            $this->db->where('nama_unit_kerja', $nama_unit_kerja);
            $this->db->where('is_active', 1);
            $this->db->where('status', '');
            $this->db->where('pic !=', $pic_email);
            $this->db->where('nama_objek_kerja', $nama_objek_kerja);
            $this->db->where('naskah_rencana_produksi_id',  $naskah_rencana_produksi_id);
            $perubahan = $this->db->get('detail_rencana_produksi')->result_array();

            foreach ($perubahan as $p) : {
                    $id = $p['id'];
                    $this->db->set('naskah_rencana_produksi_id', $p['naskah_rencana_produksi_id']);
                    $this->db->set('detail_alur_kerja_id', $p['detail_alur_kerja_id']);
                    $this->db->set('urutan', $p['urutan']);
                    $this->db->set('nama_unit_kerja', $p['nama_unit_kerja']);
                    $this->db->set('nama_objek_kerja', $p['nama_objek_kerja']);
                    $this->db->set('mulai', $p['mulai']);
                    $this->db->set('mulai_int', $p['mulai_int']);
                    $this->db->set('antre', $p['antre']);
                    $this->db->set('mulai_real', $p['mulai_real']);
                    $this->db->set('mulai_real_int', $p['mulai_real_int']);
                    $this->db->set('selesai', $p['selesai']);
                    $this->db->set('selesai_int', $p['selesai_int']);
                    $this->db->set('selesai_real', $p['selesai_real']);
                    $this->db->set('selesai_real_int', $p['selesai_real_int']);
                    $this->db->set('status', $p['status']);
                    $this->db->set('pic', $pic_email);
                    $this->db->set('pic_real', $p['pic_real']);
                    $this->db->set('last_update', now('Asia/Jakarta'));
                    $this->db->set('update_oleh', $email);
                    $this->db->set('is_active', 1);
                    $this->db->insert('detail_rencana_produksi');

                    $this->db->where('id', $id);
                    $this->db->set('last_update', now('Asia/Jakarta'));
                    $this->db->set('update_oleh', $email);
                    $this->db->set('is_active', 0);
                    $this->db->update('detail_rencana_produksi');
                    echo 'perubahan id' . $id;
                }
            endforeach;
        }

        if ($tampilkan) {

            $this->db->where('is_active', 1);
            $this->db->where('antre <=', date('Y-m-d', now('Asia/Jakarta')) . ' 23:59');
            $this->db->where('status', 'ANTRE');
            $data['detail_rencana_produksi'] = $this->db->get('detail_rencana_produksi')->result_array();
        }

        if ($ke_antri) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('laporan/antrian', $data);
            $this->load->view('templates/footer');
        } else {

            $this->session->set_flashdata('pesan');
            $data['title'] = 'Detail Proses Job';
            $email = $this->session->userdata('email');
            $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

            $this->db->where('selesai_real', '');
            $this->db->where('mulai_int <', now('Asia/Jakarta'));
            $this->db->order_by('selesai_int ASC');
            $this->db->where('is_active', 1);

            $data['detail_proses_job'] = $this->db->get('detail_rencana_produksi')->result_array();
            redirect('laporan/detail_proses_job');
        }
    }

    public function detail_proses_job()
    {
        $this->session->set_flashdata('pesan');

        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $this->db->where('is_active', 1);

        $filter = FALSE;
        $filter = $this->input->post('filter');
        if ($filter) {
            $tipe = $this->input->post('tipe');
            $batas = $this->input->post('batas');
            $tanggal = $this->input->post('tanggal');
            $inisial_level_kerja = $this->input->post('inisial_level_kerja');
            if ($inisial_level_kerja != '') {
                $nama_level_kerja = $this->db->get_where('level_kerja', ['inisial_level_kerja' => $inisial_level_kerja])->row()->nama_level_kerja;
                $this->db->where('is_active', 1);
                $banyak_detail_alur_kerja = $this->db->get_where('detail_alur_kerja', ['inisial_level_kerja' => $inisial_level_kerja])->num_rows();
                $detail_alur_kerja = $this->db->get_where('detail_alur_kerja', ['inisial_level_kerja' => $inisial_level_kerja])->result_array();
                $i = 1;
                $where = '';
                //  $where = 'detail_alur_kerja_id =  "01NASKAH1"  OR detail_alur_kerja_id =  "02NASKAH1"';

                foreach ($detail_alur_kerja as $dak) : {
                        //$where = "name='Joe' AND status='boss' OR status='active'";
                        $where = $where . ' detail_alur_kerja_id = "' . $dak['detail_alur_kerja_id'] . '"';
                        if ($i < $banyak_detail_alur_kerja) {
                            $where = $where . ' OR ';
                        }
                    }
                    $i++;
                endforeach;
                $this->db->where($where);
                $judul_level_kerja = ' | Level Kerja : ' . $nama_level_kerja;
            } else {
                $judul_level_kerja = ' | Semua Level Kerja';
            }

            $this->db->where('is_active', 1);
            if ($tipe != '' and $batas != '' and $tanggal != '') {


                switch ($batas) {
                    case 'sebelum':
                        if ($tipe == 'mulai') {
                            $this->db->where('mulai_int <', strtotime($tanggal . ' 00:00'));
                        } else {

                            $this->db->where('selesai_int <', strtotime($tanggal . ' 00:00'));
                        }
                        break;
                    case 'sampai':
                        if ($tipe == 'mulai') {

                            $this->db->where('mulai_int =<', strtotime($tanggal . ' 23:59'));
                        } else {

                            $this->db->where('selesai_int <=', strtotime($tanggal . ' 23:59'));
                        }

                        break;
                    case 'pada':
                        if ($tipe == 'mulai') {

                            $this->db->where('mulai =', $tanggal);
                        } else {

                            $this->db->where('selesai =', $tanggal);
                        }

                        break;
                    case 'mulai':
                        if ($tipe == 'mulai') {

                            $this->db->where('mulai_int >=', strtotime($tanggal . ' 00:00'));
                        } else {

                            $this->db->where('selesai_int >=', strtotime($tanggal . ' 00:00'));
                        }
                        break;
                    case 'setelah':
                        if ($tipe == 'mulai') {

                            $this->db->where('mulai_int >', strtotime($tanggal . ' 23:59'));
                        } else {

                            $this->db->where('selesai_int >', strtotime($tanggal . ' 23:59'));
                        }
                        break;
                }
                if ($tipe == 'mulai') {
                    $judul = ': Tanggal Rencana Mulai ' . $batas . ' ' . $tanggal . $judul_level_kerja;
                } else {
                    $judul = ': Tanggal Rencana Selesai ' . $batas . ' ' . $tanggal . $judul_level_kerja;
                }
            } else {
                $tipe = '';
                $batas = '';
                $tanggal = '';
                $judul = ': Semua Tanggal ' . $judul_level_kerja;
            }
        } else {
            $tipe = '';
            $batas = '';
            $tanggal = '';
            $inisial_level_kerja = '';
            $judul = ': Semua';
        }
        $data['filter'] = [
            'tipe' => $tipe,
            'batas' => $batas,
            'tanggal' => $tanggal,
            'inisial_level_kerja' => $inisial_level_kerja

        ];


        $data['title'] = 'Detail Proses Job' . $judul;
        $this->db->where('selesai_real', '');
        $this->db->where('is_active', 1);

        $this->db->order_by('selesai_int ASC');

        $data['detail_proses_job'] = $this->db->get('detail_rencana_produksi')->result_array();
        //$banyak = $this->db->get('detail_rencana_produksi')->num_rows();
        // echo $banyak;
        // die;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/detail_proses_job', $data);
        $this->load->view('templates/footer');
    }
    public function job_finish() {
        $data['title'] = 'Job Finish';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['dari_tanggal'] = date('d-m-Y', now('Asia/Jakarta'));
        $data['sampai_tanggal'] = date('d-m-Y', now('Asia/Jakarta'));


        $filter = FALSE;
        $filter = $this->input->post('filter');
        if ($filter) {
            $data['dari_tanggal'] = $this->input->post('dari_tanggal');
            $data['sampai_tanggal'] = $this->input->post('sampai_tanggal');
        }

        // $this->db->where('last_update >=', strtotime($data['dari_tanggal'] . ' 00:00'));
        // $this->db->where('last_update <=', strtotime($data['sampai_tanggal'] . ' 23:59'));

        // $this->db->order_by('last_update DESC');
        // $this->db->where('status', 'FINISH');
		// $this->db->like('naskah_rencana_produksi_id', '210048');
        // $data['job_finish'] = $this->db->get('detail_rencana_produksi')->result_array();

		$last_update_more = date('Y-m-d', strtotime($data['dari_tanggal']));
		$last_update_less = date('Y-m-d', strtotime($data['sampai_tanggal']));
		
        $level_kerja = NULL;
        if ($this->input->post('level_kerja') && $this->input->post('level_kerja') != 'all') {
			$level_kerja = $this->input->post('level_kerja');
		}
        $data['jobs'] = $this->get_job_finish($last_update_more, $last_update_less, $level_kerja);

        $jf_count = [];
		$naskahs = [];
        foreach ($data['jobs'] as $jf) {
			if ($jf['latest']) {
				$naskahs[] = $jf['naskah_rencana_produksi_id'];
			}
			$jf_count[$jf['naskah_rencana_produksi_id']] += 1;
        }
        $data['jf_count'] = $jf_count;
		$data['naskahs'] = $naskahs;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/job_finish', $data);
        $this->load->view('templates/footer');
    }

    public function get_job_finish($last_update_more, $last_update_less, $level_kerja) {
        $sql = "SELECT 
                    pbefore.*,
                    detail_alur_kerja.inisial_level_kerja, detail_alur_kerja.detail_alur_kerja_id,
                    pbefore.naskah_rencana_produksi_id, pbefore.urutan,
                    IF(MAX(p.urutan)=pbefore.urutan, TRUE, FALSE) AS latest,
                    (
                        SELECT GROUP_CONCAT(detail_alur_kerja.inisial_level_kerja) AS urutans
                            FROM detail_rencana_produksi pg
                            LEFT JOIN detail_alur_kerja ON (pg.urutan = detail_alur_kerja.urutan AND detail_alur_kerja.alur_kerja_id = SUBSTR(pg.detail_alur_kerja_id, -9, 2)) 
                        WHERE 
                            pg.is_active = 1 
                            AND STR_TO_DATE(pg.mulai_real, '%d-%m-%Y') >= '$last_update_more' 
                            AND STR_TO_DATE(pg.mulai_real, '%d-%m-%Y') <= '$last_update_less' 
                            AND pg.mulai_real != '' 
                            AND pbefore.nama_objek_kerja = 'NASKAH' 
                            AND pg.naskah_rencana_produksi_id=pbefore.naskah_rencana_produksi_id
                        GROUP BY pg.naskah_rencana_produksi_id
                    ) AS urutans
                FROM 
                    detail_rencana_produksi AS p 
                    LEFT JOIN (
                        SELECT *
                        FROM detail_rencana_produksi
                        WHERE mulai_real != ''
                    ) AS pbefore ON (pbefore.naskah_rencana_produksi_id=p.naskah_rencana_produksi_id)
                    LEFT JOIN detail_alur_kerja ON (pbefore.urutan = detail_alur_kerja.urutan AND detail_alur_kerja.alur_kerja_id = SUBSTR(pbefore.detail_alur_kerja_id, -9, 2))
                WHERE 
                    pbefore.is_active = 1 ";

		$sql .= "AND STR_TO_DATE(pbefore.mulai_real, '%d-%m-%Y') >= '$last_update_more' 
				 AND STR_TO_DATE(pbefore.mulai_real, '%d-%m-%Y') <= '$last_update_less' ";

		$sql .= "AND p.urutan = (
                    SELECT MAX(urutan) 
                    FROM detail_rencana_produksi as p2 
                    WHERE p2.naskah_rencana_produksi_id = p.naskah_rencana_produksi_id 
                    AND p2.mulai_real != '' AND p2.is_active = 1
                ) 
				AND pbefore.mulai_real != ''
                AND pbefore.nama_objek_kerja = 'NASKAH'
                GROUP BY p.naskah_rencana_produksi_id, p.urutan, pbefore.naskah_rencana_produksi_id, pbefore.urutan ";

		if ($level_kerja && $level_kerja != 'all') {
			$sql .= "HAVING FIND_IN_SET('".$level_kerja."', urutans) > 0 ";
		}

        $sql .= "ORDER BY pbefore.naskah_rencana_produksi_id DESC, pbefore.urutan DESC, p.naskah_rencana_produksi_id DESC, p.urutan DESC";

		$data = $this->db->query($sql)->result_array();

        return $data;
    }

    public function job_finish_print() {
        $startdate = date("Y-m-d", strtotime($this->input->get('startdate')));
        $enddate = date("Y-m-d", strtotime($this->input->get('enddate')));
        $level_kerja = $this->input->get('level_kerja');

        $data['jobs'] = $this->get_job_finish($startdate, $enddate, $level_kerja);
        $data['print_mode'] = true;

        $this->load->view('laporan/job_finish', $data);
    }

    public function kartu_stok()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Kartu Stok';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['buku'] = [
            'kode' => '',
            'judul' => '',
            'jilid' => '',
            'penulis' => ''

        ];
        $data['error1'] = '';
        $cari = FALSE;
        $cari = $this->input->post('cari');

        if ($cari) {
            $kode = $this->input->post('kode');
            if ($kode == '') {
                $data['error1'] = "*) Tidak ada kode yang dicari";
                $cari = FALSE;
            } else {
                $data['buku'] = $this->db->get_where('buku', ['kode' => $kode])->row_array();
                if (!isset($data['buku'])) {
                    $data['buku'] = [
                        'kode' => $kode,
                        'judul' => '',
                        'jilid' => '',
                        'penulis' => ''
                    ];
                    $data['error1'] = "*) Kode tersebut belum terdaftar";
                    $cari = FALSE;
                }
            }
        }

        $tampilkan = FALSE;
        $tampilkan = $this->input->post('tampilkan');
        if ($tampilkan) {
            $kode = $this->input->post('kode');
            $data['buku'] = $this->db->get_where('buku', ['kode' => $kode])->row_array();

            $this->form_validation->set_rules(
                'gudang_id',
                'Nama Gudang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'dari_tgl',
                'Tanggal Mulai',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'sampai_tgl',
                'Tanggal Selesai',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $tampilkan = FALSE;
            if (!$this->form_validation->run() == FALSE) {
                $gudang_id = $this->input->post('gudang_id');
                $dari_tgl = $this->input->post('dari_tgl');
                $sampai_tgl = $this->input->post('sampai_tgl');

                $dari_tgl_int = strtotime($dari_tgl . ' 00:00');
                $sampai_tgl_int = strtotime($sampai_tgl . ' 24:00');

                $this->db->where('kode', $kode);
                $this->db->where('gudang_id', $gudang_id);
                $this->db->where('last_update >=', $dari_tgl_int);
                $this->db->where('last_update <=', $sampai_tgl_int);
                $this->db->order_by('last_update ASC');
                $data['kartu_stok'] = $this->db->get('transaksi_stok')->result_array();

                $data['nama_gudang'] = $this->db->get_where('gudang', ['id' => $gudang_id])->row()->nama_gudang;
                $tampilkan = TRUE;
            }
        }

        $data['tampilkan'] = $tampilkan;
        $data['cari'] = $cari;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/kartu_stok', $data);
        $this->load->view('templates/footer');
    }

    public function buku_masuk()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Buku Masuk';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['buku_masuk'] = [
            'gudang_id' => '',
            'dari_tgl' => '',
            'sampai_tgl' => ''

        ];
        $data['error1'] = '';


        $tampilkan = FALSE;
        $tampilkan = $this->input->post('tampilkan');
        if ($tampilkan) {

            $this->form_validation->set_rules(
                'gudang_id',
                'Nama Gudang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'dari_tgl',
                'Tanggal Mulai',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'sampai_tgl',
                'Tanggal Selesai',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            $tampilkan = FALSE;
            if (!$this->form_validation->run() == FALSE) {
                $gudang_id = $this->input->post('gudang_id');
                $dari_tgl = $this->input->post('dari_tgl');
                $sampai_tgl = $this->input->post('sampai_tgl');

                $dari_tgl_int = strtotime($dari_tgl . ' 00:00');
                $sampai_tgl_int = strtotime($sampai_tgl . ' 24:00');

                $this->db->where('masuk_keluar', 'MASUK');
                $this->db->where('gudang_id', $gudang_id);
                $this->db->where('last_update >=', $dari_tgl_int);
                $this->db->where('last_update <=', $sampai_tgl_int);
                $this->db->order_by('last_update ASC');
                $data['kartu_stok'] = $this->db->get('transaksi_stok')->result_array();

                $data['nama_gudang'] = $this->db->get_where('gudang', ['id' => $gudang_id])->row()->nama_gudang;

                $data['buku_masuk'] = [
                    'gudang_id' => $gudang_id,
                    'dari_tgl' => $dari_tgl,
                    'sampai_tgl' => $sampai_tgl

                ];
                $tampilkan = TRUE;
            }
        }

        $data['tampilkan'] = $tampilkan;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/buku_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function buku_keluar()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Buku Keluar';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['buku_keluar'] = [
            'gudang_id' => '',
            'dari_tgl' => '',
            'sampai_tgl' => ''

        ];
        $data['error1'] = '';


        $tampilkan = FALSE;
        $tampilkan = $this->input->post('tampilkan');
        if ($tampilkan) {
            $this->form_validation->set_rules(
                'gudang_id',
                'Nama Gudang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'dari_tgl',
                'Tanggal Mulai',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'sampai_tgl',
                'Tanggal Selesai',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            $tampilkan = FALSE;
            if (!$this->form_validation->run() == FALSE) {
                $gudang_id = $this->input->post('gudang_id');
                $dari_tgl = $this->input->post('dari_tgl');
                $sampai_tgl = $this->input->post('sampai_tgl');

                $dari_tgl_int = strtotime($dari_tgl . ' 00:00');
                $sampai_tgl_int = strtotime($sampai_tgl . ' 24:00');

                $this->db->where('masuk_keluar', 'KELUAR');
                $this->db->where('gudang_id', $gudang_id);
                $this->db->where('last_update >=', $dari_tgl_int);
                $this->db->where('last_update <=', $sampai_tgl_int);
                $this->db->order_by('last_update ASC');
                $data['kartu_stok'] = $this->db->get('transaksi_stok')->result_array();

                $data['nama_gudang'] = $this->db->get_where('gudang', ['id' => $gudang_id])->row()->nama_gudang;

                $data['buku_keluar'] = [
                    'gudang_id' => $gudang_id,
                    'dari_tgl' => $dari_tgl,
                    'sampai_tgl' => $sampai_tgl

                ];
                $tampilkan = TRUE;
            }
        }

        $data['tampilkan'] = $tampilkan;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/buku_keluar', $data);
        $this->load->view('templates/footer');
    }

    public function stok_akhir()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Stok Akhir';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['error1'] = '';
        $data['gudang_id'] = '';
        $data['kode'] = '';
        $data['tampil_filter'] = [
            'jenjang_id' => '',
            'mapel_id' => '',
            'kategori_id' => '',
        ];
        $tampilkan = FALSE;
        $tampilkan_kode = $this->input->post('tampilkan_kode');
        if ($tampilkan_kode) {
            $kode = $this->input->post('kode');
            $gudang_id = $this->input->post('gudang_id');
            $data['gudang_id'] = $gudang_id;
            $data['kode'] = $kode;
            $data['tampil_filter'] = [

                'jenjang_id' => '',
                'mapel_id' => '',
                'kategori_id' => '',
            ];
            if ($kode == '') {
                $data['error1'] = "*) Tidak ada kode yang dicari";
                $cari = FALSE;
                $tampilkan = FALSE;
            } else {
                $data['buku'] = $this->db->get_where('buku', ['kode' => $kode])->result_array();


                $tampilkan = TRUE;
                foreach ($data['buku'] as $buku) : {
                        $gudang = $this->db->get('gudang')->result_array();
                        foreach ($gudang as $g) : {
                                $gudang_id = $g['id'];
                                $this->db->select_max('last_update');
                                $this->db->where('gudang_id', $gudang_id);
                                $this->db->where('kode', $kode);
                                $last_update = $this->db->get('transaksi_stok')->row()->last_update;

                                $this->db->where('last_update', $last_update);
                                $this->db->where('gudang_id', $gudang_id);
                                $this->db->where('kode', $kode);
                                $stok_akhir = $this->db->get('transaksi_stok')->row_array();
                                if (!isset($stok_akhir)) {
                                    $data['stok_akhir'][$gudang_id][$kode] = 0;
                                } else {
                                    $data['stok_akhir'][$gudang_id][$kode] = $stok_akhir['stok_akhir'];
                                }
                            }

                        endforeach;
                    }
                endforeach;
            }
        }
        $tampilkan_filter = $this->input->post('tampilkan_filter');
        if ($tampilkan_filter) {
            $gudang_id = $this->input->post('gudang_id');
            $jenjang_id = $this->input->post('jenjang_id');
            $mapel_id = $this->input->post('mapel_id');
            $kategori_id = $this->input->post('kategori_id');

            $data['gudang_id'] = $gudang_id;
            $data['kode'] = '';
            $data['tampil_filter'] = [

                'jenjang_id' => $jenjang_id,
                'mapel_id' => $mapel_id,
                'kategori_id' => $kategori_id,
            ];

            if ($jenjang_id != 'X') {
                $this->db->where('SUBSTRING(standar_pc_id, 1, 2)=', $jenjang_id);
            }
            if ($mapel_id != 'X') {
                $this->db->where('SUBSTRING(standar_pc_id, 3, 2)=', $mapel_id);
            }
            if ($kategori_id != 'X') {
                $this->db->where('SUBSTRING(standar_pc_id, 5, 2)=', $kategori_id);
            }
            $this->db->order_by('kode ASC');
            $data['buku'] = $this->db->get('buku')->result_array();
            $tampilkan = TRUE;
            foreach ($data['buku'] as $buku) : {

                    $gudang = $this->db->get('gudang')->result_array();
                    foreach ($gudang as $g) : {
                            $gudang_id = $g['id'];
                            $this->db->select_max('last_update');
                            $this->db->where('gudang_id', $gudang_id);
                            $this->db->where('kode', $buku['kode']);
                            $last_update = $this->db->get('transaksi_stok')->row()->last_update;

                            $this->db->where('last_update', $last_update);
                            $this->db->where('gudang_id', $gudang_id);
                            $this->db->where('kode', $buku['kode']);
                            $stok_akhir = $this->db->get('transaksi_stok')->row_array();
                            if (!isset($stok_akhir)) {
                                $data['stok_akhir'][$gudang_id][$buku['kode']] = 0;
                            } else {
                                $data['stok_akhir'][$gudang_id][$buku['kode']] = $stok_akhir['stok_akhir'];
                            }
                        }
                    endforeach;
                }
            endforeach;
        }

        $data['tampilkan'] = $tampilkan;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('laporan/stok_akhir', $data);
        $this->load->view('templates/footer');
    }
}
