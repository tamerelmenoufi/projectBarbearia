$(function(){

    $("li[acao]").click(function(){
        acao = $(this).attr("acao");
        target = $(this).attr("target");
        $.ajax({
            url:acao,
            success:function(dados){
                $(".popup div").html(dados);
                $(".popup").css("display","block");
                $("body").css("overflow","hidden");
            }
        });
    });

    $(".popup span").click(function(){
        $(".popup div").html('');
        $(".popup").css("display","none");
        $("body").css("overflow","scroll");
        window.location.href='./';
    });

})