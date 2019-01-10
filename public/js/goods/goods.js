$("#add_cart_btn").click(function(e){
    e.preventDefault();
    var num = $("#goods_num").val();
    var goods_id = $("#goods_id").val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url     :   '/cart/add',
        type    :   'post',
        data    :   {goods_id:goods_id,num:num},
        dataType:   'json',
        success :   function(d){
            // console.log(d)
            if(d.errno==301){
                window.location.href=d.url;
            }else if(d.errno==5001){
                $('.alert').remove();
                $('h1').before("<div class='alert alert-warning' role='alert'>"+d.msg+"</div>")
            }else if(d.errno==5002){
                $('.alert').remove();
                $('h1').before("<div class='alert alert-danger' role='alert'>"+d.msg+"</div>")
            }else{
                $('.alert').remove();
                $('h1').before("<div class='alert alert-success' role='alert'>"+d.msg+"</div>")
            }
        }
    });
});