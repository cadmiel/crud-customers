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
                    <label class="control-label" for="first-name">Nome</label>
                        <input value="<?php echo(is_null($obj->data) ? '' : $obj->data->name) ?>" type="text"
                               id="first-name2" required="required" class="form-control col-md-7 col-xs-12 ">
                        <input type="hidden" id="id" value="<?php echo(is_null($obj->data) ? 0 : $obj->data->id) ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="first-name">Pessoa física ou jurídica:</label>
                        <select name="type" class="form-control type" id="type">
                            <?php if(is_null($obj->data)): ?>
                                <option selected value="1">CPF</option>
                                <option value="2">CNPJ</option>
                            <?php else: ?>
                                <option value="1" <?php echo( ($obj->data->type == 1) ? 'selected':''); ?> >CPF</option>
                                <option value="2" <?php echo( ($obj->data->type == 2) ? 'selected':'') ?> >CNPJ</option>
                            <?php endif; ?>
                        </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="document" id="label-document">
                        <?php if(is_null($obj->data)): ?>
                        CPF
                        <?php elseif(!is_null($obj->data)): ?>
                            <?php echo( ($obj->data->type == 1) ? 'CPF':'CNPJ'); ?>
                        <?php endif; ?>
                    </label>
                    <input value="<?php echo(is_null($obj->data) ? '' : $obj->data->document) ?>" type="text"
                           id="document" required="required" class="form-control <?php echo((is_null($obj->data) || (isset($obj->data) AND $obj->data->type == 1)) ? 'cpf' :'cnpj') ?> document">
                </div>
            </div>

            <div class="col-md-12">
                <a class="btn btn-primary newFone" id="addInput">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Telefone
                </a>

                <br/>

                <div id="dynamicFone" class="dynamicFone">

                    <?php if (!is_null($obj->data)):
                        $fone->getFoneById($obj->data->id);
                        foreach ($fone->data as $item): ?>
                            <div class="cd"><p>
                                <div class="col-md-6">
                                <input type="text" value="<?php echo $item->fone; ?>" class="form-control fone" id="fone"
                                       placeholder="" />
                                       </div>
                                <a class="btn btn-danger" href="javascript:void(0)" id="remove">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a>
                            </p></div>
                        <?php endforeach; endif; ?>

                </div>
            </div>

            <div class="col-md-12">
                <a class="btn btn-primary newAddress" id="addInput">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Address
                </a>

                <br/>

                <div id="dynamicAddress" class="dynamicAddress">

                    <?php if (!is_null($obj->data)):
                        $address->getAddressById($obj->data->id);
                        foreach ($address->data as $item): ?>
                        <div class="cd"><p>
                                <div class="col-md-6">
                                <input type="text" value="<?php echo $item->address; ?>" class="form-control" id="address" value=""
                                       placeholder=""/>
                                       </div>
                                <a class="btn btn-danger" href="javascript:void(0)" id="remove">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a>
                            </p></div>
                        <?php endforeach; endif; ?>
                </div>
            </div>

            <div class="col-md-12">
                <a class="btn btn-primary newEmail" id="addInput">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Add Email
                </a>

                <br/>

                <div id="dynamicEmail" class="dynamicEmail">

                    <?php if (!is_null($obj->data)):
                        $emails->getEmailsById($obj->data->id);
                        foreach ($emails->data as $item): ?>
                        <div class="cd"><p>
                                <div class="col-md-6">
                                <input type="text" value="<?php echo $item->email; ?>" class="form-control" id="email" value=""
                                       placeholder=""/>
                                       </div>
                                <a class="btn btn-danger" href="javascript:void(0)" id="remove">
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a>
                            </p></div>
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