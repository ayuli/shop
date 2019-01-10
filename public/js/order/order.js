$('.btn-warning').click(function (e) {
    e.preventDefault();
    var va='';
    $('.inlineCheckbox').each(function (index) {
        var _this = $(this);
        if(_this.prop('checked')==true){
            va+= _this.val()+',';
        }
    })
    var order_id=
    $.ajax({
        headers     :   {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url         :   '/order/add',
        type        :   'post',
        data        :   {cart_id:va},
        dataType    :   'json',
        success     :   function (d) {
            console.log(d)
            // if(d.error==301){
            //     window.location.href=d.url;
            // }else{
            //     location.href='/order/pay/'+va;
            // }
        }
    })

});