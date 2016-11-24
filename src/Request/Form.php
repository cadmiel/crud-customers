<?php
require __DIR__ . '/../../vendor/autoload.php';

$obj = new \Reports\Customers();
$fone = new \Reports\Fone();
$address = new \Reports\Address();
$emails = new \Reports\Emails();

if (isset($_GET['id']))
    $obj->getCustomerById($_GET['id']);

?>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal form-label-left">
            <div class="callBack"></div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-3" for="first-name">Nome</label>

                    <div class="col-md-7">
                        <input value="<?php echo(is_null($obj->data) ? '' : $obj->data->name) ?>" type="text"
                               id="first-name2" required="required" class="form-control col-md-7 col-xs-12 ">
                        <input type="hidden" id="id" value="<?php echo(is_null($obj->data) ? 0 : $obj->data->id) ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <a class="btn btn-primary newFone" id="addInput">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Telefone
                </a>

                <br/>

                <div id="dynamicFone" class="dynamicFone">
                    <p>
                        <input type="text" class="fone form-control" name="fone[]" id="fone" value=""/>
                    </p>

                    <?php if (!is_null($obj->data)):
                        $fone->getFoneById($obj->data->id);
                        foreach ($fone->data as $item): ?>
                            <p>
                                <input type="text" value="<?php echo $item->fone; ?>" class="" id="fone" value=""
                                       placeholder=""/>
                                <a class="btn btn-danger" href="javascript:void(0)" id="remove">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a>
                            </p>
                        <?php endforeach; endif; ?>

                </div>
            </div>

            <div class="col-md-4">
                <a class="btn btn-primary newAddress" id="addInput">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Address
                </a>

                <br/>

                <div id="dynamicAddress" class="dynamicAddress">
                    <p>
                        <input type="text" class="address form-control" name="address[]" id="address" value=""/>
                    </p>
                    <?php if (!is_null($obj->data)):
                        $address->getAddressById($obj->data->id);
                        foreach ($address->data as $item): ?>
                            <p>
                                <input type="text" value="<?php echo $item->address; ?>" class="" id="address" value=""
                                       placeholder=""/>
                                <a class="btn btn-danger" href="javascript:void(0)" id="remove">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a>
                            </p>
                        <?php endforeach; endif; ?>
                </div>
            </div>

            <div class="col-md-4">
                <a class="btn btn-primary newEmail" id="addInput">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Email
                </a>

                <br/>

                <div id="dynamicEmail" class="dynamicEmail">
                    <p>
                        <input type="text" class="email form-control" name="email[]" id="email" value=""/>
                    </p>

                    <?php if (!is_null($obj->data)):
                        $emails->getEmailsById($obj->data->id);
                        foreach ($emails->data as $item): ?>
                            <p>
                                <input type="text" value="<?php echo $item->email; ?>" class="" id="email" value=""
                                       placeholder=""/>
                                <a class="btn btn-danger" href="javascript:void(0)" id="remove">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a>
                            </p>
                        <?php endforeach; endif; ?>

                </div>
            </div>

            <div class="col-md-12">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success btn_save">Save changes</button>
            </div>

        </form>
    </div>
</div>