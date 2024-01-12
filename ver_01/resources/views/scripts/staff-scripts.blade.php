<script>
    // interview_staffマスタ
    $(document).ready(function() {
        var whichStaff = 0;

        function arrStf() {
            var arr = $('.interv_staff option').map(function() {
                return $(this).val().toLowerCase();
            }).get();
            return arr;
        }
        $(document).on('click', '.addStaff1', function() {
            $(".addNewTitle").text("New Staff");
            $('#addNewModal').find('input').attr("name", "newStaff").attr("id", "newStaff");
            $('#addNewModal').find('#addNewDataBtn').attr("class", "btn btn-success addNewStf");
            whichStaff = 1;
        });
        $(document).on('click', '.addStaff2', function() {
            $(".addNewTitle").text("New Staff");
            $('#addNewModal').find('input').attr("name", "newStaff").attr("id", "newStaff");
            $('#addNewModal').find('#addNewDataBtn').attr("class", "btn btn-success addNewStf");
            whichStaff = 2;
        });
        //add staff
        $(document).on('click', '.addNewStf', function() {
            var staff = $('#newStaff').val();
            var arrStfs = arrStf();
            var newStaff = {
                'newStaff': staff,
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (whichStaff === 1) {
                if (staff === '') {
                    $('#Stf_mess1').html("");
                    $('#Stf_mess1').append(
                        '<div class="alert alert-danger" id="staffMessage1">エーラです!</div>'
                    );
                    setTimeout(function() {
                        $('#staffMessage1').hide();
                    }, 2000);
                } else if (arrStfs.includes(staff.toLowerCase())) {
                    $('#Stf_mess1').html("");
                    $('#Stf_mess1').append(
                        '<div class="alert alert-danger" id="staffMessage1">エーラです!データが存在されています!</div>'
                    );
                    setTimeout(function() {
                        $('#staffMessage1').hide();
                    }, 2000);
                } else {
                    $.ajax({
                        type: "POST",
                        url: "/newStaff",
                        data: newStaff,
                        dataType: "json",
                        success: function(response) {
                            $('#addNewModal').find('input').val("");
                            $('#Stf_mess1').html("");
                            $('#Stf_mess1').append(
                                '<div class="alert alert-success" id="staffMessage1">完成!</div>'
                            );
                            setTimeout(function() {
                                $('#staffMessage1').hide();
                            }, 2000);
                            $('.interv_staff').append('<option value="' + staff + '">' +
                                staff +
                                '</option>');
                            $('#first_interv_staff option[value="' + staff + '"]').prop(
                                "selected", true);
                        }
                    });
                }
            } else {
                if (staff === '') {
                    $('#Stf_mess2').html("");
                    $('#Stf_mess2').append(
                        '<div class="alert alert-danger" id="staffMessage2">エーラです!</div>'
                    );
                    setTimeout(function() {
                        $('#staffMessage2').hide();
                    }, 2000);
                } else if (arrStfs.includes(staff.toLowerCase())) {
                    $('#Stf_mess2').html("");
                    $('#Stf_mess2').append(
                        '<div class="alert alert-danger" id="staffMessage2">エーラです!データが存在されています!</div>'
                    );
                    setTimeout(function() {
                        $('#staffMessage2').hide();
                    }, 2000);
                } else {
                    $.ajax({
                        type: "POST",
                        url: "/newStaff",
                        data: newStaff,
                        dataType: "json",
                        success: function(response) {
                            $('#addNewModal').find('input').val("");
                            $('#Stf_mess2').html("");
                            $('#Stf_mess2').append(
                                '<div class="alert alert-success" id="staffMessage2">完成!</div>'
                            );
                            setTimeout(function() {
                                $('#staffMessage2').hide();
                            }, 2000);
                            $('.interv_staff').append('<option value="' + staff + '">' +
                                staff +
                                '</option>');
                            $('#sec_interv_staff option[value="' + staff + '"]').prop(
                                "selected", true);
                        }
                    });
                }
            }
        });
        //delete staff
        $(document).on('click', '.delStf1', function() {
            $("#deleteModal").find("#fake_delete").attr("class", "btn btn-danger confirmDelStaff");
            whichStaff = 1;
        });
        $(document).on('click', '.delStf2', function() {
            $("#deleteModal").find("#fake_delete").attr("class", "btn btn-danger confirmDelStaff");
            whichStaff = 2;
        });
        $(document).on('click', '.confirmDelStaff', function(e) {
            e.preventDefault();
            if (whichStaff === 1) {
                var staff = $('#first_interv_staff').val();
            } else {
                var staff = $('#sec_interv_staff').val();
            }
            var delStaff = {
                'delStaff': staff,
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/delStaff",
                data: delStaff,
                dataType: "json",
                success: function(response) {
                    if (whichStaff === 1) {
                        $('#Stf_mess1').html("");
                        $('#Stf_mess1').append(
                            '<div class="alert alert-success" id="staffMessage1">削除しました!</div>'
                        );
                        setTimeout(function() {
                            $('#staffMessage1').hide();
                        }, 2000);
                        $('#first_interv_staff').val("").trigger('change');
                    } else {
                        $('#Stf_mess2').html("");
                        $('#Stf_mess2').append(
                            '<div class="alert alert-success" id="staffMessage2">削除しました!</div>'
                        );
                        setTimeout(function() {
                            $('#staffMessage2').hide();
                        }, 2000);
                        $('#sec_interv_staff').val("").trigger('change');
                    }
                    for (var i = 0; i < staff.length; i++) {
                        $('.interv_staff option[value="' + staff[i] + '"]').remove();
                    }
                    arrStf();
                }
            });
        })
    });
    // end interview_staffマスタ
</script>
