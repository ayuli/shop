$(".btn").click(function(e){
    e.preventDefault();
    var cart_id = $(this).attr('cart_id');
    // console.log(cart_id)
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url     :   '/cart/del',
        type    :   'post',
        data    :   {cart_id:cart_id},
        dataType:   'json',
        success :   function(d){
            // console.log(d)
            if(d.error==301){
                window.location.href=d.url;
            }else{

                alert(d.msg);
            }
        }
    });
    $(this).parents('tr').remove()
});