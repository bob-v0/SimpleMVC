$("doucment").ready(function() {

    // login
    $("#login_username").focus(function() {
        this.value = "";
    });

    $("#login_username").focusout(function() {
        //alert("length: " + $("#login_username").text());
        if(this.value == "")
            this.value = "username";
    });

    $("#login_password").focus(function() {
        this.type = "password";
        this.value = "";
    });

    $("#login_password").focusout(function() {
        if(this.value == "") {
            this.type = "text";
            this.value = "password";
        }
    });

    // search
    $("#search_text").focus(function() {
        this.value = "";
    });

    $("#search_text").focusout(function() {
        if(this.value == "") {
            this.value = "search site";
        }
    });

});


