<?php
namespace Reports;


class Send
{
    public $data;
    protected $charSet  =   'UTF-8';
    protected $port     =   '';
    protected $userName =   '';
    protected $password =   '';
    protected $subject  =   '';
    protected $msgHTML  =   '';
    protected $to       =   '';
    protected $toName   =   '';
    protected $phpmailer=   '';
    protected $From     =   '';
    protected $FromName =   'Crud-customers';
    protected $host     =   '';

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
        $this->phpmailer->Host = $this->host;
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