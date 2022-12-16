<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['telefone_valido']){

        $_POST['telefone'] = $_POST['telefone_valido'];
        $query = "select * from clientes where telefone = '{$_POST['telefone']}'";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result)){
            $d = mysqli_fetch_object($result);
            $_SESSION['AppCliente'] = $d->codigo;
        }else{
            mysqli_query($con, "insert into clientes set telefone = '{$_POST['telefone']}', data_cadastro = NOW(), telefone_confirmado = '1'");
            $_SESSION['AppCliente'] = mysqli_insert_id($con);
        }

        if($_SESSION['AppCliente']/* && $_SESSION['AppPedido']*/){
            /////////////////INCLUIR O REGISTRO DO PEDIDO//////////////////////
            $query = "SELECT codigo FROM vendas WHERE cliente = '{$_SESSION['AppCliente']}' /*AND mesa = '{$_SESSION['AppPedido']}'*/ AND deletado != '1' AND operadora_situacao = '' LIMIT 1";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result)) {
                //$queryInsert = "SELECT codigo FROM vendas WHERE cliente = '{$_SESSION['AppCliente']}' AND mesa = '{$_SESSION['AppPedido']}' AND deletado != '1' LIMIT 1";
                list($codigo) = mysqli_fetch_row(mysqli_query($con, $query));
                $_SESSION['AppVenda'] = $codigo;
            } else {
                mysqli_query($con, "INSERT INTO vendas SET cliente = '{$_SESSION['AppCliente']}', /*mesa = '{$_SESSION['AppPedido']}',*/ data_pedido = NOW()");
                $_SESSION['AppVenda'] = mysqli_insert_id($con);
            }
            /////////////////////////////////////////////////////////////////
        }

        echo json_encode([
            "AppCliente" => $_SESSION['AppCliente'],
            "AppVenda" => $_SESSION['AppVenda']
        ]);

        exit();
    }

    if($_POST['envio'] == 'sms'){

        $cod = $_POST['cod_confirm'];

        $content = http_build_query(array(

            'num' => '55'.str_replace(array(' ','(',')','-'), false, trim($_POST['telefone'])),
            'msg' => "BKManaus Informa: Seu codido de confirmacao e {$cod}.",

        ));

        $context = stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'content' => $content,
            )
        ));

        $result = file_get_contents('http://moh1.com.br/fnbk2.php', null, $context);

        $retorno = ['status' => true, 'retorno' => json_decode($result)];

        $retorno = json_encode($retorno);
        echo $retorno;
        exit();

    }

    if($_POST['envio'] == 'whatsapp'){

        $cod = $_POST['cod_confirm'];
        $num = trim($_POST['telefone']);
        $msg = "BKManaus Informa: Seu codido de confirmacao é: *{$cod}*";

        $result = EnviarWapp($num,$msg);

        $retorno = ['status' => true, 'retorno' => ($result)];

        $retorno = json_encode($retorno);
        echo $retorno;

        exit();

    }



?>
<style>
    .CadastroTitulo{
        width:100%;
        position:fixed;
        padding-left:70px;
        top:0px;
        height:60px;
        padding-top:15px;
        background:#f5ebdc;
        z-index:1;
    }
    #ClienteTeleofne{
        text-align:center !important;
        font-weight:bold !important;
    }
    div[texto]{
        font-size:10px;
        text-align:justify;
        margin-top:10px;
        margin-bottom:10px;
        color:#333;
    }
</style>

<div class="CadastroTitulo">
    <h4>Cadastro/Acesso</h4>
</div>

<div class="col">
    <div class="col-12"><div texto>Digite no campo abaixo o seu número de telefone celular/WhatsApp para o seu login de acesso ou para realizar o seu pré-cadastro.</div></div>
    <div class="col-12 mb-3">
        <input
            type="text"
            inputmode="numeric"
            autocomplete="off"
            class="form-control form-control-lg"
            id="ClienteTeleofne"
            placeholder="(__) _____-____"
        >
    </div>
    <div class="col-12 mb-3">
    <center><small>Selecione a opção para acesso/ativação<br>do seu cadastro.</small></center>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col">
                <button CadastrarCliente="whatsapp" chave="<?=date("His")?>" class="btn btn-secondary btn-block btn-lg">WhatsApp</button>
            </div>
            <div class="col">
                <button CadastrarCliente="sms" chave="<?=date("His")?>" class="btn btn-secondary btn-block btn-lg">SMS</button>
            </div>
        </div>
    </div>

</div>

<script>
    $(function(){

        $("#ClienteTeleofne").mask("(99) 99999-9999");

        $("button[CadastrarCliente]").click(function(){
            telefone = $("#ClienteTeleofne").val();
            envio = $(this).attr("CadastrarCliente");
            cod_confirm = $(this).attr("chave");

            if(telefone.length === 15){

                $.ajax({
                    url:"src/cliente/cadastro.php",
                    type:"POST",
                    dataType:"JSON",
                    data:{
                        telefone,
                        envio,
                        cod_confirm
                    },
                    success:function(dados){

                        // $.alert(dados.retorno);

                        if(dados.status){


                            //////////////////////////////////////////////////////


                            JanelaConfirmacao = $.confirm({
                                title: false,
                                content: '' +
                                '<form action="" class="formName">' +
                                '<div class="form-group">' +
                                '<label>Digite no campo abaixo o código enviado para o seu número.</label>' +
                                '<input type="text" placeholder="codigo" maxlength="6" inputmode="numeric" class="name form-control" required style="text-align:center; font-weight:bold;" />' +
                                '</div>' +
                                '</form>',
                                buttons: {
                                    formSubmit: {
                                        text: 'Ativar',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            var name = this.$content.find('.name').val();
                                            if(!name || name.length != 6){
                                                $.alert('Digite o codigo corretamente');
                                                return false;
                                            }else if(name === cod_confirm){
                                                $.ajax({
                                                    url:"src/cliente/cadastro.php",
                                                    type:"POST",
                                                    data:{
                                                        telefone_valido:telefone,
                                                    },
                                                    success:function(dados){

                                                        let retorno = JSON.parse(dados);

                                                        window.localStorage.setItem('AppCliente', retorno.AppCliente);
                                                        window.localStorage.setItem('AppVenda', retorno.AppVenda);

                                                        $.ajax({
                                                            url:"src/home/index.php",
                                                            success:function(dados){
                                                                $(".ms_corpo").html(dados);
                                                            }
                                                        });

                                                    }
                                                });
                                            }else{
                                                $.alert('Seu código não confere, tente novamente!');
                                                return false;
                                            }


                                        }
                                    },
                                    Cancelar: function () {
                                        $.confirm({
                                            content:"Deseja relamente cancelar a ativação?",
                                            title:false,
                                            buttons:{
                                                'SIM':function(){
                                                    JanelaConfirmacao.close();
                                                },
                                                'NÃO':function(){

                                                }
                                            }
                                        });
                                        return false;
                                    }
                                },
                                onContentReady: function () {
                                    // bind to events
                                    var jc = this;
                                    this.$content.find('form').on('submit', function (e) {
                                        // if the user submits the form by pressing enter in the field.
                                        e.preventDefault();
                                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                                    });
                                }
                            });


                            //////////////////////////////////////////////////////


                        }
                    }
                });







            }else{
                $.alert('Favor informe o número do seu telefone!');
            }


        });
    })
</script>