$(document).ready(function () {

    var senderIDDataTable = $('#senderID_table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        "lengthMenu": [[1, 10, 25, 50, 100, -1], [1, 10, 25, 50, 100, "Show All"]],
        "pageLength": 10,
        ajax: {
            url: dataTableURL,
            data: function (d) {
                d.searchStatus = $('#searchStatus').val();
                d.filterBy = $('#filterBy').val();
                d.filterValue = $('#filterData').val();
            }
        },
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'searchable': false, 'ordering': false, 'width': '8%'},
            {data: 'sender_name', name: 'sender_name', 'width': '30%'},
            {data: 'created_at', name: 'created_at', 'width': '25%'},
            {data: 'status', name: 'status', 'width': '22%'},
            {data: 'action', name: 'action', 'width': '15%'}
        ],
        "columnDefs": [
            {"orderable": false, "targets": 0},
            {"orderable": false, "targets": 4},
            {"className": "dt-center", "targets": "_all"}
        ],
        aaSorting: [[2, 'asc']],
        searchDelay: 350,
        oLanguage: {sProcessing: "<div class='loader'></div>"}
    });

    $('body')
    .off('click', '#addSenderForm')
    .on('click', '#addSenderForm', function (event) {
        event.preventDefault();

        $('#add-modal').modal({show: true});
    })

    .off('submit', 'form#addSenderID')
    .on('submit', 'form#addSenderID', function (event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: addSenderIDURL,
            data: $(this).serialize()
        })
            .done(function (response) {
                if (response.status == '200') {
                    $('.senderIDError').html('');
                    $('.senderIDInput').val('');
                    $('form#addSenderID').find('#dismis').click();
                    toastr.success(response.message);
                    senderIDDataTable.draw();
                }
            })
            .fail(function (data) {
                if (data.status == 422) {
                    $.each(data.responseJSON.errors, function (key, error) {
                        $("input[name='" + key + "']").next('span').html('').append(error);
                    });
                }
            });
    })

    .off('click', '#senderIDDelete')
    .on('click', '#senderIDDelete', function (event) {
    event.preventDefault();
    var URL = $(this).attr('data-route');
    swal({
        title: "Are you sure to delete?",
        text: "You will not be able to recover this sender id!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
    })
    .then(function (response) {
        if (response.value) {
            $.ajax({
                type: 'DELETE',
                url: URL
            })
                .done(function (response) {
                    console.log(response);
                    if (response.status == '200') {
                        toastr.success(response.message);
                        senderIDDataTable.draw();
                    }
                })
                .fail(function (data) {
                    toastr.danger(response.message);
                });
        }
    });
})

    .off('click', '#filterSender')
    .on('click', '#filterSender', function (event) {
            event.preventDefault();

            $('#filter-modal').modal({show: true});
    })

    .off('change', '#filterBy')
    .on('change', '#filterBy', function (event) {
            var selectedValue = $(this).val();
            var element = $('#filterValue').find('input');
            if(selectedValue == 1){
                element
                    .attr('data-filter', 'senderId')
                    .attr('maxlength', '6')
                    .attr( 'placeholder', 'Enter the sender id')
                    .show();
                element.val('');
                element.data('daterangepicker').remove();
            }
            else if(selectedValue == 2){
                element
                    .removeAttr('maxlength')
                    .attr('data-filter', 'createdAt')
                    .attr( 'placeholder', 'Choose your date')
                    .show();
                element.daterangepicker().val('');
                element.on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY/MM/DD') +' - '+picker.endDate.format('YYYY/MM/DD'));
                });
            }
            else{
                element
                    .attr('data-filter', '')
                    .val('')
                    .hide();
            }
        })

    .on('submit', '#search-sender-id', function (event) {
        event.preventDefault();

        $('form#search-sender-id').find('#dismis').click();
        senderIDDataTable.draw();
    });
});

