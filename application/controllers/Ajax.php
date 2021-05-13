<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller
{


    public function index()
    {

    }

    /*
     * ************************************  UPLOAD ATTACHMENTS *********************************************
     *
     */

    public function upload_attachments() {

        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png|pdf|xls|csv|xml|odt|doc|ppt|jpeg|mov|mp4|mp3|zip|rar|docx|xlsx|pptx|avi|html|js|svg';
        $config['max_size']             = 100000; // 100.000 = 100MB
        $config['file_name']            = md5(time());

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());

            header('HTTP/1.1 500 Internal Server Booboo');
            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode($error));
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $data_file = array('attachment_filename' => $data['upload_data']['file_name'],
                                'attachment_original_filename' => $data['upload_data']['client_name'],
                                'attachment_task_id' => $this->input->post('task_id'),
                                'attachment_user_id' => $this->session->userdata('user_session')['user_id']);

            $this->db->insert('attachments', $data_file);

            $data_file['attachment_creation_date'] = "now!";
            $data_file['user_name'] = $this->session->userdata('user_session')['user_name'];
            $data_file['attachment_id'] = $this->db->insert_id();
            echo (json_encode($data_file));
        }
    }


    /*
    *
    * ********************************** CREATE NEW ITEM METHODS **********************************
    *
    */


    public function new_board()
    {

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('board_name', 'Name', 'required');

        $post = $this->input->post();

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 0, 'txt' => strip_tags(validation_errors())));
        } else {

            if (isset($post['board_sharing'])) {
                $users_sharing = $post['board_sharing'];
                unset($post['board_sharing']);
            }

            // Save new board
            $this->db->insert("boards", $post);
            $board_id = $this->db->insert_id();

            // Save user-board association
            $this->db->insert('boards_users', array('board_id' => $board_id, 'user_id' => $this->session->userdata('user_session')['user_id']));

            //Check and save sharing users
            if (isset($users_sharing)) {
                foreach ($users_sharing as $user_id) {
                    $this->db->insert('boards_users', array('board_id' => $board_id, 'user_id' => $user_id));
                }
            }

            echo json_encode(array('status' => 1, 'txt' => base_url() . "home/settings/" . $board_id . "#tab_containers"));
        }

    }

    public function new_container()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('container_name', 'Name', 'required');

        $post = $this->input->post();

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 0, 'txt' => strip_tags(validation_errors())));
        } else {

            $this->db->insert("containers", $post);
            echo json_encode(array('status' => 4));
        }
    }

    /*
     *
     *
     * ********************************** GET DETAILS METHODS **********************************
     *
     *
     */

    public function get_task_details($task_id)
    {
        if (!$task_id)
            return false;

        switch ($this->session->userdata('conf_date_format')) {
            case 1:
                $date_hour_format = "%Y-%m-%d %H:%i";
                $date_format = "%Y-%m-%d";
                break;
            case 2:
                $date_hour_format = "%d-%m-%Y %H:%i";
                $date_format = "%d-%m-%Y";
                break;
            case 3:
                $date_hour_format = "%m-%d-%Y %h:%i %p";
                $date_format = "%m-%d-%Y";
                break;
        }

       /* if ($this->session->userdata('conf_date_format') == 1) {
            $data['task'] = $this->db->query("SELECT * FROM tasks LEFT JOIN users ON task_user = user_id WHERE task_id = '$task_id'")->row_array();

            $data['task_periods'] = $this->db->query("SELECT *, TIMEDIFF(task_date_stop, task_date_start) AS total_time FROM task_periods WHERE task_id = '$task_id'")->result_array();
            $data['task_attachments'] = $this->db->query("SELECT * FROM attachments LEFT JOIN users ON attachment_user_id = user_id WHERE attachment_task_id = '$task_id'")->result_array();

        } else if ($this->session->userdata('conf_date_format') == 2) {
*/
            $data['task'] = $this->db->query("SELECT *, DATE_FORMAT(task_date_creation,'$date_hour_format') AS task_date_creation, DATE_FORMAT(task_date_closed,'$date_hour_format') AS task_date_closed FROM tasks LEFT JOIN users ON task_user = user_id WHERE task_id = '$task_id'")->row_array();
            $data['task_attachments'] = $this->db->query("SELECT *, DATE_FORMAT(attachment_creation_date,'%d-%m-%Y') AS attachment_creation_date FROM attachments LEFT JOIN users ON attachment_user_id = user_id WHERE attachment_task_id = '$task_id'")->result_array();
            $data['task_todo'] = $this->db->query("SELECT * FROM tasks_todo WHERE task_id = '$task_id'")->result_array();
            $data['task_periods'] = $this->db->query("SELECT *, TIMEDIFF(task_date_stop, task_date_start) AS total_time, DATE_FORMAT(task_date_start,'$date_hour_format') AS task_date_start, DATE_FORMAT(task_date_stop,'$date_hour_format') AS task_date_stop
                                                      FROM task_periods
                                                      LEFT JOIN users ON task_periods.task_periods_user = users.user_id
                                                      WHERE task_id = '$task_id'")->result_array();
  //      }
        $data['task_time_spent'] = $this->db->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timediff(task_date_stop, task_date_start)))) AS total_time_spent FROM task_periods WHERE task_id = '$task_id'")->row()->total_time_spent;

        echo json_encode($data);
    }

    public function get_container_details($container_id)
    {
        if (!$container_id)
            return false;

        $data['container_tasks_count'] = $this->db->query("SELECT COUNT(*) AS count FROM tasks WHERE task_container = '$container_id'")->row_array();
        $data['container_data'] = $this->db->query("SELECT * FROM containers WHERE container_id = '$container_id'")->row_array();
        echo json_encode($data);
    }

    public function get_board_details($board_id)
    {
        if (!$board_id)
            return false;

        $data['board_data'] = $this->db->query("SELECT * FROM boards WHERE board_id = '$board_id'")->row_array();
        $data['boards_users'] = $this->db->query("SELECT * FROM boards_users WHERE board_id = '$board_id'")->result_array();
        echo json_encode($data);
    }

    public function get_user_details($user_id)
    {
        if (!$user_id)
            return false;

        $data['user_data'] = $this->db->query("SELECT * FROM users WHERE user_id = '$user_id'")->row_array();
        $data['user_boards'] = $this->db->query("SELECT COUNT(*) AS count FROM boards_users WHERE user_id = '$user_id'
                                                 AND board_id NOT IN (SELECT board_id FROM boards_users WHERE user_id <> '$user_id')")->row_array();
        echo json_encode($data);
    }

    /*
     *
     *
     * ********************************** EDIT METHODS **********************************
     *
     *
     */

    public function edit_task()
    {
        if ($this->session->userdata('user_session')['user_permissions'] > 10) {
            echo json_encode(array('status' => 0, 'txt' => 'You don\'t have permission to edit task :('));
            return false;
        }

        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('task_title', 'Title', 'required');

        $post = $this->input->post();

        $task_todo = $post['task_todo'];
        unset($post['task_todo']);

        if ($this->sec->ck() == false) {
            echo json_encode(array('status' => 0, 'txt' => "Something errors occured. Please contact the support."));
            die();
        }

        // Save todo
        if ($task_todo) {
            foreach (json_decode($task_todo) as $todo) {
                if ($todo) {
                    $this->db->insert("tasks_todo", array("task_id" => $post['task_id'], "title" => $todo, "status" => 0));
                }
            }
        }


        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 0, 'txt' => strip_tags(validation_errors())));
        } else {

            if ($this->db->query("SELECT * FROM containers WHERE container_id = '{$post['task_container']}' AND container_done = '1'")->num_rows() > 0) {

                $this->db->query("UPDATE tasks SET task_date_closed = IF(task_date_closed IS NULL, NOW(), task_date_closed) WHERE task_id = '{$post['task_id']}'");
            }

            $this->db->where("task_id", $post['task_id']);
            $this->db->update("tasks", $post);
            echo json_encode(array('status' => 4));
        }
    }

    public function edit_container()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('container_name', 'Name', 'required');

        $post = $this->input->post();

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 0, 'txt' => strip_tags(validation_errors())));
        } else {
            if (!isset($post['container_done'])) {
                $post['container_done'] = 0;
            }
            $this->db->where("container_id", $post['container_id']);
            $this->db->update("containers", $post);
            echo json_encode(array('status' => 4));
        }
    }

    public function edit_user()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_name', 'Name', 'required');
        $this->form_validation->set_rules('user_last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('user_permissions', 'Permissions', 'required');

        $post = $this->input->post();

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 0, 'txt' => strip_tags(validation_errors())));
        } else {
            if ($post['user_password'] != null && $post['user_password'] != "") {
                $post['user_password'] = md5($post['user_password']);
            } else {
                unset($post['user_password']);
            }

            if ($post['user_id'] == 1 && $this->config->item('demo_mode') == TRUE) {
                echo json_encode(array('status' => 0, 'txt' => "You can't edit admin user on demo online"));
                return false;
            }
            if (!isset($post['user_daily_reminder']) || $post['user_daily_reminder'] == null) {
                $post['user_daily_reminder'] = 0;
            }

            $this->db->where('user_id', $post['user_id']);
            $this->db->update("users", $post);
            echo json_encode(array('status' => 4));

            if ($post['user_id'] == $this->session->userdata('user_session')['user_id']) {
                $this->session->set_userdata('user_session', $post);
            }
        }
    }

    public function edit_board()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('board_name', 'Name', 'required');

        $post = $this->input->post();

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 0, 'txt' => strip_tags(validation_errors())));
        } else {

            if (isset($post['board_sharing'])) {
                $users_sharing = $post['board_sharing'];
                unset($post['board_sharing']);
            }

            // If new board default will remove default from other boards
            if (isset($post['board_default']) && $post['board_default'] == "1") {
                $this->db->query("UPDATE boards SET board_default = 0");
            } else {
                $post['board_default'] = 0;
            }

            // Update boar data
            $this->db->where("board_id", $post['board_id']);
            $this->db->update("boards", $post);

            // Refresh users sharing
            $this->db->query("DELETE FROM boards_users WHERE board_id = '{$post['board_id']}' AND user_id <> '{$this->session->userdata('user_session')['user_id']}'");
            if (isset($users_sharing)) {
                foreach ($users_sharing as $user_id) {
                    $this->db->insert('boards_users', array('board_id' => $post['board_id'], 'user_id' => $user_id));
                }
            }


            echo json_encode(array('status' => 4));
        }
    }

    /*
     *
     *
     * ********************************** SAVE METHODS **********************************
     *
     *
     */
    public function save_configs()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('conf_administrator_email', 'Email', 'valid_email');

        $post = $this->input->post();

        if ($this->sec->ck() == false) {
            echo json_encode(array('status' => 0, 'txt' => "Something errors occured. Please contact the support."));
            die();
        }

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 0, 'txt' => strip_tags(validation_errors())));
        } else {

            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'gif|jpg|png|pdf|xls|csv|xml|odt|doc|ppt|jpeg|mov|mp4|mp3|zip|rar|docx|xlsx|pptx|avi|html|js|svg';
            $config['max_size']             = 100000; // 100.000 = 100MB
            $config['file_name']            = md5(time());

            $this->load->library('upload', $config);

            if (isset($_FILES['conf_background_image']['name']) && $_FILES['conf_background_image']['name']) {

                if (!$this->upload->do_upload('conf_background_image')) {
                    $error = array('error' => $this->upload->display_errors());

                    header('HTTP/1.1 500 Internal Server Booboo');
                    header('Content-Type: application/json; charset=UTF-8');
                    die(json_encode($error));
                } else {
                    $data = array('upload_data' => $this->upload->data());

                    $post['conf_background_image'] = $data['upload_data']['file_name'];
                }
            }
            $this->db->update("configs", $post);

            redirect(base_url('home/settings'));

            $this->session->set_userdata($post);
        }

    }

    public function save_task()
    {
        $this->load->model('mail_model');


        if ($this->session->userdata('user_session')['user_permissions'] > 10) {
            echo json_encode(array('status' => 0, 'txt' => 'You don\'t have permission to create new task :('));
            return false;
        }
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('task_title', 'Title', 'required');

        $post = $this->input->post();

        if ($this->sec->ck() == false) {
            echo json_encode(array('status' => 0, 'txt' => "Something errors occured. Please contact the support."));
            die();
        }

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 0, 'txt' => strip_tags(validation_errors())));

        } else {
            $task_todo = $post['task_todo'];
            unset($post['task_todo']);

            $post['task_user'] = $this->session->userdata('user_session')['user_id'];
            $this->db->insert("tasks", $post);
            $task_id = $this->db->insert_id();

            // Save todo
            if ($task_todo) {
                foreach (json_decode($task_todo) as $todo) {
                    if ($todo) {
                        $this->db->insert("tasks_todo", array("task_id" => $task_id, "title" => $todo, "status" => 0));
                    }
                }
            }


            echo json_encode(array('status' => 4));

            // Check if this board is shared with other users
            $container_id = $post['task_container'];
            $my_user_id = $this->session->userdata('user_session')['user_id'];

            $board = $this->db->query("SELECT * FROM containers LEFT JOIN boards ON container_board = board_id WHERE container_id = '$container_id'")->row_array();
            $users = $this->db->query("SELECT * FROM boards_users NATURAL LEFT JOIN users WHERE board_id = '{$board['board_id']}' AND user_id <> '$my_user_id'");

            if ($users->num_rows() > 0) {
                foreach ($users->result_array() as $user) {
                    $data['user'] = $user;
                    $data['user_creator'] = $this->session->userdata('user_session');
                    $data['task'] = $post;
                    $data['board'] = $board;
                    $this->mail_model->sendFromView($user['user_email'], "mail_template/new_task.php", $data, array(), "New task!");
                }
            }


        }

    }

    public function save_user()
    {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_name', 'Name', 'required');
        $this->form_validation->set_rules('user_last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('user_email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('user_password', 'Password', 'required');
        $this->form_validation->set_rules('user_permissions', 'Permissions', 'required');

        $post = $this->input->post();

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 0, 'txt' => strip_tags(validation_errors())));
        } else {
            $post['user_password'] = md5($post['user_password']);
            $this->db->insert("users", $post);
            echo json_encode(array('status' => 4, 'txt' => base_url() . 'index.php/home/settings#tab_users'));
        }

    }


    /*
     *
     * ********************************** OTHERS METHODS **********************************
     *
     *
     */

    public function time_tracker($what, $task_id)
    {
        if (!$task_id || !$what)
            return false;

        if ($what == "start") {
            // Check if i have a same record
            if ($this->db->query("SELECT * FROM task_periods WHERE task_id = '$task_id' AND task_date_stop IS NULL")->num_rows() < 1) {
                $this->db->insert("task_periods", array("task_id" => $task_id, "task_date_start" => date("Y-m-d H:i:s"), 'task_periods_user' => $this->session->userdata('user_session')['user_id']));
            }
            $task = $this->db->query("SELECT * FROM tasks WHERE task_id = '$task_id'")->row_array();
            echo json_encode($task);

        } else if ($what == "stop") {
            echo date('Y-m-d H:i:s');

            $this->db->query("UPDATE task_periods SET task_date_stop = '" . date('Y-m-d H:i:s') . "' WHERE task_id = '$task_id' AND task_date_stop IS NULL ");

            $this->db->query("UPDATE tasks SET task_time_spent = (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timediff(task_date_stop, task_date_start)))) FROM task_periods WHERE task_id = '$task_id') WHERE task_id = '$task_id'");

        }
    }

    public function stop_tracker($task_id)
    {
        if (!$task_id)
            return false;

        $this->db->insert("task_periods", array("task_id" => $task_id, "task_date_stop" => date("Y-m-d H:i:s")));
    }


    /*
     * UPDATE DRAG POSITION
     *
     */

    public function update_field($table, $field, $value, $field_id, $element_id)
    {
        $this->db->where($field_id, $element_id);
        $this->db->update($table, array($field => $value));
        echo json_encode(array('status' => 4));
    }

    public function update_position()
    {
        $data = $this->input->post();
        $to_done = false;

        foreach ($data as $container_id => $tasks) {
            $x = 1;
            if ($this->db->query("SELECT * FROM containers WHERE container_id = '$container_id' AND container_done = '1'")->num_rows() > 0) {
                $to_done = true;
            }
            foreach ($tasks as $task) {
                // Check if drag to DONE column
                if ($to_done == true) {
                    $this->db->query("UPDATE tasks SET task_date_closed = IF(task_date_closed IS NULL AND task_container <> '$container_id', NOW(), task_date_closed), task_container = '$container_id', task_order = '$x' WHERE task_id = '$task'");
                } else {
                    $this->db->query("UPDATE tasks SET task_container = '$container_id', task_order = '$x' WHERE task_id = '$task'");
                }
                $x++;
            }
        }
    }

    public function update_containers_position()
    {
        $data = $this->input->post("containers_id");

        $x = 0;
        foreach ($data as $container_id) {
            $this->db->query("UPDATE containers SET container_order = '$x' WHERE container_id = '$container_id'");
            $x++;
        }
    }

    public function update_boards_position()
    {
        $data = $this->input->post("boards_id");

        $x = 0;
        foreach ($data as $board_id) {
            echo $board_id;
            $this->db->query("UPDATE boards SET board_order = '$x' WHERE board_id = '$board_id'");
            $x++;
        }
    }


    /*
     * ******* DELETE METHODS
     */
    public function delete($from, $field_id, $id_element)
    {
        $this->db->query("DELETE FROM $from WHERE $field_id = '$id_element' ");

        // If task, i will delete also periods
        if ($from == "tasks") {
            $this->db->query("DELETE FROM task_periods WHERE task_id = '$id_element' ");
        }
        echo json_encode(array('status' => 4));
    }

    public function delete_board()
    {
        $data = $this->input->post();
        $this->db->query("DELETE FROM boards WHERE board_id = '{$data['board_id']}'");
        $this->db->query("DELETE FROM boards_users WHERE board_id = '{$data['board_id']}'");

        // Delete all task and all columns from board
        $this->db->query("DELETE FROM tasks WHERE task_container IN (SELECT container_id FROM containers WHERE container_board = '{$data['board_id']}')");
        $this->db->query("DELETE FROM containers WHERE container_board = '{$data['board_id']}'");
        echo json_encode(array('status' => 4));
    }

    public function delete_container()
    {
        $data = $this->input->post();
        $this->db->query("DELETE FROM containers WHERE container_id = '{$data['container_id']}'");

        // Move task to another column
        if ($data['move_container'] != 0) {
            $this->db->query("UPDATE tasks SET task_container = '{$data['move_container']}' WHERE task_container = '{$data['container_id']}'");
        }
        echo json_encode(array('status' => 4));
    }

    public function delete_user()
    {
        $data = $this->input->post();

        // Move task to another column
        if ($data['move_user'] != 0) {
            // Assign boards to another user
            $boards_user = $this->db->query("SELECT board_id FROM boards_users WHERE user_id = '{$data['user_id']}'
                                             AND board_id NOT IN (SELECT board_id FROM boards_users WHERE user_id <> '{$data['user_id']}')")->result_array();

            foreach ($boards_user as $board) {
                $this->db->query("UPDATE boards_users SET user_id = '{$data['move_user']}' WHERE board_id = '{$board['board_id']}'");
            }

        } else {

            // Delete all user data
            $this->db->query("DELETE FROM tasks WHERE task_container
                                IN (SELECT container_id FROM containers WHERE container_board
                                  IN (SELECT board_id FROM boards_users WHERE user_id = '{$data['user_id']}'
                                        AND board_id NOT IN (SELECT board_id FROM boards_users WHERE user_id <> '{$data['user_id']}')))");

            $this->db->query("DELETE FROM containers WHERE container_board
                                IN (SELECT board_id FROM boards_users WHERE user_id = '{$data['user_id']}'
                                      AND board_id NOT IN (SELECT board_id FROM boards_users WHERE user_id <> '{$data['user_id']}'))");

            $this->db->query("DELETE FROM boards WHERE board_id
                                IN (SELECT board_id FROM boards_users WHERE user_id = '{$data['user_id']}')
                                  AND board_id NOT IN (SELECT board_id FROM boards_users WHERE user_id <> '{$data['user_id']}')");
        }

        // Delete boards assign
        $this->db->query("DELETE FROM boards_users WHERE user_id = '{$data['user_id']}'");

        // Delete user
        $this->db->query("DELETE FROM users WHERE user_id = '{$data['user_id']}'");

        echo json_encode(array('status' => 4));
    }


}
