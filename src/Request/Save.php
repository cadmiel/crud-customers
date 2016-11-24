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

    /* Address */
    $address_->getAddressById($customer->data);
    $manager->destroy($address_, $customer->data);

    /* emails */
    $emails_->getEmailsById($customer->data);
    $manager->destroy($emails_, $customer->data);

    /* fone */
    $fone_->getFoneById($customer->data);
    $manager->destroy($fone_, $customer->data);

    /* customer */
    $manager->destroy($customer, $customer->data);

} elseif (isset($acao) AND $acao == 'send-email') {


    if ($to == 0) {
        $emails_->getEmailsById($id);
        foreach ($emails_->data as $item):
            mail($item->email, 'Comunucado', $msg);
        endforeach;
    } else {
        $emails_->getEmailsByIdCustomer($to);
        mail($emails_->data->email, 'Contato', $msg);
    }

} else {
    $customer->save(array('name' => $name, 'id' => $id));
    $customer->data;

    /* Address */
    $address_->getAddressById($customer->data);
    $manager->destroy($address_, $customer->data);
    $manager->save($address_, $address, $customer->data, 'address');

    /* emails */
    $emails_->getEmailsById($customer->data);
    $manager->destroy($emails_, $customer->data);
    $manager->save($emails_, $email, $customer->data, 'emails');

    /* fone */
    $fone_->getFoneById($customer->data);
    $manager->destroy($fone_, $customer->data);
    $manager->save($fone_, $fone, $customer->data, 'fone');

}
?>