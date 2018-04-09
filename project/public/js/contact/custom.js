$(document).ready(function () {
    var alreadyLoadedForm = false;
    $('#group, select[name="groupToDelete"]').select2({
        width: '200px',
        placeholder: "Select group/s to delete",
        allowClear: true
    });

    var contactDataTable = $('#contact_table').DataTable({
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
            {data: 'checkbox', name: 'group.checkbox', 'searchable': false, 'ordering': false, 'width': '5%'},
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'searchable': false, 'ordering': false, 'width': '8%'},
            {data: 'group.group_name', name: 'group.group_name', 'width': '20%'},
            {data: 'contact_name', name: 'contact_name', 'width': '16%'},
            {data: 'mobile_number', name: 'mobile_number', 'width': '15%'},
            {data: 'created_at', name: 'created_at', 'width': '16%'},
            {data: 'action', name: 'action', 'width': '20%'}
        ],
        "columnDefs": [
            {"orderable": false, "targets": 0},
            {"orderable": false, "targets": 1},
            {"orderable": false, "targets": 6},
            {"className": "dt-center", "targets": "_all"}
        ],
        aaSorting: [[4, 'desc']],
        searchDelay: 350,
        oLanguage: {sProcessing: "<div class='loader'></div>"}

    });

    function selectOnClick() {
        var totalRows = $(".deleteRow:checked").length;
        if (totalRows >= 2) {
            var button = '<input type="submit" class="button btn btn-sm btn-danger btn-rounded" id="multiDelete" value="Delete Selected[' + totalRows + ']" />';
            $('#displayMultipleDeleteButton').html('').append(button);
            $('#deleteBtn').show();
        } else {
            $('#displayMultipleDeleteButton').html('');
            $('#deleteBtn').hide();
        }
        if (($('.deleteRow').length - $('.deleteRow:checked').length) == 0) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    }

    $('body')
    .off('click', '#addContactForm')
    .on('click', '#addContactForm', function (event) {
        event.preventDefault();

        if (!alreadyLoadedForm) {
            $('.modal-header')
                .html('')
                .append('<button type="button" class="close" data-dismiss="modal">&times;</button> ' +
                    '<h4 class="modal-title">Add New Contact </h4>');
            $('.modal-body')
                .html('<div class="loader centerMargin"></div>')
                .load(addFormCommon, function () {
                });
            alreadyLoadedForm = true;
        }
        $('#add-modal').modal({show: true});
    })

    .off('click', '#updateContactForm')
    .on('click', '#updateContactForm', function (event) {
        event.preventDefault();
        // debugger;
        alreadyLoadedForm = false;
        var routeToEdit = $(this).attr('data-route');
        $('.modal-header')
            .html('')
            .append('<button type="button" class="close" data-dismiss="modal">&times;</button> ' +
                '<h4 class="modal-title">Edit Contact </h4>');
        $('.modal-body')
            .load(routeToEdit, function () {

            });
        $('#add-modal').modal({show: true});
    })

    .off('submit', 'form#addContact')
    .on('submit', 'form#addContact', function (event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: addContactURL,
            data: $(this).serialize()
        })
            .done(function (response) {
                if (response.status == '200') {
                    $('span.contactError').html('');
                    $('.contactInput').val('');
                    $("#group").select2("val", "");
                    $('form#addContact').find('#dismis').click();
                    alreadyLoadedForm = false;
                    toastr.success(response.message);
                    contactDataTable.draw();
                }
            })
            .fail(function (data) {
                if (data.status == 422) {
                    $('span.contactError').html('');
                    $.each(data.responseJSON.errors, function (key, error) {
                        $("div.form-group." + key).find('span.contactError').append(error);
                    });
                }
            });
    })

    .off('submit', 'form#updateContact')
    .on('submit', 'form#updateContact', function (event) {
        event.preventDefault();
        var action = $(this).find('form').context.action;
        $.ajax({
            type: 'PATCH',
            url: action,
            data: $(this).serialize()
        })
            .done(function (response) {
                if (response.status == '200') {
                    $('span.contactError').html('');
                    // $('.contactInput').val('');
                    // $("#group").select2("val", "");
                    $('form#updateContact').find('#dismis').click();
                    toastr.success(response.message);
                    contactDataTable.draw();
                }
            })
            .fail(function (data) {
                if (data.status == 422) {
                    $('span.contactError').html('');
                    $.each(data.responseJSON.errors, function (key, error) {
                        $("div.form-group." + key).find('span.contactError').append(error);
                    });
                }
            });
    })

    .off('click', '#deleteContactForm')
    .on('click', '#deleteContactForm', function (event) {
        event.preventDefault();
        var URL = $(this).attr('data-route');

        swal({
            title: "Are you sure to delete?",
            text: "You will not be able to recover this contact!",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
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
                                contactDataTable.draw();
                            }
                        })
                        .fail(function (data) {
                            toastr.danger(response.message);
                        });
                }
            });
    })

    .off('click', '#group')
    .on('click', '#group', function (event) {
        event.preventDefault();
        var totalGroups = $('#group > option').length;
        if (totalGroups == 1) {
            swal({
                title: "Groups Empty!!",
                text: "There are no groups for this user, Please create one first!!",
                type: "info"

            })
        }
    })

    .off('click', '#selectAll')
    .on('click', '#selectAll', function () {
        if ($(this).is(":checked")) {
            $('.deleteRow').prop('checked', true);
            var totalRows = $(".deleteRow:checked").length;
            if (totalRows >= 2) {
                var button = '<input type="submit" class="button btn btn-sm btn-danger btn-rounded" id="multiDelete" value="Delete Selected [' + totalRows + ']" />';
                $('#displayMultipleDeleteButton').html('').append(button);
                $('#deleteBtn').show();
            }
        } else {
            $('select[name="groupToDelete"]').select2("val", "");
            $('.deleteRow').prop('checked', false);
            $('#displayMultipleDeleteButton').html('');
            $('#deleteBtn').hide();
        }
    })

    .off('click', '.deleteRow')
    .on('click', '.deleteRow', function () {
        selectOnClick();
    })

    .off('click', '#multiDelete')
    .on('click', '#multiDelete', function (event) {
        event.preventDefault();
        swal({
            title: "Are you sure to delete?",
            text: "You will not be able to recover these contacts!",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        })
        .then(function (response) {
                if (response.value) {
                    $.ajax({
                        type: 'post',
                        url: multiDeleteURL,
                        data: $('form#deleteSelected').serialize()
                    })
                    .done(function (response) {
                        if (response.status == '200') {
                            $('#displayMultipleDeleteButton').html('');
                            $('#deleteBtn').hide();
                            toastr.success(response.message);
                            contactDataTable.draw();
                        }
                    })
                    .fail(function (data) {
                        toastr.danger(response.message);
                    });
                }
            });
    })

    .off('change', 'select[name="groupToDelete"]')
    .on('change', 'select[name="groupToDelete"]', function (event) {
        event.preventDefault();

        var listGroups = $(this).val();
        if(listGroups === undefined || listGroups == null){
            $('.deleteRow').attr('checked', false);
            selectOnClick();
        }else {
            $('.deleteRow').each(function (index, value) {
                var eachRow = $(this).attr('data-groupid');
                if (listGroups.includes(eachRow)) {
                    $(this).attr('checked', true);
                }
                else {
                    $(this).attr('checked', false);
                }
                selectOnClick();
            });
        }
    })

    .off('click', '#groupDeleteOption')
    .on('click', '#groupDeleteOption', function (event) {
        event.preventDefault();
        $('.selectToDelete').show();
        $(this).fadeOut();
    })

    .off('click', '.backToOption')
    .on('click', '.backToOption', function (event) {
        event.preventDefault();
        $('.selectToDelete').fadeOut();
        $('#groupDeleteOption').fadeIn()
    });
});
