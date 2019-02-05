$(document).ready(function()
{
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

    $("#sign-in-submit").on('click',function(){
        var uname = $('#sign-in')[0][0].value;
        var pass = $('#sign-in')[0][1].value;
        var subUrl = "index.php?login" + '?' + uname + '?' + pass;
        $.post(subUrl);
    })

});