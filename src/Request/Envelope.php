<?php
require __DIR__ . '/../../vendor/autoload.php';

$obj = new \Reports\Customers();
$fone = new \Reports\Fone();
$address = new \Reports\Address();
$emails = new \Reports\Emails();

if (isset($_GET['id'])) {
    $obj->getCustomerById($_GET['id']);
}

?>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-label-left">
            <div class="callBack"></div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="first-name">Enviar email para:</label>
                        <?php if (!is_null($obj->data)):
                            $emails->getEmailsById($obj->data->id);
                            ?>
                            <select name="sendTo" class="form-control" id="sendTo">
                                <option value="0">Todos</option>
                                <?php foreach ($emails->data as $item): ?>
                                    <option value="<?php echo $item->id ?>"><?php echo $item->email ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label" for="first-name">Mensagem</label>
                        <textarea class="form-control" id="msg" name="msg"></textarea>
                        <input type="hidden" id="id" value="<?php echo(is_null($obj->data) ? 0 : $obj->data->id) ?>">
                </div>
            </div>

            <div class="col-md-12">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success btn_send">Enviar E-mail</button>
            </div>

        </form>
    </div>
</div>