<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Halaman User';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function check_attendance () {
        $attendance_status = $this->db->get_where(
                                'absensi', 
                                [
                                    'user_id' => $this->session->userdata('user_id'),
                                    'tanggal' => date('Y-m-d', time())
                                ]
                            )->row_array();

        echo json_encode($attendance_status);
    }

    public function check_attendance_pulang () {
        $attendance_status = $this->db->get_where(
                                'absensi', 
                                [
                                    'user_id' => $this->session->userdata('user_id'),
                                    'tanggal' => date('Y-m-d', time()),
                                    'jam_pulang !=' => NULL
                                ]
                            )->row_array();

        echo json_encode($attendance_status);
    }

    public function absence () {
        $data = array(
            'user_id' => $this->session->userdata('user_id'),
            'tanggal' => date('Y-m-d', time()),
            'jam_datang' => date('Y-m-d H:i:s', time()),
            'ip_datang' => gethostbyaddr($_SERVER['REMOTE_ADDR'])
        );

        $absen_datang = $this->db->insert('absensi', $data);

        echo json_encode($absen_datang ? true : false);
    }

    public function absence_pulang () {
        $absen_pulang = $this->db->set('jam_pulang', date('Y-m-d H:i:s', time()))
                                 ->set('ip_pulang', gethostbyaddr($_SERVER['REMOTE_ADDR']))
                                 ->where('user_id', $this->session->userdata('user_id'))
                                 ->update('absensi');
        
        echo json_encode($absen_pulang ? true : false);
    }

    public function get_absence_time () {
        $waktu_datang = $this->db->get_where('absensi', [
                            'user_id' => $this->session->userdata('user_id'),
                            'tanggal' => date('Y-m-d', time())
                        ])->row_array();

        echo json_encode($waktu_datang);
    }

    public function get_attendance_history ($datatable = true) {
        $attendances_q = $this->db->select('absensi.*, t_karyawan.nama, t_karyawan.nikaryawan as nik');
                                  
        $absensi_tgl_mulai = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('mulai'))));
        $absensi_tgl_sampai = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('sampai'))));

        $attendances_q = $attendances_q->join('user', 'user.email = t_karyawan.nik', 'left')
                                       ->join("(SELECT absensi.* from absensi WHERE absensi.tanggal >= '$absensi_tgl_mulai' AND absensi.tanggal <= '$absensi_tgl_sampai') as absensi", 'absensi.user_id=user.id', 'LEFT', NULL);
                                  

        if ($this->input->post('karyawan')) {
            $attendances_q = $attendances_q->where('t_karyawan.id_karyawan', $this->input->post('karyawan'));
        }

        if ($absensi_tgl_mulai != date('Y-m-d', time()) || $absensi_tgl_sampai != date('Y-m-d', time())) {
            $attendances_q = $attendances_q->where('absensi.tanggal !=', 'NULL');
        }
                                
        $attendances = $attendances_q->where('t_karyawan.active', '1')
                                     ->order_by('absensi.tanggal', 'desc')
                                     ->get('t_karyawan')->result();

        $data = [];
        $no = 1;
        foreach ($attendances as $attendance) {
            $newAttendance = $attendance;
            $newAttendance->hari = $attendance->tanggal ? $this->get_hari($attendance->tanggal) : "-";
            $newAttendance->tanggal = $attendance->tanggal ? date('d/m/Y', strtotime($attendance->tanggal)) : "-";
            $newAttendance->jam_datang = $attendance->jam_datang ? date('H:i', strtotime($attendance->jam_datang)) : '-';
            $newAttendance->jam_pulang = $attendance->jam_pulang ? date('H:i', strtotime($attendance->jam_pulang)) : '-';
            $newAttendance->DT_RowId = "row_" . $no;

            $data[] = $newAttendance;
            $no++;
        }

        $final_data = new stdClass();
        $final_data->data = $data;

        if ($datatable) {
            echo json_encode($final_data);
        } else {
            return $final_data->data;
        }
    }

    function report_attendance_pdf () {
        $_POST['mulai'] = $this->input->get('mulai');
        $_POST['sampai'] = $this->input->get('sampai');
        $_POST['karyawan'] = $this->input->get('karyawan');

        $data['data'] = $this->get_attendance_history(false);
        // echo json_encode($data);

        $this->load->view('user/attendance_report', $data);
    }

	function get_hari($tanggal){
		$dt = strtotime($tanggal);
		$day = date('D',$dt);

		switch ($day) {
			case 'Sun':
				$hari = 'Minggu';
				break;
			case 'Mon':
				$hari = 'Senin';
				break;
			case 'Tue':
				$hari = 'Selasa';
				break;
			case 'Wed':
				$hari = 'Rabu';
				break;
			case 'Thu':
				$hari = 'Kamis';
				break;
			case 'Fri':
				$hari = 'Jum\'at';
				break;
			case 'Sat':
				$hari = 'Sabtu';
				break;
			default:
				# code...
				$hari = 'Tidak terdefinisi';
				break;
		}

		return $hari;
	}

    public function edit_profil()
    {
        $data['title'] = 'Edit Profil';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/edit_profil', $data);
        $this->load->view('templates/footer');
    }

    public function update_profil()
    {
        $data['title'] = 'Profil';
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', array('required' => 'Nama tidak boleh kosong'));

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit_profil', $data);
            $this->load->view('templates/footer');
        } else {
            $nama = $this->input->post('nama');

            //jika nama file dipilih
            $upload_image = $_FILES['foto']['name']; // kita hanya ambil name nya aja

            if ($upload_image) {

                $config['upload_path'] = './assets/img/profil/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto')) {

                    $old_gambar = $data['user']['foto'];

                    if ($old_gambar != 'default.png') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_gambar);
                    }
                    $new_gambar = $this->upload->data('file_name');
                    $this->db->set('foto', $new_gambar);
                } else {
                    echo $this->upload->display_errors();
                }
            }


            $this->db->set('nama', $nama);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->set_flashdata('pesan', '<div style="max-width: 540px;" class="alert alert-success" role="alert">Profil sudah diupdate</div>');
            redirect('user');
        }
    }

    public function edit()
    {
        $data['title'] = 'Edit Profil';
        $data['user'] = $this->db->get_where('tabel1', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', array('required' => 'Nama tidak boleh kosong'));

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');

            //jika nama file dipilih
            $upload_image = $_FILES['gambar']['name']; // kita hanya ambil name nya aja
            if ($upload_image) {
                $config['upload_path'] = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('gambar')) {
                    $old_gambar = $data['user']['gambar'];

                    if ($old_gambar != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_gambar);
                    }
                    $new_gambar = $this->upload->data('file_name');
                    $this->db->set('gambar', $new_gambar);
                } else {
                    echo $this->upload->display_errors();
                }
            }


            $this->db->set('nama', $nama);
            $this->db->where('email', $email);
            $this->db->update('tabel1');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data sudah diupdate</div>');
            redirect('user');
        }
    }

    public function ubahpassword()

    {
        $data['title'] = 'Ubah Password';
        $data['user'] = $this->db->get_where('tabel1', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required',   array('required' => 'Password Lama tidak boleh kosong'));
        $this->form_validation->set_rules('password_baru1', 'Password Baru', 'required|min_length[5]|matches[password_baru2]', array('required' => 'Password baru tidak boleh kosong', 'min_length[5]' => 'Password Baru minimal 5 karakter'));
        $this->form_validation->set_rules('password_baru2', 'Konfirmasi Password Baru', 'required', array('required' => 'Konfirmasi Password baru tidak boleh kosong'));

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/ubahpassword', $data);
            $this->load->view('templates/footer');
        } else {
            $data['title'] = 'Profil Saya';
            $password_lama = $this->input->post('password_lama');
            $password_baru = $this->input->post('password_baru1');
            if (!password_verify($password_lama, $data['user']['password'])) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Password Lama tidak cocok</div>');
                redirect('ubahpassword');
            } else {
                if ($password_lama == $password_baru) {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password lama</div>');
                    redirect('ubahpassword');
                } else {
                    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('tabel1');
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Password Sudah diubah</div>');
                    redirect('user');
                }
            }
        }
    }
}
