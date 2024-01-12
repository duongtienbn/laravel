<script>
    // working_placeマスタ
    $(document).ready(function() {
        function arrPlc() {
            var arr = $('#working_place option').map(function() {
                return $(this).val().toLowerCase();
            }).get();
            return arr;
        }
        $(document).on('click', '.addPlc', function() {
            $(".addNewTitle").text("New Working Place");
            $('#addNewModal').find('input').attr("name", "newPlace").attr("id", "newPlace");
            $('#addNewModal').find('#addNewDataBtn').attr("class", "btn btn-success addNewPlc");
        });

        //add working_place
        $(document).on('click', '.addNewPlc', function() {
            var place = $('#newPlace').val();
            var arrPlcs = arrPlc();
            var newPlace = {
                'newPlace': place,
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (place === '') {
                $('#plc_mess').html("");
                $('#plc_mess').append(
                    '<div class="alert alert-danger" id="wrkMessage">エーラです!</div>'
                );
                setTimeout(function() {
                    $('#wrkMessage').hide();
                }, 2000);
            } else if (arrPlcs.includes(place.toLowerCase())) {
                $('#plc_mess').html("");
                $('#plc_mess').append(
                    '<div class="alert alert-danger" id="wrkMessage">エーラです!データが存在されています!</div>'
                );
                setTimeout(function() {
                    $('#wrkMessage').hide();
                }, 2000);
            } else {
                thisPlace = place;
                $.ajax({
                    type: "POST",
                    url: "/newPlace",
                    data: newPlace,
                    dataType: "json",
                    success: function(response) {
                        $('#plc_mess').html("");
                        $('#plc_mess').append(
                            '<div class="alert alert-success" id="wrkMessage">完成!</div>'
                        );
                        setTimeout(function() {
                            $('#wrkMessage').hide();
                        }, 2000);
                        $('#addNewModal').find('input').val("");
                        $('#working_place').append('<option value="' + place + '" selected>' +
                            place +
                            '</option>')
                    }
                });
            }
        });
        //delete working_place
        $(document).on('click', '.delPlc', function() {
            $("#deleteModal").find("#fake_delete").attr("class", "btn btn-danger confirmDelWrkPlc");
            $(document).on('click', '.confirmDelWrkPlc', function(e) {
                e.preventDefault();
                var place = $('#working_place').val();
                var delPlace = {
                    'delPlace': place,
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/delPlace",
                    data: delPlace,
                    dataType: "json",
                    success: function(response) {
                        $('#plc_mess').html("");
                        $('#plc_mess').append(
                            '<div class="alert alert-success" id="wrkMessage">削除しました!</div>'
                        );
                        setTimeout(function() {
                            $('#wrkMessage').hide();
                        }, 2000);
                        for (var i = 0; i < place.length; i++) {
                            $('#working_place option[value="' + place[i] + '"]').remove();
                        }
                        arrPlc();
                        $('#working_place').val("").trigger('change');
                    }
                });
            })
        });
    });
    // end working_placeマスタ
</script>
