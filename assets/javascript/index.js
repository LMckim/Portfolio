$(document).ready(function()
{
    $("#sidebar").mCustomScrollbar(
    {
        theme: "minimal"
    });

    $("#sidebarToggle").on('click',function()
    {
        // open or close navbar
        if($('#sidebar'.hasClass('active'))){
            
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

});