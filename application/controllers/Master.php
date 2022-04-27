<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function user_level()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Level User';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'level_id',
                'Level ID',
                'required|is_unique[user_level.level_id]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );
            $this->form_validation->set_rules(
                'level_name',
                'Nama Level',
                'required|is_unique[user_level.level_name]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );


            if (!$this->form_validation->run() == FALSE) {
                $level_id = $this->input->post('level_id');
                $level_name = $this->input->post('level_name');
                $nama_unit_kerja = $this->input->post('nama_unit_kerja');
                $this->db->set('level_id', $level_id);
                $this->db->set('level_name', $level_name);
                $this->db->set('nama_unit_kerja', $nama_unit_kerja);
                $this->db->insert('user_level');
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
                                                Level User sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {
            $id = $this->input->post('id');
            $level_id = $this->input->post('level_id');
            $level_name = $this->input->post('level_name');
            $nama_unit_kerja = $this->input->post('nama_unit_kerja');

            $user_level = $this->db->get_where('user_level', ['id' => $id])->row_array();

            $this->db->set('level_id', $level_id);
            $this->db->set('level_name', $level_name);
            $this->db->set('nama_unit_kerja', $nama_unit_kerja);
            $this->db->where('id', $id);
            $this->db->update('user_level');
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
                                                Level User sudah diupdate
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $delete = $this->input->post('delete');
        if ($delete) {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->delete('user_level');
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
                                                Level User berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/user_level', $data);
        $this->load->view('templates/footer');
    }


    public function menu()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Menu';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');

        if ($tambah) {
            $this->form_validation->set_rules(
                'urutan',
                'Urutan',
                'required|is_unique[menu.urutan]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );

            $this->form_validation->set_rules(
                'menu_name',
                'Nama Menu',
                'required|is_unique[menu.menu_name]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );


            if ($this->form_validation->run() != FALSE) {
                $urutan = $this->input->post('urutan');
                $menu_name = $this->input->post('menu_name');
                $parent = $this->input->post('parent');
                $link = $this->input->post('link');
                $icon = $this->input->post('icon');
                $this->db->set('parent', $parent);
                $this->db->set('urutan', $urutan);
                $this->db->set('menu_name', $menu_name);
                $this->db->set('link', $link);
                $this->db->set('icon', $icon);
                $this->db->insert('menu');
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
                                                Menu sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {

            $id = $this->input->post('id');
            $urutan = $this->input->post('urutan');
            $menu_name = $this->input->post('menu_name');
            $menu = $this->db->get_where('menu', ['id' => $id])->row_array();
            $urutan_lama = $menu['urutan'];
            $menu_name_lama = $menu['menu_name'];

            if ($urutan != $urutan_lama) {
                $this->form_validation->set_rules(
                    'urutan',
                    'Urutan',
                    'is_unique[menu.urutan]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'urutan',
                    'Urutan',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }

            if ($menu_name != $menu_name_lama) {
                $this->form_validation->set_rules(
                    'menu_name',
                    'Nama Menu',
                    'is_unique[menu.menu_name]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'menu_name',
                    'Nama Menu',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }


            if ($this->form_validation->run() != FALSE) {
                $urutan = $this->input->post('urutan');
                $menu_name = $this->input->post('menu_name');
                $parent = $this->input->post('parent');
                $link = $this->input->post('link');
                $icon = $this->input->post('icon');
                $this->db->set('parent', $parent);
                $this->db->set('urutan', $urutan);
                $this->db->set('menu_name', $menu_name);
                $this->db->set('link', $link);
                $this->db->set('icon', $icon);
                $this->db->where('id', $id);
                $this->db->update('menu');
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
                                                Menu sudah diupdate
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
            $this->db->delete('menu');
            $this->db->where('parent', $id);
            $this->db->delete('menu');
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
                                                Menu berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/menu', $data);
        $this->load->view('templates/footer');
    }

    public function jenjang()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Jenjang';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');

        if ($tambah) {
            $this->form_validation->set_rules(
                'jenjang_id',
                'Jenjang ID',
                'required|is_unique[jenjang.jenjang_id]|exact_length[2]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'exact_length'  => '*) %s harus 2 karakter',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );

            $this->form_validation->set_rules(
                'nama_jenjang',
                'Nama Jenjang',
                'required|is_unique[jenjang.nama_jenjang]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );
            $this->form_validation->set_rules(
                'koefisien_harga',
                'Koefisien Harga',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );


            if ($this->form_validation->run() != FALSE) {
                $jenjang_id = $this->input->post('jenjang_id');
                $nama_jenjang = $this->input->post('nama_jenjang');
                $koefisien_harga = $this->input->post('koefisien_harga');
                $this->db->set('koefisien_harga', $koefisien_harga);
                $this->db->set('jenjang_id', $jenjang_id);
                $this->db->set('nama_jenjang', $nama_jenjang);
                $this->db->insert('jenjang');
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
                                                Jenjang sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {

            $id = $this->input->post('id');
            $jenjang_id = $this->input->post('jenjang_id');
            $nama_jenjang = $this->input->post('nama_jenjang');
            $jenjang = $this->db->get_where('jenjang', ['id' => $id])->row_array();
            $jenjang_id_lama = $jenjang['jenjang_id'];
            $nama_jenjang_lama = $jenjang['nama_jenjang'];

            if ($jenjang_id != $jenjang_id_lama) {
                $this->form_validation->set_rules(
                    'jenjang_id',
                    'Jenjang ID',
                    'is_unique[jenjang.jenjang_id]|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'jenjang_id',
                    'Jenjang ID',
                    'required|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }

            if ($nama_jenjang != $nama_jenjang_lama) {
                $this->form_validation->set_rules(
                    'nama_jenjang',
                    'Nama Jenjang',
                    'is_unique[jenjang.nama_jenjang]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'nama_jenjang',
                    'Nama Jenjang',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }


            if ($this->form_validation->run() != FALSE) {
                $id = $this->input->post('id');
                $jenjang_id = $this->input->post('jenjang_id');
                $nama_jenjang = $this->input->post('nama_jenjang');
                $koefisien_harga = $this->input->post('koefisien_harga');
                $this->db->set('koefisien_harga', $koefisien_harga);
                $this->db->set('jenjang_id', $jenjang_id);
                $this->db->set('nama_jenjang', $nama_jenjang);
                $this->db->where('id', $id);
                $this->db->update('jenjang');
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
                                                Jenjang sudah diupdate
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
            $this->db->delete('jenjang');
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
                                                Jenjang berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/jenjang', $data);
        $this->load->view('templates/footer');
    }

    public function mapel()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Mata Pelajaran';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');

        if ($tambah) {
            $this->form_validation->set_rules(
                'mapel_id',
                'Mapel ID',
                'required|is_unique[mapel.mapel_id]|exact_length[2]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'exact_length'      => '*) %s harus 2 karakter',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );

            $this->form_validation->set_rules(
                'nama_mapel',
                'Nama Mapel',
                'required|is_unique[mapel.nama_mapel]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );


            if ($this->form_validation->run() != FALSE) {
                $mapel_id = $this->input->post('mapel_id');
                $nama_mapel = $this->input->post('nama_mapel');
                $this->db->set('mapel_id', $mapel_id);
                $this->db->set('nama_mapel', $nama_mapel);
                $this->db->insert('mapel');
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
                                                Mapel sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {

            $id = $this->input->post('id');
            $mapel_id = $this->input->post('mapel_id');
            $nama_mapel = $this->input->post('nama_mapel');
            $mapel = $this->db->get_where('mapel', ['id' => $id])->row_array();
            $mapel_id_lama = $mapel['mapel_id'];
            $nama_mapel_lama = $mapel['nama_mapel'];

            if ($mapel_id != $mapel_id_lama) {
                $this->form_validation->set_rules(
                    'mapel_id',
                    'Mapel ID',
                    'is_unique[mapel.mapel_id]|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'mapel_id',
                    'Mapel ID',
                    'required|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }

            if ($nama_mapel != $nama_mapel_lama) {
                $this->form_validation->set_rules(
                    'nama_mapel',
                    'Nama Mapel',
                    'is_unique[mapel.nama_mapel]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'nama_mapel',
                    'Nama Mapel',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }


            if ($this->form_validation->run() != FALSE) {
                $id = $this->input->post('id');
                $mapel_id = $this->input->post('mapel_id');
                $nama_mapel = $this->input->post('nama_mapel');
                $this->db->set('mapel_id', $mapel_id);
                $this->db->set('nama_mapel', $nama_mapel);
                $this->db->where('id', $id);
                $this->db->update('mapel');
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
                                                Mapel sudah diupdate
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
            $this->db->delete('mapel');
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
                                                Mapel berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/mapel', $data);
        $this->load->view('templates/footer');
    }

    public function kategori()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'kategori';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');

        if ($tambah) {
            $this->form_validation->set_rules(
                'kategori_id',
                'kategori ID',
                'required|is_unique[kategori.kategori_id]|exact_length[2]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );

            $this->form_validation->set_rules(
                'nama_kategori',
                'Nama kategori',
                'required|is_unique[kategori.nama_kategori]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'exact_length'      => '*) %s harus 2 karakter',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );


            if ($this->form_validation->run() != FALSE) {
                $kategori_id = $this->input->post('kategori_id');
                $nama_kategori = $this->input->post('nama_kategori');
                $this->db->set('kategori_id', $kategori_id);
                $this->db->set('nama_kategori', $nama_kategori);
                $this->db->insert('kategori');
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
                                                Kategori sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {

            $id = $this->input->post('id');
            $kategori_id = $this->input->post('kategori_id');
            $nama_kategori = $this->input->post('nama_kategori');
            $kategori = $this->db->get_where('kategori', ['id' => $id])->row_array();
            $kategori_id_lama = $kategori['kategori_id'];
            $nama_kategori_lama = $kategori['nama_kategori'];

            if ($kategori_id != $kategori_id_lama) {
                $this->form_validation->set_rules(
                    'kategori_id',
                    'kategori ID',
                    'is_unique[kategori.kategori_id]|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'kategori_id',
                    'kategori ID',
                    'required|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }

            if ($nama_kategori != $nama_kategori_lama) {
                $this->form_validation->set_rules(
                    'nama_kategori',
                    'Nama kategori',
                    'is_unique[kategori.nama_kategori]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'nama_kategori',
                    'Nama kategori',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }


            if ($this->form_validation->run() != FALSE) {
                $id = $this->input->post('id');
                $kategori_id = $this->input->post('kategori_id');
                $nama_kategori = $this->input->post('nama_kategori');
                $this->db->set('kategori_id', $kategori_id);
                $this->db->set('nama_kategori', $nama_kategori);
                $this->db->where('id', $id);
                $this->db->update('kategori');
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
                                                Kategori sudah diupdate
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
            $this->db->delete('kategori');
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
                                                Kategori berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/kategori', $data);
        $this->load->view('templates/footer');
    }


    public function buku()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Buku';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['filter_subj'] = [
            'kode' => '',
            'judul' => '',
            'mapel_id' => '',
            'jenjang_id' => '',
            'kategori_id' => ''
        ];

        $filter = FALSE;
        $filter = $this->input->post('filter');
        if ($filter) {
            $data['filter_subj'] = [
                'kode' => $this->input->post('kode'),
                'judul' => $this->input->post('judul'),
                'mapel_id' => $this->input->post('mapel_id'),
                'jenjang_id' => $this->input->post('jenjang_id'),
                'kategori_id' => $this->input->post('kategori_id')
            ];
        }
        $data['filter'] = $filter;

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'kode',
                'kode',
                'required|is_unique[buku.kode]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar. Anda bisa mengubah dari menu EDIT'
                )
            );
            $this->form_validation->set_rules(
                'judul',
                'Judul',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'jilid',
                'Jilid',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'penulis',
                'Penulis',
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
                $kode = $this->input->post('kode');
                $judul = $this->input->post('judul');
                $jilid = $this->input->post('jilid');
                $penulis = $this->input->post('penulis');
                $jenjang_id = $this->input->post('jenjang_id');
                $mapel_id = $this->input->post('mapel_id');
                $kategori_id = $this->input->post('kategori_id');
                $standar_pc_id = $jenjang_id . $mapel_id . $kategori_id;


                $this->db->set('kode', $kode);
                $this->db->set('judul', $judul);
                $this->db->set('jilid', $jilid);
                $this->db->set('penulis', $penulis);

                $this->db->set('standar_pc_id', $standar_pc_id);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->insert('buku');
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
                                                Data Buku sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }
        $edit = $this->input->post('edit');
        if ($edit) {

            $this->form_validation->set_rules(
                'judul',
                'Judul',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'jilid',
                'Jilid',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'penulis',
                'Penulis',
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

                $kode = $this->input->post('kode');

                $judul = $this->input->post('judul');

                $jilid = $this->input->post('jilid');
                $penulis = $this->input->post('penulis');
                $jenjang_id = $this->input->post('jenjang_id');
                $mapel_id = $this->input->post('mapel_id');
                $kategori_id = $this->input->post('kategori_id');
                $standar_pc_id = $jenjang_id . $mapel_id . $kategori_id;


                $this->db->set('judul', $judul);
                $this->db->set('jilid', $jilid);
                $this->db->set('penulis', $penulis);
                $this->db->set('standar_pc_id', $standar_pc_id);

                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);

                $this->db->where('kode', $kode);
                $this->db->update('buku');
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
                                                Data Buku sudah diupdate
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $delete = $this->input->post('delete');
        if ($delete) {
            $kode = $this->input->post('kode');
            $this->db->where('kode', $kode);
            $this->db->delete('buku');
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
                                               Buku berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/buku', $data);
        $this->load->view('templates/footer');
    }

    public function unit_kerja()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Unit Kerja';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');

        if ($tambah) {
            $this->form_validation->set_rules(
                'nama_unit_kerja',
                'Nama Unit Kerja',
                'required|is_unique[unit_kerja.nama_unit_kerja]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );

            $this->form_validation->set_rules(
                'unit_kerja_id',
                'Unit Kerja ID',
                'required|is_unique[unit_kerja.unit_kerja_id]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'exact_length'      => '*) %s harus 2 karakter',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );
            $this->form_validation->set_rules(
                'inisial_unit_kerja',
                'Inisial Unit Kerja',
                'required|is_unique[unit_kerja.inisial_unit_kerja]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );


            if ($this->form_validation->run() != FALSE) {
                $unit_kerja_id = $this->input->post('unit_kerja_id');
                $nama_unit_kerja = $this->input->post('nama_unit_kerja');
                $inisial_unit_kerja = $this->input->post('inisial_unit_kerja');
                $this->db->set('unit_kerja_id', $unit_kerja_id);
                $this->db->set('nama_unit_kerja', $nama_unit_kerja);
                $this->db->set('inisial_unit_kerja', $inisial_unit_kerja);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->insert('unit_kerja');
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
                                                Unit Kerja sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {

            $id = $this->input->post('id');
            $unit_kerja_id = $this->input->post('unit_kerja_id');
            $nama_unit_kerja = $this->input->post('nama_unit_kerja');
            $inisial_unit_kerja = $this->input->post('inisial_unit_kerja');
            $unit_kerja = $this->db->get_where('unit_kerja', ['id' => $id])->row_array();
            $unit_kerja_id_lama = $unit_kerja['unit_kerja_id'];
            $nama_unit_kerja_lama = $unit_kerja['nama_unit_kerja'];
            $inisial_unit_kerja_lama = $unit_kerja['inisial_unit_kerja'];

            if ($unit_kerja_id != $unit_kerja_id_lama) {
                $this->form_validation->set_rules(
                    'unit_kerja_id',
                    'unit_kerja ID',
                    'is_unique[unit_kerja.unit_kerja_id]|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'unit_kerja_id',
                    'unit_kerja ID',
                    'required|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }

            if ($nama_unit_kerja != $nama_unit_kerja_lama) {
                $this->form_validation->set_rules(
                    'nama_unit_kerja',
                    'Nama unit_kerja',
                    'is_unique[unit_kerja.nama_unit_kerja]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'nama_unit_kerja',
                    'Nama unit_kerja',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }
            if ($inisial_unit_kerja != $inisial_unit_kerja_lama) {
                $this->form_validation->set_rules(
                    'inisial_unit_kerja',
                    'Inisial Unit Kerja',
                    'is_unique[unit_kerja.inisial_unit_kerja]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'inisial_unit_kerja',
                    'Inisial Unit Kerja',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }


            if ($this->form_validation->run() != FALSE) {
                $id = $this->input->post('id');
                $unit_kerja_id = $this->input->post('unit_kerja_id');
                $nama_unit_kerja = $this->input->post('nama_unit_kerja');
                $this->db->set('unit_kerja_id', $unit_kerja_id);
                $this->db->set('nama_unit_kerja', $nama_unit_kerja);
                $this->db->set('inisial_unit_kerja', $inisial_unit_kerja);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->where('id', $id);
                $this->db->update('unit_kerja');
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
                                                Unit Kerja sudah diupdate
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
            $this->db->delete('unit_kerja');
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
                                                Unit Kerja berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/unit_kerja', $data);
        $this->load->view('templates/footer');
    }

    public function level_kerja()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Level Kerja';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');

        if ($tambah) {
            $this->form_validation->set_rules(
                'nama_level_kerja',
                'Nama Level Kerja',
                'required|is_unique[level_kerja.nama_level_kerja]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );

            $this->form_validation->set_rules(
                'level_kerja_id',
                'Level Kerja ID',
                'required|is_unique[level_kerja.level_kerja_id]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'exact_length'      => '*) %s harus 2 karakter',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );
            $this->form_validation->set_rules(
                'inisial_level_kerja',
                'Inisial Level Kerja',
                'required|is_unique[level_kerja.inisial_level_kerja]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );


            if ($this->form_validation->run() != FALSE) {
                $level_kerja_id = $this->input->post('level_kerja_id');
                $nama_level_kerja = $this->input->post('nama_level_kerja');
                $inisial_level_kerja = $this->input->post('inisial_level_kerja');
                $this->db->set('level_kerja_id', $level_kerja_id);
                $this->db->set('nama_level_kerja', $nama_level_kerja);
                $this->db->set('inisial_level_kerja', $inisial_level_kerja);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('is_active', 1);
                $this->db->set('update_oleh', $email);
                $this->db->insert('level_kerja');
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
                                                Level Kerja sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {

            $id = $this->input->post('id');
            $level_kerja_id = $this->input->post('level_kerja_id');
            $nama_level_kerja = $this->input->post('nama_level_kerja');
            $inisial_level_kerja = $this->input->post('inisial_level_kerja');
            $level_kerja = $this->db->get_where('level_kerja', ['id' => $id])->row_array();
            $level_kerja_id_lama = $level_kerja['level_kerja_id'];
            $nama_level_kerja_lama = $level_kerja['nama_level_kerja'];
            $inisial_level_kerja_lama = $level_kerja['inisial_level_kerja'];

            if ($level_kerja_id != $level_kerja_id_lama) {
                $this->form_validation->set_rules(
                    'level_kerja_id',
                    'level_kerja ID',
                    'is_unique[level_kerja.level_kerja_id]|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'level_kerja_id',
                    'level_kerja ID',
                    'required|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }

            if ($nama_level_kerja != $nama_level_kerja_lama) {
                $this->form_validation->set_rules(
                    'nama_level_kerja',
                    'Nama level_kerja',
                    'is_unique[level_kerja.nama_level_kerja]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'nama_level_kerja',
                    'Nama level_kerja',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }
            if ($inisial_level_kerja != $inisial_level_kerja_lama) {
                $this->form_validation->set_rules(
                    'inisial_level_kerja',
                    'Inisial Level Kerja',
                    'is_unique[level_kerja.inisial_level_kerja]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'inisial_level_kerja',
                    'Inisial Level Kerja',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }


            if ($this->form_validation->run() != FALSE) {
                $id = $this->input->post('id');
                $level_kerja_id = $this->input->post('level_kerja_id');
                $nama_level_kerja = $this->input->post('nama_level_kerja');
                $this->db->set('level_kerja_id', $level_kerja_id);
                $this->db->set('nama_level_kerja', $nama_level_kerja);
                $this->db->set('inisial_level_kerja', $inisial_level_kerja);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->where('id', $id);
                $this->db->update('level_kerja');
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
                                                Level Kerja sudah diupdate
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
            $this->db->delete('level_kerja');
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
                                                Level Kerja berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/level_kerja', $data);
        $this->load->view('templates/footer');
    }

    public function objek_kerja()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Objek Kerja';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');

        if ($tambah) {
            $this->form_validation->set_rules(
                'nama_objek_kerja',
                'Nama Objek Kerja',
                'required|is_unique[objek_kerja.nama_objek_kerja]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );

            $this->form_validation->set_rules(
                'objek_kerja_id',
                'Objek Kerja ID',
                'required|is_unique[objek_kerja.objek_kerja_id]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'exact_length'      => '*) %s harus 2 karakter',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );
            $this->form_validation->set_rules(
                'inisial_objek_kerja',
                'Inisial Objek Kerja',
                'required|is_unique[objek_kerja.inisial_objek_kerja]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar'
                )
            );
            $this->form_validation->set_rules(
                'satuan',
                'Satuan',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'perhitungan_durasi',
                'Perhitungan Durasi',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );


            if ($this->form_validation->run() != FALSE) {
                $objek_kerja_id = $this->input->post('objek_kerja_id');
                $nama_objek_kerja = $this->input->post('nama_objek_kerja');
                $satuan = $this->input->post('satuan');
                $perhitungan_durasi = $this->input->post('perhitungan_durasi');
                $inisial_objek_kerja = $this->input->post('inisial_objek_kerja');
                $this->db->set('objek_kerja_id', $objek_kerja_id);
                $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                $this->db->set('inisial_objek_kerja', $inisial_objek_kerja);
                $this->db->set('perhitungan_durasi', $perhitungan_durasi);
                $this->db->set('satuan', $satuan);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->insert('objek_kerja');
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
                                                Objek Kerja sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {

            $id = $this->input->post('id');
            $objek_kerja_id = $this->input->post('objek_kerja_id');
            $nama_objek_kerja = $this->input->post('nama_objek_kerja');
            $inisial_objek_kerja = $this->input->post('inisial_objek_kerja');
            $satuan = $this->input->post('satuan');
            $perhitungan_durasi = $this->input->post('perhitungan_durasi');
            $objek_kerja = $this->db->get_where('objek_kerja', ['id' => $id])->row_array();
            $objek_kerja_id_lama = $objek_kerja['objek_kerja_id'];
            $nama_objek_kerja_lama = $objek_kerja['nama_objek_kerja'];
            $inisial_objek_kerja_lama = $objek_kerja['inisial_objek_kerja'];

            if ($objek_kerja_id != $objek_kerja_id_lama) {
                $this->form_validation->set_rules(
                    'objek_kerja_id',
                    'objek_kerja ID',
                    'is_unique[objek_kerja.objek_kerja_id]|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'is_unique'     => '*) %s tersebut sudah terdaftar'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'objek_kerja_id',
                    'objek_kerja ID',
                    'required|exact_length[2]',
                    array(
                        'exact_length'  => '*) %s harus 2 karakter',
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }

            if ($nama_objek_kerja != $nama_objek_kerja_lama) {
                $this->form_validation->set_rules(
                    'nama_objek_kerja',
                    'Nama objek_kerja',
                    'required|is_unique[objek_kerja.nama_objek_kerja]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar',
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'nama_objek_kerja',
                    'Nama objek_kerja',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }
            if ($inisial_objek_kerja != $inisial_objek_kerja_lama) {
                $this->form_validation->set_rules(
                    'inisial_objek_kerja',
                    'Inisial Objek Kerja',
                    'required|is_unique[objek_kerja.inisial_objek_kerja]',
                    array(

                        'is_unique'     => '*) %s tersebut sudah terdaftar',
                        'required'      => '*) %s tidak boleh kosong.'
                    )
                );
            } else {
                $this->form_validation->set_rules(
                    'inisial_objek_kerja',
                    'Inisial Objek Kerja',
                    'required',
                    array(
                        'required'      => '*) %s tidak boleh kosong.'

                    )
                );
            }


            if ($this->form_validation->run() != FALSE) {
                $id = $this->input->post('id');


                $this->db->where('id', $id);
                $nama_objek_kerja_lama = $this->db->get('objek_kerja')->row()->nama_objek_kerja;

                $this->db->where('nama_objek_kerja', $nama_objek_kerja_lama);
                $detail_alur_kerja = $this->db->get('detail_alur_kerja')->result_array();
                foreach ($detail_alur_kerja as $dak) : {
                        $dak_id = $dak['id'];
                        $alur_kerja_id = $dak['alur_kerja_id'];
                        $urutan = $dak['urutan'];
                        $detail_alur_kerja_id_lama = $dak['detail_alur_kerja_id'];
                        $detail_alur_kerja_id = $alur_kerja_id . $nama_objek_kerja . $urutan;
                        $this->db->where('id',  $dak_id);
                        $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                        $this->db->update('detail_alur_kerja');

                        $this->db->where('detail_alur_kerja_id',  $detail_alur_kerja_id_lama);
                        $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $this->db->update('standar_waktu');

                        $this->db->where('detail_alur_kerja_id',  $detail_alur_kerja_id_lama);
                        $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $this->db->update('detail_rencana_produksi');

                        $this->db->where('detail_alur_kerja_id',  $detail_alur_kerja_id_lama);
                        $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                        $this->db->update('progres_naskah');
                    }
                endforeach;


                $this->db->where('nama_objek_kerja', $nama_objek_kerja_lama);
                $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                $this->db->update('spek_naskah');


                $this->db->set('objek_kerja_id', $objek_kerja_id);
                $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                $this->db->set('inisial_objek_kerja', $inisial_objek_kerja);
                $this->db->set('satuan', $satuan);
                $this->db->set('perhitungan_durasi', $perhitungan_durasi);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->where('id', $id);
                $this->db->update('objek_kerja');



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
                                                Objek Kerja sudah diupdate
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
            $nama_objek_kerja = $this->db->get('objek_kerja')->row()->nama_objek_kerja;
            $this->db->where('nama_objek_kerja', $nama_objek_kerja);
            $this->db->delete('detail_alur_kerja');
            $this->db->where('id', $id);
            $this->db->delete('objek_kerja');
            $this->db->where('nama_objek_kerja', $nama_objek_kerja);
            $this->db->delete('spek_naskah');


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
                                                Objek Kerja berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/objek_kerja', $data);
        $this->load->view('templates/footer');
    }

    public function naskah()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Naskah';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $data['filter_subj'] = [
            'nojob' => '',
            'judul' => '',
            'mapel_id' => '',
            'jenjang_id' => '',
            'kategori_id' => ''
        ];

        $filter = FALSE;
        $filter = $this->input->post('filter');
        if ($filter) {
            $data['filter_subj'] = [
                'nojob' => $this->input->post('nojob'),
                'judul' => $this->input->post('judul'),
                'mapel_id' => $this->input->post('mapel_id'),
                'jenjang_id' => $this->input->post('jenjang_id'),
                'kategori_id' => $this->input->post('kategori_id')
            ];
        }
        $data['filter'] = $filter;

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'nojob',
                'Nojob',
                'required|is_unique[naskah.nojob]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar. Anda bisa mengubah dari menu EDIT'
                )
            );
            $this->form_validation->set_rules(
                'judul',
                'Judul',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'jilid',
                'Jilid',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'penulis',
                'Penulis',
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
                $nojob = $this->input->post('nojob');
                $kode = $this->input->post('kode');
                $judul = $this->input->post('judul');
                $jilid = $this->input->post('jilid');
                $penulis = $this->input->post('penulis');
                $jenjang_id = $this->input->post('jenjang_id');
                $mapel_id = $this->input->post('mapel_id');
                $kategori_id = $this->input->post('kategori_id');
                $standar_pc_id = $jenjang_id . $mapel_id . $kategori_id;

                $this->db->set('nojob', $nojob);
                $this->db->set('kode', $kode);
                $this->db->set('judul', $judul);
                $this->db->set('jilid', $jilid);
                $this->db->set('penulis', $penulis);
                $this->db->set('standar_pc_id', $standar_pc_id);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->insert('naskah');

                $objek_kerja = $this->db->get('objek_kerja')->result_array();
                foreach ($objek_kerja as $ok) : {
                        $nama_objek_kerja = $ok['nama_objek_kerja'];
                        $objek_kerja_id = $ok['objek_kerja_id'];
                        $this->db->set('nojob', $nojob);
                        $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                        $this->db->set('objek_kerja_id', $objek_kerja_id);
                        $this->db->set('jumlah_halaman', 0);
                        $this->db->set('last_update', now('Asia/Jakarta'));
                        $this->db->set('update_oleh', $email);
                        $this->db->set('is_active', 1);
                        $this->db->insert('spek_naskah');
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
                                                Data naskah sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }
        $edit = $this->input->post('edit');
        if ($edit) {

            $this->form_validation->set_rules(
                'judul',
                'Judul',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'jilid',
                'Jilid',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'penulis',
                'Penulis',
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

                $nojob = $this->input->post('nojob');
                $kode = $this->input->post('kode');

                $judul = $this->input->post('judul');

                $jilid = $this->input->post('jilid');
                $penulis = $this->input->post('penulis');
                $jenjang_id = $this->input->post('jenjang_id');
                $mapel_id = $this->input->post('mapel_id');
                $kategori_id = $this->input->post('kategori_id');
                $standar_pc_id = $jenjang_id . $mapel_id . $kategori_id;



                $this->db->set('kode', $kode);
                $this->db->set('judul', $judul);
                $this->db->set('jilid', $jilid);
                $this->db->set('penulis', $penulis);

                $this->db->set('standar_pc_id', $standar_pc_id);

                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);

                $this->db->where('nojob', $nojob);
                $this->db->update('naskah');
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
                                                Data naskah sudah diupdate
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $delete = $this->input->post('delete');
        if ($delete) {
            $nojob = $this->input->post('nojob');
            $this->db->where('nojob', $nojob);
            $this->db->delete('naskah');
            $this->db->where('nojob', $nojob);
            $this->db->delete('spek_naskah');

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
                                               naskah berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/naskah', $data);
        $this->load->view('templates/footer');
    }

    public function spek_naskah()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Spek Naskah';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $nojob = $this->input->post('nojob');
        $data['nojob'] = $nojob;
        $update = FALSE;
        $update = $this->input->post('update');

        if ($update) {

            $objek_kerja = $this->db->get('objek_kerja')->result_array();
            foreach ($objek_kerja as $ok) : {
                    $nama_objek_kerja = $ok['nama_objek_kerja'];
                    $objek_kerja_id = $ok['objek_kerja_id'];
                    $jumlah_halaman = $this->input->post($objek_kerja_id);
                    $this->db->where('nojob', $nojob);
                    $this->db->where('nama_objek_kerja', $nama_objek_kerja);

                    $this->db->set('jumlah_halaman', $jumlah_halaman);
                    $this->db->set('last_update', now('Asia/Jakarta'));
                    $this->db->set('update_oleh', $email);
                    $this->db->set('is_active', 1);

                    $this->db->update('spek_naskah');
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
                                                Spek naskah sudah diupdate
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/spek_naskah', $data);
        $this->load->view('templates/footer');
    }

    public function alur_kerja()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Alur Kerja';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();


        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'alur_kerja_id',
                'Alur Kerja ID',
                'required|is_unique[alur_kerja.alur_kerja_id]',
                array(
                    'required'      => '*) %s tidak boleh kosong.',
                    'is_unique'     => '*) %s tersebut sudah terdaftar. Anda bisa mengubah dari menu EDIT'
                )
            );
            $this->form_validation->set_rules(
                'model_alur_kerja',
                'Model Alur Kerja',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $alur_kerja_id = $this->input->post('alur_kerja_id');
                $model_alur_kerja = $this->input->post('model_alur_kerja');
                $this->db->set('alur_kerja_id', $alur_kerja_id);
                $this->db->set('model_alur_kerja', $model_alur_kerja);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->insert('alur_kerja');

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
                                                Data alur kerja sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {

            $this->form_validation->set_rules(
                'model_alur_kerja',
                'Model Alur Kerja',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );

            if (!$this->form_validation->run() == FALSE) {

                $alur_kerja_id = $this->input->post('alur_kerja_id');
                $kode = $this->input->post('kode');
                $model_alur_kerja = $this->input->post('model_alur_kerja');


                $this->db->set('model_alur_kerja', $model_alur_kerja);
                $this->db->where('alur_kerja_id', $alur_kerja_id);

                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->update('alur_kerja');
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
                                                Data alur kerja sudah diupdate
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $delete = $this->input->post('delete');
        if ($delete) {
            $alur_kerja_id = $this->input->post('alur_kerja_id');
            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $this->db->delete('alur_kerja');
            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $this->db->delete('detail_alur_kerja');

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
                                               Data alur kerja berhasil dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/alur_kerja', $data);
        $this->load->view('templates/footer');
    }


    public function detail_alur_kerja()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Detail Alur Kerja';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $alur_kerja_id = $this->input->post('alur_kerja_id');
        $data['alur_kerja_id'] = $alur_kerja_id;

        $tambah = FALSE;
        $edit = FALSE;
        $delete = FALSE;
        $tambah = $this->input->post('tambah');

        if ($tambah) {
            $nama_objek_kerja = $this->input->post('nama_objek_kerja');
            $inisial_level_kerja = $this->input->post('inisial_level_kerja');
            $nama_unit_kerja = $this->input->post('nama_unit_kerja');
            $urutan = $this->input->post('urutan');

            $this->form_validation->set_rules(
                'urutan',
                'Urutan',
                'required|callback_urutan_check',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'inisial_level_kerja',
                'Level Kerja',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            $this->form_validation->set_rules(
                'nama_unit_kerja',
                'Unit Kerja',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $this->db->order_by('objek_kerja_id ASC');
                $objek_kerja = $this->db->get('objek_kerja')->result_array();
                $this->db->order_by('level_kerja_id ASC');
                $level_kerja = $this->db->get('level_kerja')->result_array();

                $urutan = $this->input->post('urutan');
                $detail_alur_kerja_id = $alur_kerja_id . $nama_objek_kerja . $urutan;
                $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                $this->db->set('alur_kerja_id', $alur_kerja_id);
                $this->db->set('urutan', $urutan);
                $this->db->set('nama_objek_kerja', $nama_objek_kerja);
                $this->db->set('inisial_level_kerja', $inisial_level_kerja);
                $this->db->set('nama_unit_kerja', $nama_unit_kerja);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('detail_alur_kerja');
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
                                                Level Kerja ' . $nama_objek_kerja . ' sudah ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {
            $nama_objek_kerja = $this->input->post('nama_objek_kerja');
            $inisial_level_kerja = $this->input->post('inisial_level_kerja');
            $urutan = $this->input->post('urutan');

            $this->form_validation->set_rules(
                'inisial_level_kerja',
                'Level Kerja',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'

                )
            );
            if (!$this->form_validation->run() == FALSE) {
                $this->db->order_by('objek_kerja_id ASC');
                $objek_kerja = $this->db->get('objek_kerja')->result_array();
                $this->db->order_by('level_kerja_id ASC');
                $level_kerja = $this->db->get('level_kerja')->result_array();
                $urutan = $this->input->post('urutan');
                $nama_unit_kerja = $this->input->post('nama_unit_kerja');
                $detail_alur_kerja_id = $alur_kerja_id . $nama_objek_kerja . $urutan;

                $this->db->where('alur_kerja_id', $alur_kerja_id);
                $this->db->where('urutan', $urutan);
                $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                $detail_alur_kerja_id_lama = $this->db->get('detail_alur_kerja')->row()->detail_alur_kerja_id;

                $this->db->where('detail_alur_kerja_id', $detail_alur_kerja_id_lama);
                $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->update('standar_waktu');



                $this->db->set('detail_alur_kerja_id', $detail_alur_kerja_id);
                $this->db->where('alur_kerja_id', $alur_kerja_id);
                $this->db->where('urutan', $urutan);
                $this->db->where('nama_objek_kerja', $nama_objek_kerja);
                $this->db->set('inisial_level_kerja', $inisial_level_kerja);
                $this->db->set('nama_unit_kerja', $nama_unit_kerja);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->update('detail_alur_kerja');
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
                                                Level Kerja ' . $nama_objek_kerja . ' sudah update
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $delete = $this->input->post('delete');
        if ($delete) {
            $nama_objek_kerja = $this->input->post('nama_objek_kerja');
            $inisial_level_kerja = $this->input->post('inisial_level_kerja');
            $urutan = $this->input->post('urutan');


            $this->db->order_by('objek_kerja_id ASC');
            $objek_kerja = $this->db->get('objek_kerja')->result_array();
            $this->db->order_by('level_kerja_id ASC');
            $level_kerja = $this->db->get('level_kerja')->result_array();


            $this->db->where('alur_kerja_id', $alur_kerja_id);
            $this->db->where('urutan', $urutan);
            $this->db->where('nama_objek_kerja', $nama_objek_kerja);

            $this->db->delete('detail_alur_kerja');
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
                                                Level Kerja ' . $nama_objek_kerja . ' sudah terhapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/detail_alur_kerja', $data);
        $this->load->view('templates/footer');
    }

    public function urutan_check()
    {
        $urutan = $this->input->post('urutan');
        $nama_objek_kerja = $this->input->post('nama_objek_kerja');
        $alur_kerja_id = $this->input->post('alur_kerja_id');
        $ada = $this->db->get_where('detail_alur_kerja', array('urutan' => $urutan, 'alur_kerja_id' => $alur_kerja_id, 'nama_objek_kerja' => $nama_objek_kerja))->num_rows();
        if ($ada != 0) {
            $this->form_validation->set_message('urutan_check', '*) {field} sudah ada');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function pemasok()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Pemasok';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'nama_pemasok',
                'Nama Pemasok',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'alamat_pemasok',
                'Alamat Pemasok',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'tipe_pemasok',
                'Tipe Pemasok',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            if (!$this->form_validation->run() == FALSE) {
                $nama_pemasok = $this->input->post('nama_pemasok');
                $alamat_pemasok = $this->input->post('alamat_pemasok');
                $tipe_pemasok = $this->input->post('tipe_pemasok');

                $this->db->set('tipe_pemasok', $tipe_pemasok);
                $this->db->set('nama_pemasok', $nama_pemasok);
                $this->db->set('alamat_pemasok', $alamat_pemasok);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('pemasok');
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
                                                Pemasok ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {
            $this->form_validation->set_rules(
                'nama_pemasok',
                'Nama Pemasok',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'alamat_pemasok',
                'Alamat Pemasok',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'tipe_pemasok',
                'Tipe Pemasok',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            if (!$this->form_validation->run() == FALSE) {
                $id = $this->input->post('id');
                $nama_pemasok = $this->input->post('nama_pemasok');
                $alamat_pemasok = $this->input->post('alamat_pemasok');
                $tipe_pemasok = $this->input->post('tipe_pemasok');

                $this->db->set('tipe_pemasok', $tipe_pemasok);
                $this->db->set('nama_pemasok', $nama_pemasok);
                $this->db->set('alamat_pemasok', $alamat_pemasok);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->where('id', $id);
                $this->db->update('pemasok');


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
                                                Pemasok update
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
            $this->db->delete('pemasok');


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
                                                Pemasok dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/pemasok', $data);
        $this->load->view('templates/footer');
    }



    public function pelanggan()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Pelanggan';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'nama_pelanggan',
                'Nama Pelanggan',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'alamat_pelanggan',
                'Alamat Pelanggan',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'tipe_pelanggan',
                'Tipe Pelanggan',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            if (!$this->form_validation->run() == FALSE) {
                $nama_pelanggan = $this->input->post('nama_pelanggan');
                $alamat_pelanggan = $this->input->post('alamat_pelanggan');
                $tipe_pelanggan = $this->input->post('tipe_pelanggan');

                $this->db->set('tipe_pelanggan', $tipe_pelanggan);
                $this->db->set('nama_pelanggan', $nama_pelanggan);
                $this->db->set('alamat_pelanggan', $alamat_pelanggan);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('pelanggan');
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
                                                Pelanggan ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {
            $this->form_validation->set_rules(
                'nama_pelanggan',
                'Nama Pelanggan',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'alamat_pelanggan',
                'Alamat Pelanggan',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'tipe_pelanggan',
                'Tipe Pelanggan',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            if (!$this->form_validation->run() == FALSE) {
                $id = $this->input->post('id');
                $nama_pelanggan = $this->input->post('nama_pelanggan');
                $alamat_pelanggan = $this->input->post('alamat_pelanggan');
                $tipe_pelanggan = $this->input->post('tipe_pelanggan');

                $this->db->set('tipe_pelanggan', $tipe_pelanggan);
                $this->db->set('nama_pelanggan', $nama_pelanggan);
                $this->db->set('alamat_pelanggan', $alamat_pelanggan);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->where('id', $id);
                $this->db->update('pelanggan');


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
                                                Pelanggan update
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
            $this->db->delete('pelanggan');


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
                                                Pelanggan dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/pelanggan', $data);
        $this->load->view('templates/footer');
    }

    public function tipe_buku_masuk()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Tipe Buku Masuk';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'nama_tipe_buku_masuk',
                'Nama Tipe Buku Masuk',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $nama_tipe_buku_masuk = $this->input->post('nama_tipe_buku_masuk');
                $this->db->set('nama_tipe_buku_masuk', $nama_tipe_buku_masuk);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('tipe_buku_masuk');
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
                                                Tipe Buku Masuk ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {
            $this->form_validation->set_rules(
                'nama_tipe_buku_masuk',
                'Nama Tipe Buku Masuk',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $id = $this->input->post('id');
                $nama_tipe_buku_masuk = $this->input->post('nama_tipe_buku_masuk');
                $this->db->set('nama_tipe_buku_masuk', $nama_tipe_buku_masuk);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->where('id', $id);
                $this->db->update('tipe_buku_masuk');


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
                                                Tipe Buku masuk diupdate
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
            $this->db->delete('tipe_buku_masuk');

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
                                                Tipe Buku Masuk dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/tipe_buku_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function tipe_buku_keluar()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Tipe Buku Keluar';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'nama_tipe_buku_keluar',
                'Nama Tipe Buku Keluar',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $nama_tipe_buku_keluar = $this->input->post('nama_tipe_buku_keluar');

                $this->db->set('nama_tipe_buku_keluar', $nama_tipe_buku_keluar);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('tipe_buku_keluar');
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
                                                Tipe Buku Keluar ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {
            $this->form_validation->set_rules(
                'nama_tipe_buku_keluar',
                'Nama Tipe Buku Keluar',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $id = $this->input->post('id');
                $nama_tipe_buku_keluar = $this->input->post('nama_tipe_buku_keluar');

                $this->db->set('nama_tipe_buku_keluar', $nama_tipe_buku_keluar);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->where('id', $id);
                $this->db->update('tipe_buku_keluar');

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
                                                Tipe Buku Keluar diupdate
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
            $this->db->delete('tipe_buku_keluar');

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
                                                Tipe Buku Keluar dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/tipe_buku_keluar', $data);
        $this->load->view('templates/footer');
    }


    public function gudang()
    {
        $this->session->set_flashdata('pesan');
        $data['title'] = 'Gudang';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $tambah = $this->input->post('tambah');
        if ($tambah) {
            $this->form_validation->set_rules(
                'nama_gudang',
                'Nama Gudang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'alamat_gudang',
                'Alamat Gudang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $nama_gudang = $this->input->post('nama_gudang');
                $alamat_gudang = $this->input->post('alamat_gudang');


                $this->db->set('nama_gudang', $nama_gudang);
                $this->db->set('alamat_gudang', $alamat_gudang);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->insert('gudang');
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
                                            Gudang ditambah
                                            </div>
                                        </div>
                                    </div>'
                );
            }
        }

        $edit = $this->input->post('edit');
        if ($edit) {
            $this->form_validation->set_rules(
                'nama_gudang',
                'Nama Gudang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );
            $this->form_validation->set_rules(
                'alamat_gudang',
                'Alamat Gudang',
                'required',
                array(
                    'required'      => '*) %s tidak boleh kosong.'
                )
            );

            if (!$this->form_validation->run() == FALSE) {
                $id = $this->input->post('id');
                $nama_gudang = $this->input->post('nama_gudang');
                $alamat_gudang = $this->input->post('alamat_gudang');



                $this->db->set('nama_gudang', $nama_gudang);
                $this->db->set('alamat_gudang', $alamat_gudang);
                $this->db->set('last_update', now('Asia/Jakarta'));
                $this->db->set('update_oleh', $email);
                $this->db->set('is_active', 1);
                $this->db->where('id', $id);
                $this->db->update('gudang');


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
                                            Gudang update
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
            $this->db->delete('gudang');

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
                                                Pelanggan dihapus
                                            </div>
                                        </div>
                                    </div>'
            );
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/gudang', $data);
        $this->load->view('templates/footer');
    }
}
