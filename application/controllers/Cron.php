<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller
{


    public function index()
    {

    }

    /*
     * ************************************  UPLOAD ATTACHMENTS *********************************************
     *
     */

    public function daily_reminder() {

        $this->load->model('mail_model');

        // Users
        $users = $this->db->query("SELECT * FROM users WHERE user_daily_reminder = '1'")->result_array();

        foreach ($users as $user) {

            $data['user'] = $user;
            $data['boards'] = $this->db->query("SELECT * FROM boards WHERE board_id
                                            IN (SELECT board_id FROM boards_users WHERE user_id = '{$user['user_id']}')
                                            ORDER BY board_order ASC")->result_array();

            foreach ($data['boards'] as $board) {
                $data['tasks'][$board['board_id']] = $this->db->query("SELECT * FROM tasks LEFT JOIN containers ON tasks.task_container = containers.container_id
                                               WHERE container_board = '{$board['board_id']}'
                                               AND task_archived = 0
                                               AND DATE(task_due_date) = CURDATE()
                                               AND container_done = 0
                                               ORDER BY task_order ASC")->result_array();
            }


            echo $this->mail_model->sendFromView($user['user_email'], "mail_template/daily_reminder.php", $data, array(), "Daily reminder");
        }


    }


}
