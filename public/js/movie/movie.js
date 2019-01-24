$('.btn-default').click(function (e) {
    e.preventDefault();
    alert();
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
            // console.log(d)
            if(d.errno==301){
                window.location.href=d.url;
            }else if(d.errno==5002){
                $('.alert').remove();
                $('h1').before("<div class='alert alert-danger' role='alert'>"+d.msg+"</div>")
            }else{
                $('.alert').remove();
                $('h1').before("<div class='alert alert-success' role='alert'>"+d.msg+"</div>")
            }
        }
    })

});