<script>
    // countryマスタ
    $(document).ready(function() {
        function arrCtr() {
            var arr = $('#country option').map(function() {
                return $(this).val().toLowerCase();
            }).get();
            return arr;
        }
        $(document).on('click', '.addCountry', function() {
            $(".addNewTitle").text("New Country");
            $('#addNewModal').find('input').attr("name", "newCountry").attr("id", "newCountry");
            $('#addNewModal').find('#addNewDataBtn').attr("class", "btn btn-success addNewCtr");
        });
        //add country
        $(document).on('click', '.addNewCtr', function() {
            var country = $('#newCountry').val();
            var arrCtrs = arrCtr();
            var newCountry = {
                'newCountry': country,
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (country === '') {
                $('#Crt_mess').html("");
                $('#Crt_mess').append(
                    '<div class="alert alert-danger" id="CtrMessage">エーラです!</div>'
                );
                setTimeout(function() {
                    $('#CtrMessage').hide();
                }, 2000);
            } else if (arrCtrs.includes(country.toLowerCase())) {
                $('#Crt_mess').html("");
                $('#Crt_mess').append(
                    '<div class="alert alert-danger" id="CtrMessage">エーラです!データが存在されています!</div>'
                );
                setTimeout(function() {
                    $('#CtrMessage').hide();
                }, 2000);
            } else {
                $.ajax({
                    type: "POST",
                    url: "/addCountry",
                    data: newCountry,
                    dataType: "json",
                    success: function(response) {
                        $('#addNewModal').find('input').val("");
                        $('#Crt_mess').html("");
                        $('#Crt_mess').append(
                            '<div class="alert alert-success" id="CtrMessage">完成!</div>'
                        );
                        setTimeout(function() {
                            $('#CtrMessage').hide();
                        }, 2000);
                        $('#country').append('<option value="' + country + '" selected>' +
                            country +
                            '</option>')
                    }
                });
            }
        });
        //delete country

        $(document).on('click', '.delCtr', function() {
            $("#deleteModal").find("#fake_delete").attr("class", "btn btn-danger confirmDelCtr");
            $(document).on('click', '.confirmDelCtr', function(e) {
                e.preventDefault();
                var country = $('#country').val();
                var delCountry = {
                    'delCountry': country,
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/delCountry",
                    data: delCountry,
                    dataType: "json",
                    success: function(response) {
                        console.log(response.country);
                        $('#Crt_mess').html("");
                        $('#Crt_mess').append(
                            '<div class="alert alert-success" id="CtrMessage">削除しました!</div>'
                        );
                        setTimeout(function() {
                            $('#CtrMessage').hide();
                        }, 2000);
                        $('#country option[value="' + country + '"]').remove();
                        arrCtr();
                        $('#country').val("").trigger('change');

                    }
                });
            })
        });
        $(document).on('click', '.reldCtr', function(e) {
            e.preventDefault();
            $('#country option[value=""]').prop('selected', true);
        });
    });
    // end countryマスタ
</script>
