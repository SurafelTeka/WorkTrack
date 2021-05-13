<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    var $board_id_active;

    public function __construct()
    {
        parent::__construct();

        // Check if user is logged
        if (!$this->session->userdata('logged') || $this->session->userdata('logged') == false) {
            redirect(base_url().'index.php/access');

            return false;
        }
        // Check if user existing now
        if ($this->db->query("SELECT * FROM users WHERE user_id = '{$this->session->userdata('user_session')['user_id']}}'")->num_rows() < 1) {
            $this->session->sess_destroy();
            redirect(base_url().'index.php/access');
            return false;
        }

        if (!$this->session->userdata('conf_date_format')) {
            $config = $this->db->get("configs")->row_array();
            $this->session->set_userdata($config);
        }


    }

	public function index()
	{

	    if ($this->sec->ck() == false) {
	        $this->activation();
        } else {
            $board = $this->db->query("SELECT * FROM boards WHERE board_id
                                            IN (SELECT board_id FROM boards_users WHERE user_id = '{$this->session->userdata('user_session')['user_id']}')
                                            ORDER BY board_default DESC LIMIT 1");
            if ($board->num_rows() > 0) {
                $this->board($board->row()->board_id);
            } else {
                $this->no_permissions();
            }
        }

	}


    public function no_permissions() {

        $page = $this->load->view('pages/permissions_error', array('data' => ''), true);
        $this->printpage($page);
    }

    public function activation() {

        $page = $this->load->view('pages/activation', array('data' => ''), true);
        $this->printpage($page);
    }



    public function archive()
    {
        $data['tasks'] = $this->db->get_where('tasks', array('task_archived' => 1));

        $page = $this->load->view('pages/archive', array('data' => $data), true);
        $this->printpage($page);

    }

    public function settings($board_id=null) {

        if ($this->session->userdata('user_session')['user_permissions'] != 0) {
            redirect(base_url());
        }
        $data['boards'] = $this->db->query("SELECT * FROM boards WHERE board_id
                                            IN (SELECT board_id FROM boards_users WHERE user_id = '{$this->session->userdata('user_session')['user_id']}')
                                            ORDER BY board_order ASC")->result_array();
        $data['configs'] = $this->db->get('configs')->row_array();
        $data['users'] = $this->db->get('users')->result_array();
        $data['board_id'] = $board_id;
        if ($board_id) {
            $data['containers'] = $this->db->order_by('container_order', 'ASC')->get_where('containers', array('container_board' => $board_id))->result_array();
        }

        $page = $this->load->view('pages/settings', array('data' => $data), true);
        $this->printpage($page);
    }

    public function board($board_id) {


        $data = array();
        $check_permission = $this->db->query("SELECT * FROM boards WHERE board_id
                                            IN (SELECT board_id FROM boards_users WHERE user_id = '{$this->session->userdata('user_session')['user_id']}')
                                            AND board_id = '$board_id' LIMIT 1");

        if (!$board_id || $check_permission->num_rows() < 1) {
            redirect();
        } else {
            $this->board_id_active = $board_id;
        }

        $data['board_id'] = $board_id;
        $data['containers'] = $this->db->query("SELECT * FROM containers WHERE container_board = '$board_id' ORDER BY container_order ASC")->result_array();


        foreach ($data['containers'] as $key => $container) {
            // Convert hex in rgb for background
            $hex = unserialize(CONTAINER_COLORS)[$container['container_color']];
            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
            $data['containers'][$key]['container_rgb'] = "$r,$g,$b";

            $data['tasks'][$container['container_id']] = $this->db->query("SELECT * FROM tasks WHERE task_container = '{$container['container_id']}' AND task_archived = 0 ORDER BY task_order ASC")->result_array();
        }

        // Check resume work
        $data['task_standby'] = $this->db->query("SELECT *, TIMEDIFF(NOW(), task_date_start) AS last_tracking
                                                  FROM task_periods LEFT JOIN tasks ON tasks.task_id = task_periods.task_id
                                                  WHERE task_periods_user = '{$this->session->userdata('user_session')['user_id']}' AND task_date_stop IS NULL ORDER BY task_periods_id ASC LIMIT 1")->row_array();

        /* OLD QUERY non teneva conto di eventuali immissioni manuali nelle task
         * $data['board_time_spent'] = $this->db->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timediff(task_date_stop, task_date_start)))) AS board_time_spent FROM task_periods
                                                       LEFT JOIN tasks ON tasks.task_id = task_periods.task_id
                                                       LEFT JOIN containers ON tasks.task_container = containers.container_id
                                                       LEFT JOIN boards ON containers.container_board = boards.board_id
                                                       WHERE board_id = '$board_id' ")->row()->board_time_spent;*/
        $data['board_time_spent_active'] = $this->db->query("SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `task_time_spent` ) ) ) AS board_time_spent FROM tasks
                                                       LEFT JOIN containers ON tasks.task_container = containers.container_id
                                                       LEFT JOIN boards ON containers.container_board = boards.board_id
                                                       WHERE board_id = '$board_id' AND task_archived = '0' ")->row()->board_time_spent;

        $data['board_time_spent_archived'] = $this->db->query("SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `task_time_spent` ) ) ) AS board_time_spent FROM tasks
                                                       LEFT JOIN containers ON tasks.task_container = containers.container_id
                                                       LEFT JOIN boards ON containers.container_board = boards.board_id
                                                       WHERE board_id = '$board_id' AND task_archived = '1'")->row()->board_time_spent;

        $data['configs'] = $this->db->get('configs')->row_array();

        if ($this->sec->ck() == false) {
            $this->activation();
        } else {
            $page = $this->load->view('pages/kanban', array('data' => $data), true);
            $this->printpage($page);
        }

    }

    public function md5check() {
        echo md5(file_get_contents("./application/models/Sec.php"));
    }
        
    /* ####################### TEMPLATE BUILDER ##################### */
    public function printpage($page) {

        $this->template['data']['configs'] = $this->db->get('configs')->row_array();
        $this->template['data']['board_id_active'] = $this->board_id_active;
        $this->template['data']['boards'] = $this->db->query("SELECT * FROM boards WHERE board_id
                                            IN (SELECT board_id FROM boards_users WHERE user_id = '{$this->session->userdata('user_session')['user_id']}')
                                            ORDER BY board_order ASC")->result_array();
        $this->template['content'] = $page;

        $this->load->view('layout/main', $this->template);
    }
}
