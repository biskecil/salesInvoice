document.getElementById("transDate").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("customer").focus();
    }
});
document.getElementById("customer").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("pembeli").focus();
    }
});
document.getElementById("pembeli").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("alamat").focus();
    }
});
document.getElementById("alamat").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("phone").focus();
    }
});
document.getElementById("phone").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("eventSelect").focus();
    }
});
$('#eventSelect').on('select2:select', function (e) {
    const value = e.params.data.id;     
    $('#grosir').focus();
});