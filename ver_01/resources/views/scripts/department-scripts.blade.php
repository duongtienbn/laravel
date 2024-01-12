<script>
    // departmentマスタ
    $(document).ready(function() {
        function arrDpmt() {
            var arr = $('#intern_department option').map(function() {
                return $(this).val().toLowerCase();
            }).get();
            return arr;
        }
        $(document).on('click', '.addDpmt', function() {
            $(".addNewTitle").text("New Department");
            $('#addNewModal').find('input').attr("name", "newDepartment").attr("id", "newDepartment");
            $('#addNewModal').find('#addNewDataBtn').attr("class","btn btn-success addNewDpmt");
        });
        //add department
        $(document).on('click', '.addNewDpmt', function() {
            var department = $('#newDepartment').val();
            var arrDpmts = arrDpmt();
            var newDepartment = {
                'newDepartment': department,
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (department === '') {
                $('#Dpmt_mess').html("");
                $('#Dpmt_mess').append(
                    '<div class="alert alert-danger" id="dmptMessage">エーラです!</div>'
                );
                setTimeout(function() {
                    $('#dmptMessage').hide();
                }, 2000);
            } else if (arrDpmts.includes(department.toLowerCase())) {
                $('#Dpmt_mess').html("");
                $('#Dpmt_mess').append(
                    '<div class="alert alert-danger" id="dmptMessage">エーラです!データが存在されています!</div>'
                );
                setTimeout(function() {
                    $('#dmptMessage').hide();
                }, 2000);
            } else {
                $.ajax({
                    type: "POST",
                    url: "/newDpmt",
                    data: newDepartment,
                    dataType: "json",
                    success: function(response) {
                        $('#Dpmt_mess').html("");
                        $('#Dpmt_mess').append(
                            '<div class="alert alert-success" id="dmptMessage">完成!</div>'
                        );
                        setTimeout(function() {
                            $('#dmptMessage').hide();
                        }, 2000);
                        $('#addNewModal').find('input').val("");
                        $('#intern_department').append('<option value="' + department + '" selected>' +
                            department +
                            '</option>')
                    }
                });
            }
        });
        //delete department
        $(document).on('click', '.delDpmt', function() {
            $("#deleteModal").find("#fake_delete").attr("class","btn btn-danger confirmDpmt");
            $(document).on('click','.confirmDpmt', function(e) {
                e.preventDefault();
                var department = $('#intern_department').val();
                var delDepartment = {
                    'delDepartment': department,
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/delDpmt",
                    data: delDepartment,
                    dataType: "json",
                    success: function(response) {
                        $('#Dpmt_mess').html("");
                        $('#Dpmt_mess').append(
                            '<div class="alert alert-success" id="dmptMessage">削除しました!</div>'
                            );
                        setTimeout(function() {
                            $('#dmptMessage').hide();
                        }, 2000);
                        $('#intern_department option[value="' + department + '"]').remove();
                        arrDpmt();
                        $('#intern_department').val("").trigger('change');
                    }
                });
            })
        });
        $(document).on('click', '.reldDpmt', function(e) {
            e.preventDefault();
            $('#intern_department option[value=""]').prop('selected', true);
        });
    });
    // end departmentマスタ
</script>
