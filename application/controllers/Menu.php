<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Atur Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->model('Menu_model', 'role');
        $data['role_id'] = $this->role->getRoleId();

        $this->form_validation->set_rules('menu', 'Menu', 'required', array('required' => 'Tidak ada menu ditambahkan'));
        $this->form_validation->set_rules('kontrol', 'User', 'less_than[1]', array('less_than[1]' => 'User belum dipilih'));
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Menu sudah ditambahkan </div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        $data['title'] = 'Atur Sub Menu';
        $data['user'] = $this->db->get_where('tabel1', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu_id', 'Menu', 'required', array('required' => '- Menu Induk belum dipilih'));
        $this->form_validation->set_rules('title', 'Title', 'required', array('required' => '- Nama sub menu masih kosong'));
        $this->form_validation->set_rules('url', 'Url', 'required', array('required' => '- url masih kosong'));
        $this->form_validation->set_rules('icon', 'Icon', 'required', array('required' => '- icon masih kosong'));

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'menu_id' => $this->input->post('menu_id'),
                'title' => $this->input->post('title'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active'),
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Sub menu sudah ditambahkan </div>');
            redirect('menu/submenu');
        }
    }
}
