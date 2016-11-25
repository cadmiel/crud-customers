<?php
require __DIR__ . '/../../vendor/autoload.php';

$customer = new \Reports\Customers();
$address_ = new \Reports\Address();
$emails_ = new \Reports\Emails();
$fone_ = new \Reports\Fone();
$manager = new \Reports\Manager();

extract($_POST);

if (isset($acao) AND $acao == 'destroy') {

    $customer->getCustomerById($id);
    $customer->data = $customer->data->id;
    $customer->destroy($customer->data);

} elseif (isset($acao) AND $acao == 'send-email') {

    $customer->getCustomerById($id);
    if ($to == 0) {
        $emails_->getEmailsById($id);
        foreach ($emails_->data as $item):
            $emails_->getEmailsByIdCustomer($to);
            $send = new \Reports\Send(new \Reports\Phpmailer(),$item->email,$customer->name,'contato',$msg);
            $send->sendEmail();
        endforeach;
    } else {
        $emails_->getEmailsByIdCustomer($to);
        $send = new \Reports\Send(new \Reports\Phpmailer(),$emails_->data->email,$customer->data->name,'contato',$msg);
        $send->sendEmail();
    }

} else {

    $customer->save(array('name' => $name, 'document'=>numberOnly($document),
                         'type'=>$type, 'id' => $id));
    $customer->data;

    /* Address */
    $address_->getAddressById($customer->data);
    $manager->destroy($address_, $customer->data);
    $manager->save($address_, @$address, $customer->data, 'address');

    /* emails */
    $emails_->getEmailsById($customer->data);
    $manager->destroy($emails_, $customer->data);
    $manager->save($emails_, @$email, $customer->data, 'emails');

    /* fone */
    $fone_->getFoneById($customer->data);
    $manager->destroy($fone_, $customer->data);
    $manager->save($fone_, @$fone, $customer->data, 'fone');

}

function numberOnly($str) {
    return preg_replace("/[^0-9]/", "", $str);
}

?>