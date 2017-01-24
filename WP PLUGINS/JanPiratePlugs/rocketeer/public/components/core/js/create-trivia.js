/**
 * Created by jaskokoyn on 11/16/2015.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    var vm                              =   new Vue({
        el: '#createTriviaForm',
        data: {
            media_type: 0,
            images: [],
            image_ids: [],
            question_index: 0,
            result_index: 0,
            questions: [],
            results: []
        },
        methods: {
            addQuestion: function(event){
                this.questions.push({
                    question: 'Question #' + (this.questions.length+1),
                    media_type: 0,
                    explanation: '',
                    answer_display_type: 1,
                    images: [],
                    embed_url: null,
                    embed_code: null,
                    quote: null,
                    quote_src: null,
                    answers: []
                });
            },
            removeQuestion: function(index){
                if(!confirm(are_you_sure_message)){
                    return null;
                }

                this.questions.splice(index, 1);
            },
            updateQuestionIndex:  function(index, $event){
                $event.preventDefault();
                this.question_index       =   index;
            },
            addAnswer: function(event){
                this.questions[this.question_index].answers.push({
                    answer: null,
                    img: 0,
                    isCorrect: 1
                });
            },
            removeAnswer: function(index, $event){
                this.questions[this.question_index].answers.splice(index, 1);
            },
            addResult: function(event){
                this.results.push({
                    title: 'Result',
                    desc: null,
                    main_img: 0,
                    min: 0,
                    max: 0
                });
            },
            removeResult: function(index){
                if(!confirm(are_you_sure_message)){
                    return null;
                }
                this.results.splice(index, 1);
            },
            updateResultIndex: function(index, $event){
                $event.preventDefault();
                this.result_index       =   index;
            }
        }
    });

    var imgDpz                          =   new Dropzone("#imgDropzone", {
        url: ajaxurl + "/process/upload-media-img",
        previewsContainer: "#imgPreviewCtr",
        acceptedFiles: 'image/*',
        paramName: 'img',
        previewTemplate: '<div class="dz-preview dz-file-preview">' +
        '<div class="dz-details">' +
        '<div class="dz-filename"><span data-dz-name></span></div>' +
        '<div class="progress">' +
        '<div class="progress-bar progress-bar-info progress-bar-striped active" data-dz-uploadprogress>' +
        '</div>' +
        '</div>' +
        '</div>'
    });

    imgDpz.on( "sending", function(file, xhr, formData){
        formData.append( '_token', $("input[name=_token]").val() );
    });

    imgDpz.on( "error", function(file, errorMessage, xhr ){
        console.log(errorMessage, xhr);
        toastr.error(img_upload_error_message);
    });

    imgDpz.on( "success", function(file, res){
        $(file.previewElement).remove();

        if(res.status == 1){
            toastr.error(img_upload_error_message);
            return;
        }

        vm.images.push({
            id: res.img.id,
            name: res.img.name
        });

        vm.image_ids.push(res.img.id);

        toastr.success(file_upload_success, simple_success_message);
    });

    $(document).on( "submit", "#createTriviaForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">' + processing_message + '</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            title:                          $("#inputTitle").val(),
            desc:                           $("#inputDesc").val(),
            cid:                            $("#inputCid").val(),
            nsfw:                           $("#inputNSFW").val(),
            page_content:                   CKEDITOR.instances.inputPageContent.getData(),
            style:                          $("#inputStyle").val(),
            animation:                      $("#inputAnimation").val(),
            thumbnail:                      $("#inputThumbnail").val(),
            questions:                      vm.$get("questions"),
            results:                        vm.$get("results"),
            timed_quiz:                     $("#inputTimedQuiz").val(),
            timed_seconds:                  $("#inputTimedSeconds").val(),
            randomize_questions:            $("#inputRandomizeQuestions").val(),
            randomize_answers:              $("#inputRandomizeAnswers").val(),
            show_correct_answer:            $("#inputShowCorrectAnswer").val(),
            image_ids:                      vm.$get("image_ids")
        };

        $(this).slideUp('fast', function(){
            $.post( '', formObj).always(function(response){
                if(response.status == 2){
                    if(response.is_approved == 2){
                        $("#alertStatus").html('<div class="alert alert-success">' + success_message + '</div>');
                        location.href           =   response.url;
                    }else{
                        $("#alertStatus").html('<div class="alert alert-success">' + pending_success_message + '</div>');
                    }
                }else{
                    $("#createTriviaForm").slideDown('fast');
                    $("#alertStatus").html('<div class="alert alert-danger">' + unable_submission + ' <ul></ul></div>');
                    response.errors.forEach(function(ele,ind,arr){
                        $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                    });
                }
            });
        });
    });
})(jQuery, window);