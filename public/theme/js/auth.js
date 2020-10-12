class Auth{
    signin(){
        $.post(baseUrl+'/signin',{_token:token,username:$('#username').val(),password:$('#password').val()}).done(function(data){
            var obj = JSON.parse(data);
            if(obj.status){
                window.location.reload();
            }else{
                login();
                setTimeout(function () { $('.login_error').html('<span style="color:red;font-size: 10px;">'+obj.message+'</span>') },500)

                $('#username').focus()
            }
        });
    }

    signup(){
        $.post(baseUrl+'/signup',{
            _token:token,
            phone_number:$('#phone').val(),
            email:$('#email').val(),
            password:$('#password').val()})
            .done(function(data){
                var obj = JSON.parse(data);
                if(obj.status){
                    window.location.reload();
                }else{
                    register();
                    setTimeout(function () { $('.login_error').html('<span style="color:red;font-size: 10px;">'+obj.message+'</span>') },500)
                    $('#username').focus()
                }
            });
    }

    signout(){
        $.post(baseUrl+'/signout',{_token:token}).done(function(data){
            window.location.reload();
        });
    }

    forgotpassword(){
        $.post(baseUrl+'/forgotpassword',{_token:token,phone:$('#phone').val()}).done(function(data){
            var obj = JSON.parse();
            return obj;
        });
    }

    forgotAuth(){
        $.post(baseUrl+'/forgotauth',{_token:token,otp:$('#otp').val()}).done(function(data){
            var obj = JSON.parse();
            return obj;
        });
    }

    restPassword(){
        $.post(baseUrl+'/reset',{_token:token,password:$('#password').val(),confirmpassword:$('#confirmpassword').val()}).done(function(data){
            var obj = JSON.parse();
            return obj;
        });
    }



}

const auth = new Auth;

