$(document).ready(function()
{   
    var loadedScripts = [];
    // intial filling of content and return to home
    getContentPost('landing',function(data){
        $('#content').html(data);
        contentSizeCheck();
    });
    $('#nav-brand-text').on('click',function(){
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
    controlSidebar();    
    //-----------------------------------------------------------------------
    //                      ::SIDEBAR HANDLER::
    //-----------------------------------------------------------------------

    // home button
    $('#side-home').on('click',function(){
        getContentPost('landing',function(data){
            $('#content').html(data);
        });
    });
    
    // handles opening dropdown bar for projects
    $('#side-projects').on('click',function(){
        toggleShowChildren('#side-projects');

    });
   
    $('#projects-maps').on('click',function(){
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
    $('#projects-apis').on('click',function(){
        getContentPost('apis',function(data){
            $('#content').html(data);
        });
    });
    
    $('#side-about').on('click',function(){
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
    if($('#side-bar').css('display') == 'none')
    {
        $('#content').css('margin-left','0px');
    }else if($('#side-nav').hasClass('closed')){
        $('#content').css('margin-left','50px');
    }else{
        $('#content').css('margin-left','180px');
    }
}
function initMap(){
    var latlng = new google.maps.LatLng(43.6532,-79.3832);

    var map = new google.maps.Map(document.getElementById('map'),{
        center: latlng,
        zoom: 8
    });
}

function controlSidebar(){
    $('#nav-btn').on('click',function(){
        if($('#side-nav').hasClass('open')){
            if($(window).width() <= 480)
            {
                $('#side-bar').css('display','none');
                closeSidebar();
            }else{
                closeSidebar();
                contentSizeCheck();
            }
        
        }else{
            if($('#side-bar').css('display') == 'none')
            {
                $('#side-bar').css('display','block');
                openSidebar();
            }else{
                openSidebar();
                contentSizeCheck();
            }
        }
    });
    $('.side-btn').on('click',function(){
        if($('#side-nav').hasClass('open')){
            if($(window).width() <= 480)
            {
                $('#side-bar').css('display','none');
                closeSidebar();
            }else{
                closeSidebar();
                contentSizeCheck();
            }
        
        }else{
            if($('#side-bar').css('display') == 'none')
            {
                $('#side-bar').css('display','block');
                openSidebar();
            }else{
                openSidebar();
                contentSizeCheck();
            }
        }
        

    });
}
function openSidebar(){
    $('#side-nav').removeClass('closed')
    $('#side-nav').addClass('open');

    $('#side-nav').find('h3').css('display','block');
    $('#side-nav').find('a').css('display','');
    $('#side-bar').css('width','180px');
}
function closeSidebar(){
    $('#side-nav').removeClass('open')
    $('#side-nav').addClass('closed');

    $('#projects').find('div').each(function(){
        if($(this).hasClass('show')){
            $(this).removeClass('show');
            $(this).addClass('hidden');
        }
    });
    $('#side-nav').find('h3').css('display','none');
    $('#side-nav').find('a').css('display','none');
    $('#side-bar').css('width','50px');
}
function toggleShowChildren(element){
    let childID = '#' + $(element).data('toggle');

    $(childID).find('div').each(function(){
        if($(this).hasClass('hidden')){
            if($('#side-nav').hasClass('closed')){
                openSidebar();
                contentSizeCheck();
            }
            $(this).removeClass('hidden');
            $(this).addClass('show');
            
        }else if($(this).hasClass('show')){
            $(this).removeClass('show');
            $(this).addClass('hidden');
        }
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
