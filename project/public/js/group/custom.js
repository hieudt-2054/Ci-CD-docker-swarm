$(document).ready(function () {

    var groupDataTable = $('#group_table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        "lengthMenu": [[1, 10, 25, 50, 100, -1], [1, 10, 25, 50, 100, "Show All"]],
        "pageLength": 10,
        ajax: {
            url: dataTableURL
            // data: function (d) {
            //     d.searchStatus = $('#searchStatus').val();
            //     d.filterBy = $('#filterBy').val();
            //     d.filterValue = $('#filterData').val();
            // }
        },
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'searchable': false, 'ordering': false, 'width': '8%'},
            {data: 'group_name', name: 'group_name', 'width': '20%'},
            {data: 'contacts_count', name: 'contacts_count', 'width': '12%'},
            {data: 'created_at', name: 'created_at', 'width': '12%'},
            {data: 'action', name: 'action', 'width': '16%', 'searchable': false, 'ordering': false}
        ],
        "columnDefs": [
            {"orderable": false, "targets": 0},
            {"orderable": false, "targets": 4},
            {"className": "dt-center", "targets": "_all"}
        ],
        searchDelay: 350,
        oLanguage: {sProcessing: "<div class='loader'></div>"}
    });

    $('body')
    .off('click', '#addGroupForm')
    .on('click', '#addGroupForm', function (event) {
        event.preventDefault();

        $('.modal-header')
        .html('')
        .append('<button type="button" class="close" data-dismiss="modal">&times;</button> ' +
            '<h4 class="modal-title">Add New Group </h4>');
        $('.modal-body')
            .html('<div class="loader centerMargin"></div>')

            .load(addFormCommon, function () {
        });
        $('#common-modal').modal({show: true});
    })

    .off('submit', 'form#addGroup')
    .on('submit', 'form#addGroup', function (event) {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: addGroupURL,
        data: $(this).serialize()
    })
    .done(function (response) {
        if (response.status == '200') {
            $('.groupError').html('');
            $('.groupInput').val('');
            $('form#addGroup').find('#dismis').click();
            toastr.success(response.message);
            groupDataTable.draw();
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

    .off('click', '#updateGroupForm')
    .on('click', '#updateGroupForm', function (event) {
        event.preventDefault();
        // debugger;
        var routeToEdit = $(this).attr('data-route');
        $('.modal-header')
            .html('')
            .append('<button type="button" class="close" data-dismiss="modal">&times;</button> ' +
                '<h4 class="modal-title">Edit Group </h4>');
        $('.modal-body')
            .load(routeToEdit, function () {

            });
        $('#common-modal').modal({show: true});
    })

    .off('submit', 'form#updateGroup')
    .on('submit', 'form#updateGroup', function (event) {
        event.preventDefault();
        var action = $(this).find('form').context.action;
        $.ajax({
            type: 'PATCH',
            url: action,
            data: $(this).serialize()
        })
            .done(function (response) {
                if (response.status == '200') {
                    $('.groupError').html('');
                    $('.groupInput').val('');
                    $('form#updateGroup').find('#dismis').click();
                    toastr.success(response.message);
                    groupDataTable.draw();
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

    .off('click', '#deleteGroupForm')
    .on('click', '#deleteGroupForm', function (event) {
            event.preventDefault();
            var URL = $(this).attr('data-route');

            swal({
                title: "Are you sure to delete?",
                text: "You will not be able to recover this group and its related contacts!",
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
                            groupDataTable.draw();
                        }
                    })
                    .fail(function (data) {
                        toastr.danger(response.message);
                    });
                }
            });
        });
});
