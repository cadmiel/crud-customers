$(document).ready(function(){

    body = $('body');

    body.on('click','.newFone', function () {
        inputs('Fone','fone');
    });

    body.on('click','.newAddress', function () {
        inputs('Address','address');
    });

    body.on('click','.newEmail', function () {
        inputs('Email','email');
    });

    body.on('click', '#remove', function () {
        $(this).parents('p').remove();
        return false;
    });

    body.on('click','.btn-custom',function(){
        $.ajax({
            type: "get",
            cache: false,
            url: 'src/Request/Form.php',
            data: {data:''},
            success: function (data) {
                $('.modal-body').html(data);
            }
        });
    });

    body.on('click','.btn_send',function(){
        to = $('#sendTo').val();
        msg  = $('#msg').val();
        id  = $('#id').val();

        $.ajax({
            type: "post",
            cache: false,
            url: 'src/Request/Save.php',
            data: {to:to,msg:msg,id:id,acao:'send-email'},
            beforeSend: function () {
                $('.callBack')
                    .html(carregando('alert-info', 'Por favor aguarde, salvando...'))
                    .slideDown('show');
            },
            success: function (data) {
                $('.modal-body').html(data);
                //$('.modal').modal('toggle');
                //listar(body);
                callback(body,'Emails enviado com sucesso!!!');
            }
        });
    });

    body.on('click','.btn_save',function(){

        name = $('#first-name2').val();
        id  = $('#id').val();

        var fone = new Array();
        $.each($('input[id="fone"]'),function(key,value){
            fone.push($(value).val());
        });

        var address = new Array();
        $.each($('input[id="address"]'),function(key,value){
            address.push($(value).val());
        });

        var email = new Array();
        $.each($('input[id="email"]'),function(key,value){
            email.push($(value).val());
        });

        $.ajax({
            type: "post",
            cache: false,
            url: 'src/Request/Save.php',
            data: {name:name,fone:fone,email:email,address:address, id:id},
            beforeSend: function () {
                $('.callBack')
                    .html(carregando('alert-info', 'Por favor aguarde, salvando...'))
                    .slideDown('show');
            },
            success: function (data) {
                $('.modal-body').html(data);
                $('.modal').modal('toggle');
                listar(body);
                callback(body,'Registro excluído com sucesso!!!');
            }
        });
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
            }
        });
    });

    body.find('table').on('click','.btn-envelope',function(){
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

    listar(body);

});

inputs = function(suffix,id){
    var div = $('.dynamic'+suffix);
    $('<p>'+
        '<input type="text" class="" id="'+id+'" value="" placeholder="" /> '+
        '<a class="btn btn-danger" href="javascript:void(0)" id="remove">'+
        '<span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a>'+
        '</p>').appendTo(div);
    return false
}

listar = function(body){
    $.ajax({
        type: "get",
        cache: false,
        url: 'src/Request/Reports.php',
        beforeSend: function () {
            body.find('table tbody')
                .html(carregando('alert-info', 'Por favor aguarde, enquanto gravamos...'))
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