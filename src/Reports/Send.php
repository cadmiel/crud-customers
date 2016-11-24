<?php
namespace Reports;


class Send
{
    public $data;
    protected $charSet  =   'UTF-8';
    protected $port     =   587;
    protected $userName =   'AKIAJ7V4OR57DIQPOZMA';
    protected $password =   'AofyqIsT8ucxqWw1ltc9tq0dlXD0pkc5YhNMoeXl8AxD';
    protected $subject  =   '';
    protected $msgHTML  =   '';
    protected $to       =   '';
    protected $toName   =   '';
    protected $phpmailer=   '';
    protected $From     =   'no-reply@corretormulticanal.com.br';
    protected $FromName =   'Crud-customers';

    public function __construct(Phpmailer $phpmailer, $to, $toName, $subject, $msgHTML)
    {
        $this->to       =   $to;
        $this->toName   =   $toName;
        $this->subject  =   $subject;
        $this->msgHTML  =   $msgHTML;
        $this->phpmailer=   $phpmailer;
    }

    public function sendEmail(){

        $this->phpmailer->isSMTP();
        $this->phpmailer->CharSet = $this->charSet;
        $this->phpmailer->SMTPDebug = 0;
        $this->phpmailer->Debugoutput = 'html';
        $this->phpmailer->Host = 'email-smtp.us-east-1.amazonaws.com';
        $this->phpmailer->Port = $this->port;
        
        $this->phpmailer->SMTPSecure= 'tls';
        $this->phpmailer->SMTPAuth  = true;
        $this->phpmailer->Username  = $this->userName;
        $this->phpmailer->Password  = $this->password;

        $this->phpmailer->From      = $this->From;
        $this->phpmailer->FromName  = $this->FromName;

        $this->phpmailer->addAddress($this->to, $this->toName);
        $this->phpmailer->Subject = $this->subject;
        $this->phpmailer->msgHTML($this->msgHTML);

        if (!$this->phpmailer->send()) {
            $this->data     =    "Error: " . $this->phpmailer->ErrorInfo;
        } else {
            $this->data     =   true;
        }

    }

}