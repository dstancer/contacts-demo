<script>
    $(document).ready(function () {
        var dataTables = $('#contacts').DataTable({
            "order": [[ 3, "asc" ]],
            "columns": [
                {"orderable": false, "responsivePriority": 1},
                null,
                {"responsivePriority": 1},
                {"responsivePriority": -1},
                {"responsivePriority": 2},
                {"orderable": false, "responsivePriority": 10},
                {"orderable": false, "responsivePriority": -1},
                {"orderable": false, "responsivePriority": 1}
            ]
        });

        $('#favoritesBtn').on('click', function () {
            dataTables.columns(1).search("favorite").draw();
            $(this).removeClass('btn-outline-secondary');
            $(this).addClass('btn-secondary');
            $('#allBtn').removeClass('btn-secondary');
            $('#allBtn').addClass('btn-outline-secondary');
        });

        $('#allBtn').on('click', function () {
            dataTables.columns(1).search("").draw();
            $(this).removeClass('btn-outline-secondary');
            $(this).addClass('btn-secondary');
            $('#favoritesBtn').removeClass('btn-secondary');
            $('#favoritesBtn').addClass('btn-outline-secondary');
        });

        $('#contactModalDestroy').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $('#id').val(button.data('id'));
            $('#method').val(button.data('method'));
            $('#key').val(button.data('key'));
        });

        $('#contactModalDestroySubmit').click(function(e){
            e.preventDefault();
            var url = $('#contactDestroyForm').prop('action') + '/' + $('#id').val() + '/destroy';

            $('#contactModalDestroy').modal('toggle');
            location.replace(url);
        });

        $(".alert").delay(3000).slideUp(200, function() {
            $(this).alert('close');
        });
    });
</script>