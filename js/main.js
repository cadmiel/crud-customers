$(document).ready(function(){

    body = $('body');

    body.on('click','.newFone', function () {
        inputs('Fone', 'fone', 'fone');
    });

    body.on('click','.newAddress', function () {
        inputs('Address', 'address', 'address');
    });

    body.on('click','.newEmail', function () {
        inputs('Email', 'email', 'email');
    });

    body.on('click', '#remove', function () {
        $(this).parents('.cd').remove();
        return false;
    });

    body.on('click','.btn-custom',function(){
        $('.modal-title').text('Formulário de cliente');
        $.ajax({
            type: "get",
            cache: false,
            url: 'src/Request/Form.php',
            data: {data:''},
            success: function (data) {
                $('.modal-body').html(data).mask("999.999.999-99");
                body.find('.modal-body').find('.fone').mask("(99) 99999-9999");
                body.find('.modal-body').find(".cpf").mask("999.999.999-99");
                body.find('.modal-body').find(".cnpj").mask("99.999.999/9999-99");
                typeCustomer(body,body.find('.type'));
            }
        });
    });

    body.on('change','.type',function(){
        typeCustomer(body,this);
    });

    body.find('form.search').submit(function(){
        listar(body,body.find('#search').val());
        return false;
    });

    body.on('click','.btn_send',function(){

        to              = $('#sendTo').val();
        msg             = $('#msg').val();
        id              = $('#id').val();

        if(msg.length > 2 ) {
            $(this).prop('disabled',true);
            $.ajax({
                type: "post",
                cache: false,
                url: 'src/Request/Save.php',
                data: {to: to, msg: msg, id: id, acao: 'send-email'},
                beforeSend: function () {
                    $('.callBack')
                        .html(carregando('alert-info', 'Por favor aguarde, enviado email...'))
                        .slideDown('show');
                },
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal').modal('toggle');
                    listar(body,'');
                    callback(body, 'Emails enviado com sucesso!!!');
                }
            });
        }else {
            $('.callBack')
                .html('<div class="alert alert-danger">Campo nome e cpf/cnpj são obrigatórios</div>')
                .slideDown('show');
        }
    });

    body.on('click','.btn_save',function(){

        name = $('#first-name2').val();
        type  = $('#type').val();
        documentt  = $('#document').val();
        social_name     = $('#social_name').val();

        if(name.length > 2 && documentt.length >= 11) {
            id = $('#id').val();

            var fone = new Array();
            $.each($('input[id="fone"]'), function (key, value) {
                fone.push($(value).val());
            });

            var address = new Array();
            $.each($('input[id="address"]'), function (key, value) {
                address.push($(value).val());
            });

            var email = new Array();
            $.each($('input[id="email"]'), function (key, value) {
                email.push($(value).val());
            });

            $.ajax({
                type: "post",
                cache: false,
                url: 'src/Request/Save.php',
                data: {name: name, fone: fone, socialName:social_name, email: email, address: address, id: id,document:documentt, type:type},
                beforeSend: function () {
                    $('.callBack')
                        .html(carregando('alert-info', 'Por favor aguarde, salvando...'))
                        .slideDown('show');
                },
                success: function (data) {
                    $('.modal-body').html(data);
                    $('.modal').modal('toggle');
                    listar(body,'');
                    callback(body, 'Registro excluído com sucesso!!!');
                }
            });
        }else{
            $('.callBack')
                .html('<div class="alert alert-danger">Campo nome e cpf/cnpj são obrigatórios</div>')
                .slideDown('show');
        }
    });

    body.on('click','.btn_destroy',function() {
        self = $(this);
        if (confirm('Deseja excluir este registro ?')) {
            $.post('src/Request/Save.php', {
                acao: 'destroy',
                id: $(this).data('id')
            }, function () {
                self.parents('tr').remove();
                callback(body,'Registro excluído com sucesso!!!');
            });
        } else {
            return false;
        }
    });

    body.find('table').on('click','.btn-edit',function(){
        $('.modal-title').text('Formulário de atualização de cliente');
        $.ajax({
            type: "get",
            cache: false,
            url: 'src/Request/Form.php',
            data: {id:$(this).data('id')},
            beforeSend: function () {
                $('.modal-body')
                    .html(carregando('alert-info', 'Por favor aguarde...'))
                    .slideDown('show');
            },
            success: function (data) {

                $('.modal-body').html(data);
                body.find('.fone').mask("(99) 99999-9999");
                body.find('.modal-body').find('.fone').mask("(99) 99999-9999");
                body.find('.modal-body').find(".cpf").mask("999.999.999-99");
                body.find('.modal-body').find(".cnpj").mask("99.999.999/9999-99");

                typeCustomer(body,body.find('.type'));

            }
        });
    });

    body.find('table').on('click','.btn-envelope',function(){
        $('.modal-title').text('Formulário de envio de emails');
        $.ajax({
            type: "get",
            cache: false,
            url: 'src/Request/Envelope.php',
            data: {id:$(this).data('id')},
            beforeSend: function () {
                $('.modal-body')
                    .html(carregando('alert-info', 'Por favor aguarde...'))
                    .slideDown('show');
            },
            success: function (data) {
                $('.modal-body').html(data);
            }
        });
    });

    listar(body,'');

});

inputs = function(suffix,id,cls){
    var div = $('.dynamic'+suffix);
    $('<div class="cd"><p>'+
        '<div class="col-md-6"><input type="text" class="form-control '+cls+'" id="'+id+'" value="" placeholder="" /> </div>'+
        '<a class="btn btn-danger" id="remove">'+
        '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a>'+
        '</p></div>').appendTo(div).find('.fone').mask("(99) 99999-9999");
    return false
}

listar = function(body,search){
    $.ajax({
        type: "get",
        cache: false,
        url: 'src/Request/Reports.php',
        data:{search:search},
        beforeSend: function () {
            body.find('table tbody')
                .html('<tr><td colspan="7" align="center">'+carregando('alert-info', 'Por favor aguarde...')+'</td></tr>')
                .slideDown('show');
        },
        success: function (data) {
            body.find('table tbody').html(data);
        }
    });
}

carregando = function(tipo, msg){
    return "<div class='alert "+tipo+" animated shake'><img src='images/ajax-loader.gif'> "+msg+"</div>";
}

callback = function (body,msg) {
    body.find('.rtn').html('<div class="alert alert-success">'+msg+'</div>').slideDown();
    setTimeout(function () {
        vr = body.find('.rtn').slideUp();
    }, 2000);
}

typeCustomer = function(body, vl){
    if($(vl).val() == 1) {
        body.find('#label-document').text('CPF');
        body.find('.document').removeClass('cnpj');
        body.find('.document').addClass('cpf');
        body.find('.social_name').hide();
    }else {
        body.find('#label-document').text('CNPJ');
        body.find('.document').removeClass('cpf');
        body.find('.document').addClass('cnpj');
        body.find('.social_name').show();
    }
    //body.find('.document').val('');
    body.find('.modal-body').find(".cpf").mask("999.999.999-99");
    body.find('.modal-body').find(".cnpj").mask("99.999.999/9999-99");
}