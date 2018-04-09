$(document).ready(function () {
    var draftDataTable = $('#draft_table').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        "lengthMenu": [[1, 10, 25, 50, 100, -1], [1, 10, 25, 50, 100, "Show All"]],
        "pageLength": 10,
        ajax: {
            url: dataTableURL
        },
        columns: [
            {data: 'DT_Row_Index', name: 'DT_Row_Index', 'searchable': false, 'ordering': false, 'width': '8%'},
            {data: 'draft_message', name: 'draft_message', 'width': '20%'},
            {data: 'created_at', name: 'created_at', 'width': '12%'},
            {data: 'action', name: 'action', 'width': '16%', 'searchable': false, 'ordering': false}
        ],
        "columnDefs": [
            {"orderable": false, "targets": 0},
            {"orderable": false, "targets": 3},
            {"className": "dt-center", "targets": "_all"}
        ],
        searchDelay: 350,
        oLanguage: {sProcessing: "<div class='loader'></div>"}
    });
    var editor_config = {
        path_absolute: "/",
        selector: "textarea#draft_message_remove",
        cleanup: true,
        fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
        content_css: [
            '//fonts.googleapis.com/css?family=Indie+Flower',
            '//fonts.googleapis.com/css?family=Roboto',
            '//fonts.googleapis.com/css?family=Montserrat:300',
            '//fonts.googleapis.com/css?family=Fanwood+Text'
        ],
        font_formats: ' Arial Black=arial black,avant garde;' +
        'Indie Flower=indie flower, cursive;' +
        'Times New Roman=times new roman,times;' +
        'Roboto1=jpt, serif;Roboto=roboto, serif;' +
        'Montserrat=Montserrat, sans-serif;' +
        'Fanwood=Fanwood Text, sans-serif;',
        plugins: [
            "searchreplace",
            "preview",
            "wordcount",
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "code"
        ],
        toolbar: "searchreplace  | preview | alignleft aligncenter alignright alignjustify | sizeselect | bold italic | fontselect |  fontsizeselect | toggle",
        /*menubar: "edit",*/
        /*link image media*/
        relative_urls: false,
        setup: function (ed) {
            ed.on('init', function (e) {
                ed.execCommand("fontName", false, "Roboto");
                ed.execCommand("fontSize", false, "24pt");
            });

            /*ed.addButton('toggle', {
                title : 'toggle to english',
                image : '/smstake/images/sort_both.png',
                onclick : function() {
                    var content = tinyMCE.get('draft_message').getContent();
                    var currentLanguage = $('#draft_type').val();
                    $.ajax({
                        url: toggleURL,
                        data: {
                            'content': content,
                            'language': currentLanguage
                        },
                        success: function (res) {
                            tinyMCE.activeEditor.setContent('');
                            tinyMCE.activeEditor.setContent(res);
                        },
                        fail: function () {
                            alert('error');
                        }
                    });
                }
            });*/

        },
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
        /*init_instance_callback: function (editor) {
            editor.on('keydown', function (e) {
                var selectedLang = $('#draft_type').val();
                if (e.keyCode === 190) {
                    var text = e.target.textContent;
                    var lastChar = e.key;
                    var result = text.replace(/[\u200B-\u200D\uFEFF]/g, '');
                    if (selectedLang !== '' && selectedLang !== 'en') {
                        $.ajax({
                            url: translateURL,
                            data: {
                                'content': result,
                                'lastHit': lastChar,
                                'language': selectedLang
                            },
                            success: function (res) {
                                tinyMCE.activeEditor.setContent('');
                                tinyMCE.activeEditor.setContent(res);
                            },
                            fail: function () {
                                alert('error');
                            }
                        });
                    }
                }
            });
        }*/
    };

    $('body')
        .off('click', '#addDraftForm')
        .on('click', '#addDraftForm', function (event) {
            event.preventDefault();
            $('.modal-header')
                .html('')
                .append('<button type="button" class="close" data-dismiss="modal">&times;</button> ' +
                    '<h4 class="modal-title">Add New Draft </h4>');
            $('.modal-body')
                .html('<div class="loader centerMargin"></div>')
                .load(addFormCommon, function () {
                    tinymce.remove();
                    tinymce.init(editor_config);
                });
            $('#common-modal').modal({show: true});
        })

        .off('submit', 'form#addDraft')
        .on('submit', 'form#addDraft', function (event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: addDraftURL,
                data: $(this).serialize()
            })
                .done(function (response) {
                    if (response.status == '200') {
                        $('.draftError').html('');
                        $('.draftInput').val('');
                        $('form#addDraft').find('#dismis').click();
                        toastr.success(response.message);
                        draftDataTable.draw();
                    }
                })
                .fail(function (data) {
                    if (data.status == 422) {
                        $('.draftError').html('');
                        $.each(data.responseJSON.errors, function (key, error) {
                            $("select[name='" + key + "']").next('span').html('').append(error);
                            $("textarea[name='" + key + "']").next('span').html('').append(error);
                        });
                    }
                });
        })

        .off('click', '#updateDraftForm')
        .on('click', '#updateDraftForm', function (event) {
            event.preventDefault();
            var routeToEdit = $(this).attr('data-route');
            $('.modal-header')
                .html('')
                .append('<button type="button" class="close" data-dismiss="modal">&times;</button> ' +
                    '<h4 class="modal-title">Edit Draft </h4>');
            $('.modal-body')
                .load(routeToEdit, function () {
                    tinymce.remove();
                    tinymce.init(editor_config);
                });
            $('#common-modal').modal({show: true});
        })

        .off('submit', 'form#updateDraft')
        .on('submit', 'form#updateDraft', function (event) {
            event.preventDefault();
            var action = $(this).find('form').context.action;
            $.ajax({
                type: 'PATCH',
                url: action,
                data: $(this).serialize()
            })
                .done(function (response) {
                    if (response.status == '200') {
                        $('.draftError').html('');
                        $('.draftInput').val('');
                        $('form#updateDraft').find('#dismis').click();
                        toastr.success(response.message);
                        draftDataTable.draw();
                    }
                })
                .fail(function (data) {
                    if (data.status == 422) {
                        $('.draftError').html('');
                        $.each(data.responseJSON.errors, function (key, error) {
                            $("select[name='" + key + "']").next('span').html('').append(error);
                            $("textarea[name='" + key + "']").next('span').html('').append(error);
                        });
                    }
                });
        })

        .off('click', '#deleteDraftForm')
        .on('click', '#deleteDraftForm', function (event) {
            event.preventDefault();
            var URL = $(this).attr('data-route');
            swal({
                title: "Are you sure to delete?",
                text: "You will not be able to recover this draft",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!"
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
                            draftDataTable.draw();
                        }
                    })
                    .fail(function (data) {
                        toastr.danger(response.message);
                    });
                }
            });
        });
});
