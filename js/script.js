(function() {
    var button = document.getElementsByClassName("butt");

$(button).on("click", butAct);

    function butAct() {

        if (this.id == "add") {
            document.location.href = "add.php";
            } else if (this.id == "upd") {
            document.location.href = "update.php";
        }
    }
})();

$(document).ready(function() {
    var theHREF;

    $( "#dialog-confirm" ).dialog({
        resizable: false,
        height:160,
        width:500,
        autoOpen: false,
        modal: true,
        buttons: {
            "Oui": function() {
                $( this ).dialog( "close" );
                window.location.href = theHREF;
            },
            "Annuler": function() {
                $( this ).dialog( "close" );
            }
        }
    });
})