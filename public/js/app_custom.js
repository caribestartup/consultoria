

$(document).on('click', "form.deletecustom button", function(e) {
    var _this = $(this);
    e.preventDefault();
    swal({
        title: 'Are you sure?', // Opération Dangereuse
        text: 'Are you sure to continue ?', // Êtes-vous sûr de continuer ?
        type: 'error',
        showCancelButton: true,
        confirmButtonColor: 'null',
        cancelButtonColor: 'null',
        confirmButtonClass: 'btn btn-danger',
        cancelButtonClass: 'btn btn-primary',
        confirmButtonText: 'Yeah, sure!', // Oui, sûr
        cancelButtonText: 'Cancel', // Annuler
    }).then(res => {
        if (res.value) {
            _this.closest("form").submit();
        }
    });
});
