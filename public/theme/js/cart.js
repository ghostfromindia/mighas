class Cart {
    constructor(){
        this.token = $('#_token').attr('content');
    }

    cartcount(){
        $.post(baseUrl+'/cart/count',{_token:this.token}).done(function (data) {
            var obj = JSON.parse(data);
                $('.cartcount').html('<span style="color: green;">'+obj.count+'</span>')
            setTimeout(function () {
                $('.cartcount').html('<span style="color: black;">'+obj.count+'</span>')
            },750)

        })
    }

    carttotal(){
        $.post(baseUrl+'/cart/total',{_token:this.token}).done(function (data) {
            var obj = JSON.parse(data);
            $('.carttotal').html('<span style="color: green;"> ₹'+numberWithCommas(Math.round(obj.total))+'</span>')
            setTimeout(function () {
                $('.carttotal').html('<span style="color: black;"> ₹'+numberWithCommas(Math.round(obj.total))+'</span>')
            },750)

        })
    }

    add(id,qty=null) {
        $.post(baseUrl+'/cart/',{product:id,qty:qty,_token:this.token}).done(function(data){
            var obj = JSON.parse(data);
            if(obj.status){
                let instance = new Cart;
                instance.cartcount();
                instance.carttotal();
                $('#add-to-cart-'+id).html('Added! <i class="fas fa-check-circle"></i>');
                let unit = 'units';
                if(obj.qty == 1){unit = 'unit'}
                $('#add-to-cart-message-'+id).html(obj.qty+' '+unit+' '+'in cart');
            }else{
                alerts.error('Failed!!','Please try again later');
            }
        })
    }


}
const cart = new Cart();