$(document).ready(function()
{   
    var loadedScripts = [];
    // intial filling of content and return to home
    getContentPost('landing',function(data){
        $('#content').html(data);
    });
    $('#nav-title').on('click',function(){
        getContentPost('landing',function(data){
            $('#content').html(data);
        });
    });
    $(window).resize(function(){
        contentSizeCheck();
    });
    //-----------------------------------------------------------------------
    //                       ::NAVBAR HANDLER::
    //-----------------------------------------------------------------------
    // sign-in and register dropdowns
    controlDropdown('.dropdown-btn');
    
    //-----------------------------------------------------------------------
    //                      ::SIDEBAR HANDLER::
    //-----------------------------------------------------------------------
    $('#sidebar').toggleClass('active'); // close on load

    // closes everything when sidebar is shrunk
    $(".sidebar-drop-btn").on('click',function(){
        if($('#sidebar').hasClass('active')){
            $('#sidebar').toggleClass('active');
        }
        contentSizeCheck();
    });
    $("#sidebarToggle").on('click',function()
    {
        // if sidebar is active (closed) then open it up
        if($('#sidebar').hasClass('active'))
        {
            $('#sidebar').removeClass('active');    
            // shuffle content over when bar is opened
            contentSizeCheck();       
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
            // shuffle content back when bar is closed
            contentSizeCheck();
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
        contentSizeCheck();
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
        contentSizeCheck();
    });
    // grabs projects
    $('#tips-tracker-btn').on('click',function(){
        getContentPost('tips-tracker',function(data){
            $('#content').html(data);
        });
    });
    $('#maps-btn').on('click',function(){
        // if the scripts already loaded dont load it again
        if(loadedScripts.includes('googlemaps')){
            getContentPost('maps',function(data){
                $('#content').html(data);
                initMap();
            });

        }else{
            loadedScripts.push('googlemaps');
            getScriptPost('GoogleMaps',function(data){
                $.getScript(data,function(){
                    getContentPost('maps',function(data){
                        $('#content').html(data);
                        initMap();
                    });
                });
            });
        }

    });
 
    // gotta work here
    
    $('#about-btn').on('click',function(){
        getContentPost('about',function(data){
            $('#content').html(data);
        });
    });
    // TODO: set this up to only be included if not logged in
    // handles all sign in stuff
    //-----------------------------------------------------------------------
    //                      ::LOGGED OUT HANDLER::
    //-----------------------------------------------------------------------
    // handles signing in
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
        location.reload();
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
        var postR = $.ajax({
            url: Nurl,
            method:'POST',
            data: JSON.stringify({'action':'register','uname': uname, 'pass': pass, 'email': email}),
            contentType : 'application/json',
            async:false
        });
        var result = JSON.parse(postR.responseText);
        // need to put in failed registration messages here
        // handle login with new user_id
        if(result.user_id > 0){
            var Nurl = document.URL + "index.php?";
            var postR = $.ajax({
                url: Nurl,
                method: 'POST',
                data: JSON.stringify({'action':'login','uname': uname, 'pass': pass}),
                contentType : 'application/json',
                async: false
            });
            location.reload();
        }
    });
    //-----------------------------------------------------------------------
    //                      ::LOGGED IN HANDLER::
    //-----------------------------------------------------------------------
    $('#account-btn').on('click',function(){
        // gonna need to create an account options either sidebar or dropdown
            // Options:
                // change password
                // change email
                // edit information
        console.log('hello :D');
    });
    $('#logout-btn').on('click',function(){
        var Nurl = document.URL + "index.php?";
        
        var postR = $.ajax({
            url: Nurl,
            method: 'POST',
            data: JSON.stringify({'action':'logout'}),
            contentType : 'application/json',
            async: false
        });
        location.reload();
    });
    //-----------------------------------------------------------------------
    //                      ::CONTENT HANDLER::
    //-----------------------------------------------------------------------
    var map;
    function initMap(){
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.387, lng: 150.644},
            zoom: 8
        });
    }
});

// custom functions

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
function getContentPost(content,func,sync = true){
    var Nurl = document.URL + "index.php?";
    $.ajax({
        url:Nurl,
        method: 'POST',
        data: JSON.stringify({'action':'content','toGet':content}),
        contentType : 'application/json',
        async: sync,
        success: func
    });
}
function getScriptPost(script,func,sync = true){
    var Nurl = document.URL + "index.php?";
    $.ajax({
        url:Nurl,
        method: 'POST',
        data: JSON.stringify({'action':'script','toGet':script}),
        datatype: "script",
        async: sync,
        success: func
    });
}
function contentSizeCheck(){
    if($('#sidebar').css('display') == 'none')
    {
        $('#content').css('margin-left','0px');
    }else if($('#sidebar').hasClass('active')){
        $('#content').css('margin-left','80px');
    }else{
        $('#content').css('margin-left','250px');
    }
}
function initMap(){
    // var latlng = new google.maps.LatLng(43.6532,79.3832);
    map = new google.maps.Map(document.getElementById('map'),{
        center: {lat: 43.6532 , lng: 79.3832},
        zoom: 8
    });
}
function controlDropdown(obj){
    $(obj).on('click',function(event){
        // retrieve clicked elements id
        var element = '#' + event.target.id;
        // get the id of the data-toggle parameter
        var target = '#' + $(element).data('toggle');
        // check through data-group and close any open
        if($(element).data('group') != null){
            // get each element with selector
            $(obj).each(function(){
                // if not the element we clicked on
                if('#' + this.id != element){
                    // get the data-toggle target
                    var target = '#' + $(this).data('toggle');
                    if($(target).css('visibility') == 'visible'){
                        $(target).css('visibility','hidden');
                    }
                }
            });
        }
        // make this visible or close if already visible
        if($(target).css('visibility') == 'visible'){
            $(target).css('visibility','hidden');
        }else{
            $(target).css('visibility','visible');
        }
        
    });
}

//# sourceURL=index.js
