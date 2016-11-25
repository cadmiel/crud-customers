<?php
namespace Reports;

class Send
{
    public $data;
    protected $charSet  =   EMAIL_CHARSET;
    protected $port     =   EMAIL_PORT;
    protected $userName =   EMAIL_USER;
    protected $password =   EMAIL_PASSWORD;
    protected $subject  =   '';
    protected $msgHTML  =   '';
    protected $to       =   '';
    protected $toName   =   '';
    protected $phpmailer=   '';
    protected $From     =   EMAIL_FROM;
    protected $FromName =   EMAIL_FROM_NAME;
    protected $host     =   EMAIL_HOST;

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
        $this->phpmailer->SMTPDebug = EMAIL_DEBUG;
        $this->phpmailer->Debugoutput = 'html';
        $this->phpmailer->Host = $this->host;
        $this->phpmailer->Port = $this->port;
        
        $this->phpmailer->SMTPSecure= EMAIL_SMTP_SECURE;
        $this->phpmailer->SMTPAuth  = EMAIL_SMTP_AUTH;
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