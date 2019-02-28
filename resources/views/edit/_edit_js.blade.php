<script>
    $(document).ready(function () {
        var dataTables = $('#numbers').DataTable({
            "order": [[ 1, "asc" ]],
            "columns": [
                {"orderable": false},
                {"responsivePriority": 0},
                {"responsivePriority": -1},
                {"orderable": false}
            ],
            "info": false,
            "paging": false,
            "searching": false
        });
    });

    $('#favorite').bootstrapToggle({
        on: 'Yes',
        off: 'No',
        offstyle: 'warning'
    });

    $('#phoneModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#label').val(button.data('label'));
        $('#number').val(button.data('number'));
        $('#id').val(button.data('id'));
        $('#contactid').val(button.data('contactid'));
        $('#method').val(button.data('method'));
        $('#key').val(button.data('key'));
    });

    $('#phoneModalDestroy').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#label').val(button.data('label'));
        $('#number').val(button.data('number'));
        $('#id').val(button.data('id'));
        $('#contactid').val(button.data('contactid'));
        $('#method').val(button.data('method'));
        $('#key').val(button.data('key'));
    });


    $('#phoneModalDestroySubmit').click(function(e){
        e.preventDefault();
        var url = $('#phoneForm').prop('action') + '/' + $('#contactid').val() + '/phone/' + $('#id').val() + '/destroy';

        $.ajax({
            url: url,
            type: 'get',
            headers: { "X-Authorization": $('#key').val()},
            processData: false,
            success: function( data, textStatus, jQxhr ){
                location.reload();
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
        $('#phoneModalDestroy').modal('toggle');

    });

    $('#phoneModalSubmit').click(function(e){
        e.preventDefault();
        var method = $('#method').val();
        if(method === 'update') {
            var url = $('#phoneForm').prop('action') + '/' + $('#contactid').val() + '/phone/' + $('#id').val() + '/update';
        } else if(method === 'create') {
            var url = $('#phoneForm').prop('action') + '/' + $('#contactid').val() + '/phone/create';
        }
        $.ajax({
            url: url,
            dataType: 'json',
            type: 'post',
            contentType: 'application/json',
            headers: { "X-Authorization": $('#key').val()},
            data: JSON.stringify( { "label": $('#label').val(), "number": $('#number').val()} ),
            processData: false,
            success: function( data, textStatus, jQxhr ){
                var succesModal = $('#successModal').modal('toggle');
                succesModal.on('hidden.bs.modal', function (e) {
                    location.reload();
                })
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
        $('#phoneModal').modal('toggle');
    });

    $('#photo').on('change',function(){
        //get the file name
        var fileName = $(this).val().replace(/C:\\fakepath\\/i, '');
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    });
</script>