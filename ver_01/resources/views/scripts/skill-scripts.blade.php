<script>
    // skill_seマスタ
    $(document).ready(function() {
        function arrSkill() {
            var arr = $('#skill_se option').map(function() {
                return $(this).val().toLowerCase();
            }).get();
            return arr;
        }
        $(document).on('click', '.addSkill', function() {
            $(".addNewTitle").text("New Skill");
            $('#addNewModal').find('input').attr("name", "newSkill").attr("id", "newSkill");
            $('#addNewModal').find('#addNewDataBtn').attr("class", "btn btn-success addNewSkill");
        });

        //add skill_se
        $(document).on('click', '.addNewSkill', function() {
            var skill = $('#newSkill').val();
            var arrKills = arrSkill();
            var newSkill = {
                'newSkill': skill,
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (skill === '') {
                $('#skill_mess').html("");
                $('#skill_mess').append(
                    '<div class="alert alert-danger" id="skillMessage">エーラです!</div>'
                );
                setTimeout(function() {
                    $('#skillMessage').hide();
                }, 2000);
            } else if (arrKills.includes(skill.toLowerCase())) {
                $('#skill_mess').html("");
                $('#skill_mess').append(
                    '<div class="alert alert-danger" id="skillMessage">エーラです!データが存在されています!</div>'
                );
                setTimeout(function() {
                    $('#skillMessage').hide();
                }, 2000);
            } else {
                $.ajax({
                    type: "POST",
                    url: "/newSkill",
                    data: newSkill,
                    dataType: "json",
                    success: function(response) {
                        $("#newSkill").val("");
                        $('#skill_mess').html("");
                        $('#skill_mess').append(
                            '<div class="alert alert-success" id="skillMessage">完成!</div>'
                        );
                        setTimeout(function() {
                            $('#skillMessage').hide();
                        }, 2000);
                        $('#addNewModal').find('input').val("");
                        $('#skill_se').append('<option value="' + skill + '" selected>' +
                            skill +
                            '</option>');
                        $("#skillModal").find(".buttonSkill").append(
                            '<button type="button" value="' + skill +
                            '" class="btn btn-light selectSkill">' + skill + '</button>'
                        )
                    }
                });
            }
        });

        // new
        $(document).on('submit', '#my-form', function() {
            $('#skillText').prop("disabled", false);
        });

        // edit
        var skillText = $('#skillText').val();
        if (skillText) {
            var arrSkillEditLv1 = skillText.split(", ");
            $.each(arrSkillEditLv1, function(index, value) {
                var arrSkillEditLv2 = value.split("&");
                var button = $('#skillModal').find('.buttonSkill').find('button[value="' +
                    arrSkillEditLv2[0] + '"]').hide();
                $('#skillModal').find('tbody').append(
                    '<tr>' +
                    '<th>' + button.val() + '</th>' +
                    '<td id="td' + index + '">' +
                    '<input type="hidden" class="getSkill" value="">' +
                    '<button class="btn btn-light yearSelect" value="趣味or1年未満" type="button">趣味or1年未満</button>' +
                    '<button class="btn btn-light yearSelect" value="1年以上" type="button">1年以上</button>' +
                    '<button class="btn btn-light yearSelect" value="2年以上" type="button">2年以上</button>' +
                    '<button class="btn btn-light yearSelect" value="3年以上" type="button">3年以上</button>' +
                    '<button class="btn btn-light yearSelect" value="5年以上" type="button">5年以上</button>' +
                    '<span class="minus" title="Remove this item"><i class="fa-solid fa-circle-minus"></i></span>' +
                    '<button class="xmark ms-3 showOrHide" title="Delete this item" data-bs-toggle="modal" data-bs-target="#deleteSkillModal"><i class="fa-solid fa-circle-xmark"></i></button>' +
                    '</td>' +
                    '</tr>'
                );
                var active = $('#skillModal').find('tbody').find('td[id="td' + index + '"]').find(
                    'button[value="' + arrSkillEditLv2[1] + '"]').addClass('activeSelect');
                $('#skillModal').find('tbody').find('td[id="td' + index + '"]').find('input').val(
                    arrSkillEditLv2[0] + '&' + arrSkillEditLv2[1]);
                var getRole = $('#getRole').val();
                if (getRole == 'admin') {
                    $('.showOrHide').show();
                } else {
                    $('.showOrHide').hide();
                }
            });
        }

        //components
        $(document).on('click', '.yearSelect', function() {
            $(this).parent().find('button').removeClass('activeSelect');
            $(this).addClass('activeSelect');
            var thisVal = $(this).text();
            var thValue = $(this).parent().parent().find('th').text();
            var combinedValue = thValue + '&' + thisVal;
            $(this).parent().find('input').val(combinedValue);
        });
        $(document).on('dblclick', '.yearSelect', function() {
            $(this).removeClass('activeSelect');
            $(this).parent().find('input').val("");
        })
        $('#submitBtn').click(function() {
            var values = [];

            $('.getSkill').each(function() {
                var value = $(this).val();
                if (value !== '') {
                    values.push(value);
                }
            });
            var result = values.join(', ');
            $('#skillText').val(result);
        });
        $(document).on('click', '.selectSkill', function() {
            $(this).hide();
            $('#skillModal').find('tbody').append(
                '<tr>' +
                '<th>' + $(this).val() + '</th>' +
                '<td>' +
                '<input type="hidden" class="getSkill" value="">' +
                '<button class="btn btn-light yearSelect" value="趣味or1年未満" type="button">趣味or1年未満</button>' +
                '<button class="btn btn-light yearSelect" value="1年以上" type="button">1年以上</button>' +
                '<button class="btn btn-light yearSelect" value="2年以上" type="button">2年以上</button>' +
                '<button class="btn btn-light yearSelect" value="3年以上" type="button">3年以上</button>' +
                '<button class="btn btn-light yearSelect" value="5年以上" type="button">5年以上</button>' +
                '<span class="minus" title="Remove this item"><i class="fa-solid fa-circle-minus"></i></span>' +
                '<button class="xmark ms-3 showOrHide" title="Delete this item" data-bs-toggle="modal" data-bs-target="#deleteSkillModal"><i class="fa-solid fa-circle-xmark"></i></button>' +
                '</td>' +
                '</tr>');
            var getRole = $('#getRole').val();
            if (getRole == 'admin') {
                $('.showOrHide').show();
            } else {
                $('.showOrHide').hide();
            }
        })
        $(document).on('click', '.minus', function() {
            $(this).closest('tr').remove();
            var showItem = $(this).parent().parent().find('th').text();
            $('button[value="' + showItem + '"]').show();
        });

        //delete skill_se
        $(document).on('click', '.xmark', function(e) {
            e.preventDefault();
            $("#deleteSkillModal").find("#fake_delete").attr("class", "btn btn-danger confirmDelSkill");
            var skillName = $(this).parent().parent().find('th').text();
            var delInputVal = $("#deleteSkillModal").find("#delInputVal").val(skillName);
            var delSelect = $(this).closest('tr');
            $(document).on('click', '.confirmDelSkill', function(e) {
                e.preventDefault();
                var skill = delInputVal.val();
                var delSkill = {
                    'delSkill': skill,
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "/delSkill",
                    data: delSkill,
                    dataType: "json",
                    success: function(response) {
                        $('#skillModal').find('#skill_mess_modal').html("");
                        $('#skillModal').find('#skill_mess_modal').append(
                            '<div class="alert alert-success" id="skillMessage_modal">削除しました!</div>'
                        );
                        setTimeout(function() {
                            $('#skillModal').find('#skillMessage_modal')
                                .hide();
                        }, 2000);
                        $('#skill_se option[value="' + skill + '"]').remove();
                        arrSkill();
                        delSelect.remove();
                    }
                });
            })
        })
    });
</script>
