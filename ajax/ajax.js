$(document).ready(function() {

    $.ajax({
        method: "PUT",
        url: "api/product",
        data: JSON.stringify({
            token: "berat"
        }),
        success: function(e) {
            alert(e);
        },
        error: function(e) {
            alert("s");
        }
    });

});