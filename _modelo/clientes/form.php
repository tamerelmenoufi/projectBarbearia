<?php
        include("{$_SERVER['DOCUMENT_ROOT']}/app/projectBarbearia/painel/lib/includes.php");

    if($_POST['acao'] == 'salvar'){

        $data = $_POST;
        $attr = [];

        unset($data['codigo']);
        unset($data['acao']);
        unset($data['senha']);
        $endereco = [];
        foreach ($data as $name => $value) {
            $end = substr($name,0,1);
            if($end == '_'){
                $endereco[] = substr($name,1,strlen($name)) ." = '" . addslashes($value) . "'";
            }
            $attr[] = "{$name} = '" . addslashes($value) . "'";
        }
        if($_POST['senha']){
            $attr[] = "senha = '" . md5($_POST['senha']) . "'";
        }

        $attr = implode(', ', $attr);


        if($_POST['codigo']){
            $query = "update clientes set {$attr} where codigo = '{$_POST['codigo']}'";
            mysqli_query($con, $query);
            $cod = $_POST['codigo'];
        }else{
            $query = "insert into clientes set data_cadastro = NOW(), {$attr}";
            mysqli_query($con, $query);
            $cod = mysqli_insert_id($con);
        }
        // titulo = '{$_POST['titulo']}', cliente = '{$_POST['cliente']}', data_cadastro = NOW()
        $endereco[] = "titulo = 'Novo', cliente = '" . $cod . "', data_cadastro = NOW()";
        $endereco = implode(', ', $endereco);
        $query = "INSERT INTO clientes_enderecos set {$endereco}";
        mysqli_query($con, $query);

        $_SESSION['cliente'] = $cod;
        $retorno = [
            'status' => true,
            'codigo' => $cod
        ];

        echo trim(json_encode($retorno));

        exit();
    }


    $query = "select a.*, (select count(*) from vendas where cliente = a.codigo and situacao != 'n') as vendas from clientes a where a.codigo = '{$_SESSION['cliente']}'";
    $result = mysqli_query($con, $query);
    $d = mysqli_fetch_object($result);
?>
<style>
    .Titulo<?=$md5?>{
        position:absolute;
        left:60px;
        top:8px;
        z-index:0;
    }
</style>
<h4 class="Titulo<?=$md5?>">Cadastro do Cliente</h4>
    <form id="form-<?= $md5 ?>">
        <div class="row">
            <div class="col">
                <h6>Dados de Identificação</h6>
                <div class="form-floating mb-3">
                    <input type="text" <?=(($d->vendas)?'disabled':'name="nome"')?> class="form-control" id="nome" placeholder="Nome completo" value="<?=$d->nome?>">
                    <label for="nome"> <i class="fa fa-user"></i>   Nome*</label>
                </div>
                <!-- <div class="form-floating mb-3">
                    <input type="text" <?=(($d->vendas)?'disabled':'name="cpf"')?> id="cpf" class="form-control" placeholder="CPF" value="<?=$d->cpf?>">
                    <label for="cpf">  <i class="fa fa-file"></i>   CPF*</label>
                </div> -->
                <div class="form-floating mb-3">
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" placeholder="Data de Nascimento" value="<?=$d->data_nascimento?>">
                    <label for="cpf"> <i class="fa fa-calendar-days"></i>   Data de Nascimento*</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="telefone" id="telefone" class="form-control" placeholder="telefone" value="<?=$d->telefone?>">
                    <label for="telefone"><i class="fa fa-mobile-screen"></i>   Telefone*</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="email" id="email" class="form-control" placeholder="E-mail" value="<?=$d->email?>">
                    <label for="email"> <i class="fa fa-envelope"></i>    E-mail</label>
                </div>





                <h6>Endereço</h6>
                <!-- Endereço -->
                <!-- <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="titulo" name="_titulo" placeholder="Título da Página" value="<?=$d->titulo?>">
                    <label for="titulo">Título do Endereço</label>
                    <div class="form-text">Digite o nome de identificação do endereço.</div>
                </div> -->

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="cep" name="_cep" placeholder="Título da Página" value="<?=$d->cep?>">
                    <label for="cep">CEP</label>
                    <div class="form-text">Digite o CEP do endereço</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="rua" name="_rua" placeholder="Título da Página" value="<?=$d->rua?>">
                    <label for="rua">Rua</label>
                    <div class="form-text">Digite o nome da Rua</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="numero" name="_numero" placeholder="Título da Página" value="<?=$d->numero?>">
                    <label for="numero">Número</label>
                    <div class="form-text">Informe o número da Casa / condomínio</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="bairro" name="_bairro" placeholder="Título da Página" value="<?=$d->bairro?>">
                    <label for="bairro">Bairro</label>
                    <div class="form-text">Informe o nome do Bairro</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="complemento" name="_complemento" placeholder="Título da Página" value="<?=$d->complemento?>">
                    <label for="complemento">Complemento</label>
                    <div class="form-text">Quadra, bloco, apartamento, ect</div>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="referencia" name="_referencia" placeholder="Título da Página" value="<?=$d->referencia?>">
                    <label for="referencia">Ponto de Referência</label>
                    <div class="form-text">Informe um local de referência para o seu endereço</div>
                </div>
                <!-- Endereco -->


            </div>
        </div>

        <div class="row">
            <div class="col">
                <div style="display:flex; justify-content:end">
                    <button type="submit" class="btn btn-success btn-ms" style="margin-right:3px">Salvar</button>
                    <button cancelar type="button" class="btn btn-danger btn-ms">Cancelar</button>
                    <input type="hidden" id="codigo" value="<?=$_SESSION['cliente']?>" />
                </div>
            </div>
        </div>
    </form>

    <script>
        $(function(){

            $("#cpf").mask("999.999.999-99");
            $("#telefone").mask("(99) 99999-9999");

            $('#form-<?=$md5?>').submit(function (e) {

                e.preventDefault();

                var codigo = $('#codigo').val();
                var campos = $(this).serializeArray();

                if (codigo) {
                    campos.push({name: 'codigo', value: codigo})
                }

                campos.push({name: 'acao', value: 'salvar'})


                $.ajax({
                    url:"clientes/form.php",
                    type:"POST",
                    dataType:"JSON",
                    // mimeType: 'multipart/form-data',
                    data: campos,
                    success:function(dados){

                        // console.log(dados);
                        // console.log(dados.status);

                        if(dados.status){
                            $.alert('Cadastro realizado com sucesso!');
                            $.ajax({
                                url:"calendario/home.php",
                                type:"POST",
                                success:function(dados){
                                    $(".LateralDireita").html(dados);
                                    // $("#paginaHome").html(dados);
                                    // let myOffCanvas = document.getElementById('offcanvasDireita');
                                    // let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                                    // openedCanvas.hide();
                                }
                            });
                        }else{
                            $.alert('Ocorreu um erro no cadastro.<br><h5>Quais motivos?</h5><li>Você pode já ter um cadastro conosco. Para confirmar, tente fazer o seu login, digitando o numero WhatsApp para receber o código de acesso.</li><li>Ou pode ter ocorrido um erro de conexão com o banco de dados. Neste caso, tente o cadastro mais tarde.</li>');
                        }
                    },
                    error:function(erro){

                        // $.alert('Ocorreu um erro!' + erro.toString());
                        //dados de teste
                    }
                });

            });


            $("button[cancelar]").click(function(){
                // $.ajax({
                //     url:"calendario/home.php",
                //     type:"POST",
                //     success:function(dados){
                //         $(".LateralDireita").html(dados);
                //     }
                // });

                let myOffCanvas = document.getElementById('offcanvasDireita');
                let openedCanvas = bootstrap.Offcanvas.getInstance(myOffCanvas);
                openedCanvas.hide();

            });

        })
    </script>