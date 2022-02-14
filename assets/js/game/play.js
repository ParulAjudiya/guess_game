$(document).ready(function () {
    $('.active_player').hide();
    setTimeout(function () {
        if ($('#win_status').val() == 1) {
            $('#game_result_body').hide();
            $('#win_title').html('You Loose');
            $('#win_section').modal({
                'show': true,
                backdrop: 'static',
                keyboard: false
            });
        }
    }, 300);

    /*
     * Invite the other players */
    $(document).on("click", "#invite_players", function () {
        var copyText = $('#invite_url').val();
        if (copyText != "" && copyText != "undefined") {
            var aux = document.createElement("input");
            aux.setAttribute("value", copyText);
            document.body.appendChild(aux);
            aux.select();
            document.execCommand("copy");
            document.body.removeChild(aux);
        }
        $('#play_game').show();
    });

    /*
    * guess the number method */
    $("#guess_form").validate({
        rules: {
            number_input:
                {
                    required: true,
                    range: [1, 100]
                },
        },
        messages: {
            number_input:
                {
                    required: "Number Input is requird",
                    range: "Please enter a value between 1 to 100"
                },
        },
    });

    $(document).on("click", "#guess_button", function () {
        var result_validation = $("#guess_form").valid();
        if (result_validation) {
            if ($('#number_input').val() != '') {
                $.ajax({
                    url: base_url + "guess_number",
                    type: "POST",
                    data: {number_input: $('#number_input').val()},
                    beforeSend: function (request) {
                        request.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
                        $('.active_player').html('');
                        $('#error').hide();
                    },
                    success: function (successResponse) {
                        $('#game_result_body').hide();
                        if (successResponse.is_error == 0) {
                            if (successResponse.is_won == 0) {
                                $('.active_player').html('');
                                $('.active_player').addClass('form-control');
                                $('.active_player').html('<span>' + successResponse.message + '</span>').show();
                            } else if (successResponse.is_won == 1) {
                                $('#win_title').html(successResponse.message);
                                $('#game_result_body').show();
                                $('#win_section').modal({
                                    'show': true,
                                    backdrop: 'static',
                                    keyboard: false
                                });
                            }
                        } else {
                            if (successResponse.is_error == 1 && successResponse.is_won == 0) {
                                $('#win_title').html(successResponse.message);
                                $('#win_section').modal({
                                    'show': true,
                                    backdrop: 'static',
                                    keyboard: false
                                });
                            } else {
                                $('#error').html(successResponse.responseJSON.message);
                            }
                        }
                    },
                    error: function (errorResponse) {
                        $('#error').html(errorResponse.responseJSON.message).show();
                    }
                });
            } else {
                $('#error').html('<span>Number Input is requird</span>').show();
            }
        }
    });

    $(document).on("click", "#close_game", function (e) {
        $.ajax({
            url: base_url + "close_game",
            type: "GET",
            beforeSend: function (request) {
                request.setRequestHeader("X-CSRF-Token", $('meta[name="csrf-token"]').attr('content'));
            },
            success: function (response) {
                console.log(response);
                if (response.is_error == 0) {
                    location.href = base_url;
                } else {
                }
            },
            error: function (errorResponse) {
            }
        });
    });
});
