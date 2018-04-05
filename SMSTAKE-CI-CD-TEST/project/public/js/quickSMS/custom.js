const phoneNumber = new Vue({
    el: '#smsApp',
    data: {
        message: '',
        group:'',
        selectedGroup: '',
        title: 'new Title',
        textMessage: '',
        language: [
            {
                id: '',
                name: 'SELECT ANY LANGUAGE'
            }, {
                id: 1,
                name: 'ENGLISH'
            },
            {
                id: 2,
                name: 'HINDI'
            }
        ],
        selectedLang: '',
        unitForCredit: 0,
        schedule: 0,
        date_scheduled: '',
        selectDraft: '',
        draftMessages: [],
        groupContacts: [],
        selectedFile: null,
        selectedFileName: '',
        selected: [],
        loading: true
    },

    methods: {
        isNumber: function (evt) {
            evt = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.charCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105)) && charCode !== 46 && charCode !== 37 && charCode !== 39 && charCode !== 188 && charCode !== 190 && charCode !== 8) {
                evt.preventDefault();
            } else {
                this.validNumber(evt);
            }
        },

        isNumberGroup: function (evt) {
            evt = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.charCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105)) && charCode !== 46 && charCode !== 37 && charCode !== 39 && charCode !== 188 && charCode !== 190 && charCode !== 8) {
                evt.preventDefault();
            } else {
                this.validNumberGroup(evt);
            }
        },

        validNumber(evt) {
            let startIndexOfNumber = this.message.lastIndexOf(',');
            let charValues = '';
            if (startIndexOfNumber !== -1) {
                charValues = this.message.substr(startIndexOfNumber + 1);
            } else {
                charValues = this.message;
            }
            if (charValues.length < 10) {
                if (evt.keyCode === 188)
                    evt.preventDefault();
            } else if (charValues.length >= 10
                && evt.keyCode !== 188
                && evt.keyCode !== 8
                && evt.keyCode !== 37
                && evt.keyCode !== 39
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },

        validNumberGroup(evt) {
            let startIndexOfNumber = this.selected.lastIndexOf(',');
            let charValues = '';
            if (startIndexOfNumber !== -1) {
                charValues = this.selected.substr(startIndexOfNumber + 1);
            } else {
                charValues = this.selected.toString();
            }
            if (charValues.length < 10) {
                if (evt.keyCode === 188)
                    evt.preventDefault();
            } else if (charValues.length >= 10
                && evt.keyCode !== 188
                && evt.keyCode !== 8
                && evt.keyCode !== 37
                && evt.keyCode !== 39
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },

        getTotalCredit(messageLength){
            if (this.selectedLang == 1) {
                this.unitForCredit = 160;
            }
            else {
                this.unitForCredit = 70;
            }
            return (messageLength) ? Math.floor(messageLength / this.unitForCredit) + 1 : 0;
        },

        show_draft_messages() {
            axios.get('draft/listDraftData')
                .then(response => {
                    this.loading = false;
                    this.draftMessages = response.data
                })
                .catch(error => {
                    this.loading = false;
                    console.log(error);
                });
            $('#draftList').modal({show: true});
        },

        setTheDraftMessage() {
            this.textMessage = this.selectDraft;
        },

        setFocus() {
            $('#draftList').find('#dismis').click();
            this.$nextTick( ()=> {
                this.$refs.msg.focus();
            })
        },

        show_contacts(groupId) {
            if (groupId) {
                axios.get(`contact/${groupId}/listContactOfGroup`)
                    .then(response => {
                        this.message = '';
                        return response.data;
                    })
                    .then(res => {
                        this.groupContacts = res;
                        this.selectAll = true;
                    })
                    .catch(error => {
                        this.selected = '';
                        console.log(error);
                    });
            }else{
                this.selected = '';
            }
        },

        customSelect() {
            $('#groupContacts').modal({show: true});
        },

        isNumberValid(event) {
            let indexBe = this.message.lastIndexOf(',')+1;
            if (this.message.substr(indexBe).length == 0 || this.message.substr(indexBe).length == 10) {
                $('body')
                    .off('submit', '#submitSMS')
                    .on('submit', '#submitSMS', function (event) {
                        event.preventDefault();
                        let thisForm = $(this);
                        $.ajax({
                            type: 'POST',
                            url: addquickSMSURL,
                            data: $(this).serialize()
                        })
                            .done(function (response) {
                                if (response.status == '200') {
                                    $('.smsError').html('');
                                    $('.senderIDInput').val('');
                                    toastr.success(response.message);
                                    thisForm[0].reset();
                                }
                            })
                            .fail(function (data) {
                                if (data.status == 422) {
                                    $('.smsError').html('');
                                    $.each(data.responseJSON.errors, function (key, error) {
                                        $("select[name='" + key + "']").next('span').html('').append(error);
                                        $("select[name='" + key + "']").parents('#' + key).siblings('span').html('').append(error);
                                        $("input[name='" + key + "']").parents('.' + key).siblings('span.smsError').html('').append(error);
                                        $("textarea[name='" + key + "']").next('span').html('').append(error);
                                        $("textarea[name='" + key + "']").parents('#' + key).siblings('span.smsError').html('').append(error);
                                        $('.nav-tabs a[href="#' + key + '"]').tab('show');
                                    });
                                }
                            });
                    });
            }else{
                event.preventDefault();

                swal({
                    title: "Invalid phone number!!",
                    text: "Please enter 10 digit valid number to send SMS!!",
                    type: "error"

                })
            }
        },

        onFileSelected(event) {
            let file = event.target.files[0];
            let validMimes = [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel',
                'text/csv'
            ];
            if ($.inArray(file.type, validMimes) > -1) {
                this.selectedFile = file;
                if(this.selectedFile)
                    this.selectedFileName = this.selectedFile.name;
            }else {
                alert('this is not a valid file');
            }
        }
    },

    computed: {
        phoneCount() {
            return this.message.split(',')
                .filter(function (i) {
                    if (i.length == 10)
                        return i.length;
                })
                .length;
        },

        groupPhoneCount() {
            return this.selected.toString().split(',')
                .filter(function (i) {
                    if (i.length == 10)
                        return i.length;
                })
                .length;
        },

        textMessageCounter() {
            return {
                characterCount: this.textMessage.length,
                characterNoun: (this.textMessage.length == 1) ? 'character' : 'characters',
                creditCount: this.getTotalCredit(this.textMessage.length),
                creditNoun: (this.getTotalCredit(this.textMessage.length) == 1) ? 'credit' : 'credits'
            }
        },

        selectAll: {
            get: function () {
                return this.groupContacts ? this.selected.length == this.groupContacts.length : false;
            },
            set: function (value) {
                var selected = [];

                if (value) {
                    this.groupContacts.forEach(function (groupContact) {
                        selected.push(groupContact.mobile_number);

                    });
                }

                this.selected = selected;
            }
        }
    },

    watch: {
        selectedLang(self) {
            if (self !== '')
                return false;

            this.textMessage = '';
            this.selectDraft = null;
            return true;
        },

        date_scheduled(self) {
            if (this.schedule == 0)
                self = '';
        }
    }
});

$('.btn-toggle').click(function () {
    $(this).find('.btn').toggleClass('active');

    if ($(this).find('.btn-primary').size() > 0) {
        $(this).find('.btn').toggleClass('btn-primary');
    }
    if ($(this).find('.btn-danger').size() > 0) {
        $(this).find('.btn').toggleClass('btn-danger');
    }
    if ($(this).find('.btn-success').size() > 0) {
        $(this).find('.btn').toggleClass('btn-success');
    }
    if ($(this).find('.btn-info').size() > 0) {
        $(this).find('.btn').toggleClass('btn-info');
    }

    $(this).find('.btn').toggleClass('btn-default');

});

(function () {
    $('#scheduleDateTimePicker').datetimepicker({
        format:'YYYY-MM-DD HH:mm:ss'
    });
})();


