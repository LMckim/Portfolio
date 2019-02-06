
// example jquery longform ajax request

var response = $.ajax({
    url: Nurl,
    method:'post',
    data: JSON.stringify({'action':'register','uname': uname, 'pass': pass, 'email': email}),
    contentType : 'application/json'
});
console.log(response);