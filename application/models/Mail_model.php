<?php

class Mail_model extends CI_Model
{


    public function __construct()
    {
        parent::__construct();
    }


    /**
     *
     * @param string $to
     * @param string $path
     * @param array $data
     * @param array $additional_headers
     * @param string $subject
     * @return bool
     */
    public function sendFromView($to, $path, array $data = [], array $additional_headers = [], $subject = null)
    {

        $message = $this->load->view($path, ['data' => $data], true);

        if (!$subject) {
            if (empty($this->subject) OR ! is_string($this->subject)) {
                $subject = str_replace(array('_', '-'), ' ', pathinfo($path, PATHINFO_FILENAME));
            } else {
                $subject = $this->subject;
                $this->subject = null;
            }
        }

        return $this->sendEmail($to, $additional_headers, $subject, $message);
    }


    /**
     * Metodo interno per invio mail
     *
     * @param string $to
     * @param array $headers
     * @param string $subject
     * @param string $message
     * @param bool $isHtml
     * @param array $extra_data
     * @return type
     */
    function sendEmail($to, array $headers, $subject, $message, $isHtml = true, $extra_data = [])
    {
        // Ensure the email library is loaded
        $this->load->library('email', $this->config->item('email_config'));

        // HTML mail setup
        if ($isHtml) {

            $this->email->set_mailtype('html');

            if (function_exists('mb_convert_encoding')) {
                $message = mb_convert_encoding(str_replace('&nbsp;', ' ', $message), 'HTML-ENTITIES', 'UTF-8');
            }
            $message = '<html><body>' . $message . '</body></html>';
        }

        // Addinfo to the email
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        // Prepend the default headers
        $defaultHeaders = $this->config->item('email_headers');
        $headers = array_merge($defaultHeaders? : [], $headers);

        // Setup standard headers
        if (isset($headers['From'])) {
            $from = $this->prepareAddress($headers['From']);
            $this->email->from($from['mail'], $from['name']);
        }

        if (isset($headers['Reply-To'])) {
            $replyto = $this->prepareAddress($headers['Reply-To']);
            $this->email->reply_to($replyto['mail'], $replyto['name']);
        }

        if (isset($headers['Cc'])) {
            $this->email->cc($headers['Ccz']);
        }

        if (isset($headers['Bcc'])) {
            $this->email->bcc($headers['Bcc']);
        }

        // Send and return the result
        $sent = $this->email->send();
        $this->email->clear(true);  // Non c'Ã¨ ancora modo di allegare file, perÃ² intanto lo mettiamo che non si sa mai

        return $sent;
    }

    /**
     * Metodo interno per parsare gli indirizzi nel formato
     *
     *          Nome <email@addr.ess>
     *
     * Viene ritornato un array con chiavi
     *  - mail
     *  - name
     *
     * @param string $address
     * @return array
     */
    public function prepareAddress($address)
    {

        $name = '';
        if (!filter_var($address, FILTER_VALIDATE_EMAIL) && preg_match('/\<([^\<\>]*)\>/', $address)) {
            $ltpos = strpos($address, '<');
            $gtpos = strrpos($address, '>');
            $name = trim(substr($address, 0, $ltpos));
            $address = trim(substr($address, $ltpos + 1, $gtpos - $ltpos - 1));
        }

        $mail = strtolower(trim($address));
        return compact('mail', 'name');
    }


}