/**
 * Created by jaskokoyn on 11/11/2015.
 */
(function($, w){
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

    $("#settingsForm").submit(function(e){
        e.preventDefault();

        $(this).find(":input").prop("disabled", true);
        $("#settingsStatus").html('<div class="alert alert-info">Please wait!</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            max_img_size:                   $("#inputMaxImgSize").val(),
            preapprove_media:               $("#inputPreapproveMedia").val(),
            custom_memes:                   $("#inputAllowUserUploadedMemes").val(),
            send_media_approve_email:       $("#inputSendApprovedEmail").val(),
            infinite_pagination:            $("#inputInfinitePagination").val(),
            duplicate_list:                 $("#inputDuplicateLists").val(),
            notify_duplicate_list:          $("#inputNotifyDuplicateList").val(),
            poll_signed_in_votes:           $("#inputPollSignedInVote").val(),
            allow_embeds:                   $("#inputAllowEmbed").val(),
            auto_scroll:                    $("#inputAutoscroll").val(),
            auto_scroll_timer:              $("#inputAutoscrollTimer").val(),
            generate_share_img:             $("#inputGenerateSpecialShareImg").val(),

            create_polls:                   $("#inputCanCreatePolls").val(),
            create_trivia:                  $("#inputCanCreatrTrivia").val(),
            create_personality:             $("#inputCanCreatePersonality").val(),
            create_images:                  $("#inputCanCreateImages").val(),
            create_memes:                   $("#inputCanCreateMemes").val(),
            create_videos:                  $("#inputCanCreateVideos").val(),
            create_articles:                $("#inputCanCreateArticles").val(),
            create_lists:                   $("#inputCanCreateLists").val(),

            view_polls:                     $("#inputCanViewPolls").val(),
            view_quiz:                      $("#inputCanViewQuiz").val(),
            view_images:                    $("#inputCanViewImages").val(),
            view_videos:                    $("#inputCanViewVideos").val(),
            view_articles:                  $("#inputCanViewArticles").val(),
            view_lists:                     $("#inputCanViewLists").val(),

            check_poll_page_content:        $("#checkPollPageContent").prop('checked'),
            check_poll_style:               $("#checkPollStyle").prop('checked'),
            check_poll_animation:           $("#checkPollAnimation").prop('checked'),
            check_quiz_page_content:        $("#checkQuizPageContent").prop('checked'),
            check_quiz_animation:           $("#checkQuizAnimation").prop('checked'),
            check_quiz_style:               $("#checkQuizStyle").prop('checked'),
            check_quiz_timed:               $("#checkQuizTimedQuiz").prop('checked'),
            check_quiz_timer:               $("#checkQuizTimer").prop('checked'),
            check_quiz_randomize_questions: $("#checkQuizRandomizeQuestions").prop('checked'),
            check_quiz_randomize_answers:   $("#checkQuizRandomizeAnswers").prop('checked'),
            check_quiz_show_correct_answer: $("#checkQuizShowCorrectAnswer").prop('checked'),
            check_image_page_content:       $("#checkImagePageContent").prop('checked'),
            check_meme_page_content:        $("#checkMemePageContent").prop('checked'),
            check_video_page_content:       $("#checkVideoPageContent").prop('checked'),
            check_list_page_content:        $("#checkListPageContent").prop('checked'),
            check_list_style:               $("#checkListStyle").prop('checked'),
            check_list_animation:           $("#checkListAnimation").prop('checked'),
            poll_style:                     $("#inputPollStyle").val(),
            poll_animation:                 $("#inputPollAnimation").val(),
            quiz_animation:                 $("#inputQuizAnimation").val(),
            quiz_style:                     $("#inputQuizStyle").val(),
            quiz_timed:                     $("#inputQuizTimed").val(),
            quiz_timer:                     $("#inputQuizTimer").val(),
            quiz_randomize_questions:       $("#inputQuizRandomizeQuestions").val(),
            quiz_randomize_answers:         $("#inputQuizRandomizeAnswers").val(),
            quiz_show_correct_answer:       $("#inputQuizShowCorrectAnswer").val(),
            list_style:                     $("#inputListStyle").val(),
            list_animation:                 $("#inputListAnimation").val()
        };

        $.post( '', formObj).always(function(response){
            console.log(response);

            $("#settingsForm").find(":input").prop("disabled", false);

            if(response.status == 2){
                $("#settingsStatus").html('<div class="alert alert-success"><strong>Success!</strong></div>');
            }else{
                $("#settingsStatus").html('<div class="alert alert-warning">Unable to update settings. Please try again later.</div>');
            }
        });
    });
})(jQuery, window);