$(document).ready(function()
{
    // handles sidebar
    $('#sidebar').toggleClass('active');
    $("#sidebar").mCustomScrollbar(
    {
        theme: "minimal"
    });

    $("#sidebarToggle").on('click',function()
    {
        // open or close navbar
        if($('#sidebar').hasClass('active')){
            $('#sidebar').toggleClass('active');
        }else{
            $('#sidebar').toggleClass('active');
        }
    });
    $(".sidebar-btn").on('click',function(){
        if($('#sidebar').hasClass('active')){
            $('#sidebar').toggleClass('active');
        }
    });
    $("#tips-tracker").on('click',function(){
        $.get("index.php?tips-tracker");
    });

    // handles all sign in stuff
    $("#sign-in-submit").on('click',function(){

        var uname;
        if($('#sign-in-uname').val() != "" ){
            uname = $('#sign-in-uname').val();
        }else{
            // popper about uname field
        }
        var pass;
        if($('#sign-in-pass').val() != ""){
            pass = $('#sign-in-pass').val();
        }else{
            // popper about both pass fields
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
            // popper about uname field
        }
        var pass;
        if($('#reg-pass').val() != "" && $('#reg-pass-c').val() != ""){
            if($('#reg-pass') !== $('#reg-pass-c').val())
            {
                // popper about different passwords
            }else{
                pass = $('#reg-pass').val();
            }
        }else{
            // popper about both pass fields
        }
        var email;
        if($('#reg-email').val() != ""){
            // check email against regex
            email = $('#reg-email').val();
        }
        var Nurl = document.URL + "index.php?";
        $.ajax({
            url: Nurl,
            method:'post',
            data: JSON.stringify({'action':'register','uname': uname, 'pass': pass, 'email': email}),
            contentType : 'application/json'
        });
    });

});