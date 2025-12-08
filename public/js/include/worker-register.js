$(document).ready(function(){   
    $('#create-form-worker').submit(function(e){
        e.preventDefault();
        $('.btn-save-worker').attr('disabled', true);
        $('.btn-save-worker').val('Guardando...');

        let form = $(this);
        
        // $.post($(this).attr('action'), $(this).serialize(), function(data){
        $.post(form.attr('action'), $(this).serialize(), function(data){
            if(data.worker.id){
                toastr.success('Trabajador creado', 'Éxito');
                // $(this).trigger('reset');
                form[0].reset();
            }else{
                toastr.error(data.error, 'Error');
            }
        })
        .always(function(){
            $('.btn-save-worker').attr('disabled', false);
            $('.btn-save-worker').val('Guardar');
            $('#modal-create-worker').modal('hide');
        });
    });
});
