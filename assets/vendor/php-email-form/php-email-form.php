<?php
class PHP_Email_Form {
    public $to;
    public $from_name;
    public $from_email;
    public $subject;
    public $message = '';
    public $ajax = false;
    public $smtp = array();

    public function add_message($content, $label = '', $length = -1) {
        if ($length > 0) {
            $content = substr($content, 0, $length);
        }
        $this->message .= ($label ? "<strong>$label:</strong> " : '') . "$content<br>\n";
    }

    public function send() {
        $to = $this->to;
        $subject = $this->subject;
        $message = $this->message;

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$this->from_name} <{$this->from_email}>\r\n";

        if (!empty($this->smtp)) {
            // If SMTP details are provided, use them
            ini_set("SMTP", $this->smtp['host']);
            ini_set("smtp_port", $this->smtp['port']);
            ini_set("sendmail_from", $this->smtp['username']);
            ini_set("auth_username", $this->smtp['username']);
            ini_set("auth_password", $this->smtp['password']);
        }

        $success = mail($to, $subject, $message, $headers);

        if ($this->ajax) {
            return $success ? 'OK' : 'Error';
        } else {
            return $success;
        }
    }
}
?>