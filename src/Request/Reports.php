<?php
require __DIR__ . '/../../vendor/autoload.php';
$obj = new \Reports\Customers();
extract($_GET);
$obj->getAllCustomers($search);
$emails_ = new \Reports\Emails();

if($obj->data):
foreach ($obj->data as $item):
    $emails_->getEmailsById($item->id);
    ?>
    <tr>
        <td><?php echo $item->id; ?></td>
        <td>
            <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle" style="width: 30px">
            </div>
        </td>
        <td><?php echo $item->name; ?></td>
        <td><?php echo $item->social_name; ?></td>
        <td><?php echo $item->type; ?></td>
        <td><?php echo $item->document; ?></td>
        <td>
            <?php if (count($emails_->data) != 0): ?>
                <i data-toggle="modal" data-target=".bs-example-modal-lg" data-id="<?php echo $item->id; ?>"
                   style="cursor: pointer" title="Enviar email" class="glyphicon glyphicon-envelope btn-envelope"
                   aria-hidden="true"></i>
            <?php endif; ?>

            <i data-toggle="modal" data-target=".bs-example-modal-lg" data-id="<?php echo $item->id; ?>"
               style="cursor: pointer" title="Editar registro" class="glyphicon glyphicon-pencil btn-edit"
               aria-hidden="true"></i>

            <i data-id="<?php echo $item->id; ?>" style="cursor: pointer" title="Excluir registro"
               class="glyphicon glyphicon-remove btn_destroy" aria-hidden="true"></i>
        </td>
    </tr>
<?php endforeach; else: ?>
<tr><td colspan="7" align="center">Nenhum registro encontrado!!!</td></tr>
<?php endif; ?>
