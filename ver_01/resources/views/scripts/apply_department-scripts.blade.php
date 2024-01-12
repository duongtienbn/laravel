<script>
    // apply_departmentマスタ
    $(document).ready(function() {
        function arrApl() {
            var arr = $('#skill_se option').map(function() {
                return $(this).val().toLowerCase();
            }).get();
            return arr;
        }
        $(document).on('click', '.addApl', function() {
            $(".addNewTitle").text("New Apply Department");
            $('#addNewModal').find('input').attr("name", "newApply").attr("id", "newApply");
            $('#addNewModal').find('#addNewDataBtn').attr("class", "btn btn-success addNewApl");
        });

        //add apply_department
        $(document).on('click', '.addNewApl', function() {
            var apply = $('#newApply').val();
            var arrApls = arrApl()
            var newApply = {
                'newApply': apply,
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (apply === '') {
                $('#Apl_mess').html("");
                $('#Apl_mess').append(
                    '<div class="alert alert-danger" id="aplMessage">エーラです!</div>'
                );
                setTimeout(function() {
                    $('#aplMessage').hide();
                }, 2000);
            } else if (arrApls.includes(apply.toLowerCase())) {
                $('#Apl_mess').html("");
                $('#Apl_mess').append(
                    '<div class="alert alert-danger" id="aplMessage">エーラです!データが存在されています!</div>'
                );
                setTimeout(function() {
                    $('#aplMessage').hide();
                }, 2000);
            } else {
                $.ajax({
                    type: "POST",
                    url: "/newApply",
                    data: newApply,
                    dataType: "json",
                    success: function(response) {
                        $('#Apl_mess').html("");
                        $('#Apl_mess').append(
                            '<div class="alert alert-success" id="aplMessage">完成!</div>'
                        );
                        setTimeout(function() {
                            $('#aplMessage').hide();
                        }, 2000);
                        $('#addNewModal').find('input').val("");
                        $('#apply_department').append('<option value="' + apply + '" selected>' +
                            apply +
                            '</option>')
                    }
                });
            }
        });

        //delete apply_department
        $(document).on('click', '.delApl', function() {
            $("#deleteModal").find("#fake_delete").attr("class", "btn btn-danger confirmDelApply");
            $(document).on('click', '.confirmDelApply', function(e) {
                e.preventDefault();
                var apply = $('#apply_department').val();
                var delApply = {
                    'delApply': apply,
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/delApply",
                    data: delApply,
                    dataType: "json",
                    success: function(response) {
                        $('#Apl_mess').html("");
                        $('#Apl_mess').append(
                            '<div class="alert alert-success" id="aplMessage">削除しました!</div>'
                        );
                        setTimeout(function() {
                            $('#aplMessage').hide();
                        }, 2000);
                        for (var i = 0; i < apply.length; i++) {
                            $('#apply_department option[value="' + apply[i] + '"]').remove();
                        }
                        arrApl();
                        $('#apply_department').val("").trigger('change');
                    }
                });
            })
        });
    });
    // end apply_departmentマスタ
</script>
