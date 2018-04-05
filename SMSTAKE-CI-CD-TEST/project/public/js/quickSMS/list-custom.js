var manageScheduledTable = $('#manageScheduledTable').DataTable({
    processing: true,
    serverSide: true,
    stateSave: true,
    "lengthMenu": [[1, 10, 25, 50, 100, -1], [1, 10, 25, 50, 100, "Show All"]],
    "pageLength": 10,
    ajax: {
        url: dataTableURL,
        data: function (d) {
            d.status = $('#search-status').val();
            d.option = $('#search-option').val();
            d.startDate = $('#start-date').val();
            d.endDate = $('#end-date').val();
            d.senderId = $('#sender-id').val();
        }
    },
    columns: [
        {data: 'DT_Row_Index', name: 'DT_Row_Index', 'searchable': false, 'ordering': false, 'width': '8%'},
        {data: 'text_message', name: 'text_message', 'width': '20%'},
        {data: 'sender_name', name: 'sender_name', 'width': '12%'},
        {data: 'credit', name: 'credit', 'width': '12%'},
        {data: 'date_scheduled', name: 'date_scheduled', 'width': '12%'},
        {data: 'created_at', name: 'created_at', 'width': '12%'},
        {data: 'status', name: 'status', 'width': '16%', 'searchable': false, 'ordering': false}
    ],
    "columnDefs": [
        {"orderable": false, "targets": 0},
        {"className": "dt-center", "targets": "_all"}
    ],
    "pageLength": 48,
    "searching": false,
    searchDelay: 1200,
    "lengthChange": false,
    oLanguage: {sProcessing: "<div class='loader'></div>"}
});

$(document).ready(function () {
    $('#start-date, #end-date').datepicker({
        format: "yyyy-mm-dd"
    });

    $('body')
        .off('change', '#search-option')
        .on('change', '#search-option', function (event) {
            event.preventDefault();
            var filterSelected = $(this).val();

            if (filterSelected == 3) {
                $('.text-filter').show();
                $('.date-filter').hide();
                $('#start-date').val('');
                $('#end-date').val('');
            } else if (filterSelected == 1 || filterSelected == 2) {
                $('.date-filter').show();
                $('.text-filter').hide();
                $('#start-date').val('');
                $('#end-date').val('');
            } else {
                $('#start-date').val('');
                $('#end-date').val('');
                $('.text-filter').hide();
                $('.date-filter').hide();
            }
            manageScheduledTable.draw();
        })

        .off('change', '#search-status')
        .on('change', '#search-status', function (event) {
            event.preventDefault();
            manageScheduledTable.draw();
        })

        .off('change', '#start-date')
        .on('change', '#start-date', function (event) {
            event.preventDefault();
            manageScheduledTable.draw();
        })

        .off('change', '#end-date')
        .on('change', '#end-date', function (event) {
            event.preventDefault();
            if($('#start-date').val())
                manageScheduledTable.draw();
        })

        .off('keyup', '#sender-id')
        .on('keyup', '#sender-id', function (event) {
            event.preventDefault();
            manageScheduledTable.draw();
        })

        .off('click', '#reset')
        .on('click', '#reset', function (event) {
            event.preventDefault();
            $('#search-option').val('');
            $('#search-status').val('');
            $('#sender-id').val('');
            $('#start-date').val('');
            $('#end-date').val('');
            $('.text-filter').hide();
            $('.date-filter').hide();
            manageScheduledTable.draw();
        });
});