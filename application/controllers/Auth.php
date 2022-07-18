<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {


        $this->form_validation->set_rules('email', 'Email', 'required|trim', ['required' => 'Email harus diisi']);
       
        $this->form_validation->set_rules('password', 'Password', 'required|trim', ['required' => 'Password harus diisi']);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'user_id' => $user['id'],
                        'email' => $user['email'],
                        'level_id' => $user['level_id']
                    ];
                    $this->session->set_userdata($data);
                    $level_name = $this->db->get_where('user_level', ['level_id' => $data['level_id']])->row()->level_name;

                    redirect('user');
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Password salah! </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Akun belum diaktivasi oleh Admin </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Email belum terdaftar! </div>');
            redirect('auth');
        }
    }

    public function daftar()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim', ['required' => 'Nama harus diisi']);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.email]', ['required' => 'Email harus diisi', 'is_unique' => 'email sudah terdaftar']);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[5]|max_length[10]|matches[password2]', ['required' => 'Password harus diisi', 'min_length' => 'password minimal 5 karakter', 'max_length' => 'password maksimal 10 karakter', 'matches' => 'Password tidak sama dengan konfirmasi password']);
        $this->form_validation->set_rules('password2', 'password konfirmasi', 'required|trim|matches[password1]', ['required' => 'Konfirmasi Password harus diisi']);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Daftar';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/daftar');
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($email),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'level_id' => 2,
                'foto' => 'default.png',
                'is_active' => 0,
                'date_created' => now('Asia/Jakarta'),
                'last_update' => now('Asia/Jakarta')
            ];

            //siapkan token


            $this->db->insert('user', $data);



            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Pembuatan akun sukses! Tunggu aktivasi dari admin </div>');
            redirect('auth');
        }
    }


    public function logout()
    {
        $this->db->close();
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('level_id');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Logout berhasil </div>');

        redirect('auth');
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'coba.website1965@gmail.com',
            'smtp_pass' => '717273urut',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];
        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from('coba.website1965@gmail.com', 'APLIKASI PENERBIT DUTA');
        $this->email->to($this->input->post('email'));

        if ($type == 'aktivasi') {
            $this->email->subject('Aktivasi dari APLIKASI PENERBIT DUTA');
            $this->email->message('Klik link berikut untuk aktivasi sebelum 24 jam ke depan: <a href="' . base_url() . 'auth/aktivasi?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi</a>');
        } else {
            if ($type == 'lupa') {
                $this->email->subject('Reset Password dari APLIKASI PENERBIT DUTA');
                $this->email->message('Klik link berikut untuk reset Password sebelum 24 jam ke depan: <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
            }
        }


        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function aktivasi()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('tabel1', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < 60 * 60 * 24) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('tabel1');

                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Aktivasi ' . $email . ' berhasil.  Silakan login!</div>');
                    redirect('auth');
                } else {
                    $this->db->delete('tabel1', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Aktivasi gagal.  Token kadaluwarsa (lebih dari 24 jam)!!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Aktivasi gagal.  Token tidak terdaftar!!</div>');
                redirect('auth');
            }
        } else {

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Aktivasi gagal.  Email tidak terdaftar!!</div>');
            redirect('auth');
        }
    }

    public function lupapassword()
    {

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Lupa Password';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/lupa_password');
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'lupa');
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Password telah direset! Silakan periksa email Anda</div>');
                redirect('auth');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Email tidak terdaftar atau belum diaktivasi</div>');
                redirect('auth/lupapassword');
            }
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->ubahPassword();
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Reset Password gagal.  Token tidak terdaftar!!</div>');
                redirect('auth');
            }
        } else {

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Reset Password gagal.  Email tidak terdaftar!!</div>');
            redirect('auth');
        }
    }

    public function ubahPassword()
    {
        if (!$this->session->userdata('reset_email')) {

            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[5]|max_length[10]|matches[password2]');
        $this->form_validation->set_rules('password2', 'password konfirmasi', 'required|trim|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Ubah Password';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/ubah_password');
            $this->load->view('templates/footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Ubah Password berhasil.  Silakan login!</div>');
            redirect('auth');
        }
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
