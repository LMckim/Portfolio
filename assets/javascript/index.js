$(document).ready(function()
{
    // handles sidebar
    $('#sidebar').toggleClass('active'); // close on load

    // closes everything when sidebar is shrunk
    $(".sidebar-btn").on('click',function(){
        if($('#sidebar').hasClass('active')){
            $('#sidebar').toggleClass('active');
        }
    });
    $("#sidebarToggle").on('click',function()
    {
        // if sidebar is active (closed) then open it up
        if($('#sidebar').hasClass('active'))
        {
            $('#sidebar').removeClass('active');           
            // otherwise close it and all sub menus
        }else{
            $('#sidebar').addClass('active');
            // home dropdown
            $('#homeSubMenu-a').addClass('collapsed');
            $('#homeSubMenu-a').attr('aria-expanded','false'); 
            $('#homeSubMenu-ul').removeClass('show');
            // projects dropdown
            $('#projectSubMenu-a').addClass('collapsed');
            $('#projectSubMenu-a').attr('aria-expanded','false'); 
            $('#projectSubMenu-ul').removeClass('show');
        }
    });
    // handles sub menus
    $('#homeSubMenu-a').on('click',function(){
        if($('#homeSubMenu-a').hasClass('collapsed')){
            $('#homeSubMenu-a').removeClass('collapsed');
            $('#homeSubMenu-a').attr('aria-expanded','true'); 
            $('#homeSubMenu-ul').addClass('show') 
        }else{
            $('#homeSubMenu-a').addClass('collapsed');
            $('#homeSubMenu-a').attr('aria-expanded','false'); 
            $('#homeSubMenu-ul').removeClass('show')
        }
    });
    $('#projectSubMenu-a').on('click',function(){
        if($('#projectSubMenu-a').hasClass('collapsed')){
            $('#projectSubMenu-a').removeClass('collapsed');
            $('#projectSubMenu-a').attr('aria-expanded','true'); 
            $('#projectSubMenu-ul').addClass('show') 
        }else{
            $('#projectSubMenu-a').addClass('collapsed');
            $('#projectSubMenu-a').attr('aria-expanded','false'); 
            $('#projectSubMenu-ul').removeClass('show')
        }
    });
    
    // handles all sign in stuff
    $("#sign-in-submit").on('click',function(){

        var uname;
        if($('#sign-in-uname').val() != "" ){
            uname = $('#sign-in-uname').val();
        }else{
            $('#sign-in-uname').attr('placeholder','You need a User Name');
            return;
        }
        var pass;
        if($('#sign-in-pass').val() != ""){
            pass = $('#sign-in-pass').val();
        }else{
            $('#sign-in-').attr('placeholder','You need a Password');
            return;
        }
        var Nurl = document.URL + "index.php?";
        $.ajax({
            url: Nurl,
            method:'post',
            data: JSON.stringify({'action':'login','uname':uname, 'pass':pass}),
            contentType : 'application/json'
        });
    });
    // handles all registration stuff
    $("#reg-submit").on('click',function(){

        var uname;
        if($('#reg-uname').val() != "" ){
            uname = $('#reg-uname').val();
        }else{
            $('#reg-uname').attr('placeholder','You need a User Name');
            return;
        }
        var pass;
        if($('#reg-pass').val() != "" && $('#reg-pass-c').val() != ""){
            if($('#reg-pass').val() !== $('#reg-pass-c').val())
            {
                $('#reg-pass').attr('placeholder','You need a Password');
                return;
            }else{
                pass = $('#reg-pass').val();
            }
        }else{
            $('#reg-pass').attr('placeholder','Fill out both passwords');
            return;
        }
        var email;
        if($('#reg-email').val() != ""){
            // check email against regex
            var temp = validateEmail($('#reg-email').val());
            if(temp == true){
                email = $('#reg-email').val();
            }else{
                $('#reg-email').attr('placeholder','Invalid Email');
                return;
            }

        }else{
            $('#reg-email').attr('placeholder','Enter an email');
            return;
        }
        var Nurl = document.URL + "index.php?";
        var response = $.ajax({
            url: Nurl,
            method:'post',
            data: JSON.stringify({'action':'register','uname': uname, 'pass': pass, 'email': email}),
            contentType : 'application/json'
        });
        console.log(response);
        var r = $.post(Nurl,JSON.stringify({'action':'register','uname': uname, 'pass': pass, 'email': email}),function(){
            console.log('yes');
        });
        console.log(r);
    });

});

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}