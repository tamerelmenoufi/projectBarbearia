<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'salvar'){

        if ($_POST['codigo']) {
            mysqli_query($con, "UPDATE clientes_enderecos SET
                        nome = '{$_POST['nome']}',
                        rua = '{$_POST['rua']}',
                        numero = '{$_POST['numero']}',
                        bairro = '{$_POST['bairro']}',
                        cep = '{$_POST['cep']}',
                        complemento = '{$_POST['complemento']}',
                        referencia = '{$_POST['referencia']}',
                        coordenadas = ''
                        WHERE codigo = '{$_POST['codigo']}'
                        ");
        } else {
            mysqli_query($con, "update clientes_enderecos set padrao = '0' where cliente = '{$_SESSION['AppCliente']}'");
            mysqli_query($con, "INSERT INTO clientes_enderecos SET
                        cliente = '{$_SESSION['AppCliente']}',
                        nome = '{$_POST['nome']}',
                        rua = '{$_POST['rua']}',
                        numero = '{$_POST['numero']}',
                        bairro = '{$_POST['bairro']}',
                        cep = '{$_POST['cep']}',
                        complemento = '{$_POST['complemento']}',
                        referencia = '{$_POST['referencia']}',
                        padrao = '1'
                        ");

        }

        echo json_encode([
            "status" => true,
        ]);

        exit();
    }

    $query = "select * from clientes_enderecos where codigo = '{$_POST['cod']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);

?>

<div class="col">
    <div class="col-12">Cadastro/Editar Endereço</div>

    <div class="col-12 mb-3">
        <label for="rua">Nome <small>Aplelido para o endereço</small>*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="nome" value="<?=$d->nome?>">
    </div>
    <div class="col-12 mb-3">
        <label for="rua">Rua*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="rua" value="<?=$d->rua?>">
    </div>
    <div class="col-12 mb-3">
        <label for="numero">Número*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="numero" value="<?=$d->numero?>">
    </div>
    <div class="col-12 mb-3">
        <label for="bairro">Bairro*</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="bairro" value="<?=$d->bairro?>">
    </div>
    <div class="col-12 mb-3">
        <label for="bairro">CEP*</label>
        <input type="text" autocomplete="off" inputmode="numeric" class="form-control form-control-lg" id="cep" value="<?=$d->cep?>">
    </div>
    <div class="col-12 mb-3">
        <label for="complemento">Condomínio/Edifício/Complemento</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="complemento" value="<?=$d->complemento?>">
    </div>
    <div class="col-12 mb-3">
        <label for="referencia">Ponto de Referência</label>
        <input type="text" autocomplete="off" class="form-control form-control-lg" id="referencia" value="<?=$d->referencia?>">
    </div>

    <div class="col-12 mb-3">
        <button CadastrarCliente cod="<?=$d->codigo?>" class="btn btn-secondary btn-block btn-lg">Salvar</button>
    </div>
</div>

<script>
    $(function(){

        $("#ClienteTeleofne").mask("(99) 99999-9999");
        $("#cep").mask("99999-999");

        $("button[CadastrarCliente]").click(function(){
            nome = $("#nome").val();
            rua = $("#rua").val();
            numero = $("#numero").val();
            bairro = $("#bairro").val();
            cep = $("#cep").val();
            complemento = $("#complemento").val();
            referencia = $("#referencia").val();
            codigo = $(this).attr("cod");

            if(
                nome &&
                rua &&
                numero &&
                bairro &&
                cep
            ){
                $.ajax({
                    url:"src/cliente/endereco_form.php",
                    type:"POST",
                    data:{
                        nome,
                        rua,
                        numero,
                        bairro,
                        cep,
                        complemento,
                        referencia,
                        codigo,
                        acao:'salvar'
                    },
                    success:function(dados){

                        let retorno = JSON.parse(dados);
                        if(retorno.status){

                            retorno = $("body").attr("retorno");
                            local = ((retorno)?retorno:"src/cliente/enderecos.php");
                            $("body").attr("retorno",'');
                            $.ajax({
                                url:"componentes/ms_popup_100.php",
                                type:"POST",
                                data:{
                                    local,
                                },
                                success:function(dados){
                                    PageClose(2);
                                    $(".ms_corpo").append(dados);
                                }
                            });

                        }else{
                            $.alert('Ocorreu um erro!');
                        }

                    }
                });
            }else{
                $.alert('Favor Preencher os campos obrigatórios*!');
            }

        });
    })
</script>