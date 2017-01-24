/**
 * Created by jaskokoyn on 12/16/2015.
 */
(function($, w){
    CKEDITOR.replace('inputPageContent');

    var vm                              =   new Vue({
        el: '#editMediaApp',
        data: {
            thumbnail: thumbnail,
            images: user_uploads,
            image_ids: image_ids,
            question_index: 0,
            questions: mediaObj.questions
        },
        methods: {
            addQuestion: function(event){
                event.preventDefault();
                vm.questions.push({
                    question: 'Question #' + (this.questions.length+1),
                    answer_display_type: 1,
                    media_type: 0,
                    images: [],
                    embed_url: null,
                    embed_code: null,
                    quote: null,
                    quote_src: null,
                    answers: []
                });
            },
            removeQuestion: function(index, $event){
                $event.preventDefault();

                if(!confirm("Are you sure you want to do this? This action can not be undone.")){
                    return null;
                }

                this.questions.splice(index, 1);
            },
            updateQuestionIndex:  function(index, $event){
                $event.preventDefault();
                this.question_index     =   index;
            },
            addAnswer: function(event){
                event.preventDefault();
                this.questions[this.question_index].answers.push({
                    answer: null,
                    img: 0
                });
            },
            removeAnswer: function(index, $event){
                $event.preventDefault();
                this.questions[this.question_index].answers.splice(index, 1);
            }
        }
    });

    var dpz                             =   new Dropzone("#dpz", {
        url: ajaxurl + "process/upload-media-img",
        previewsContainer: "#dpzImgPreviewCtr",
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

    dpz.on( "sending", function(file, xhr, formData){
        formData.append( '_token', $("input[name=_token]").val() );
    });

    dpz.on( "error", function(file, errorMessage, xhr ){
        console.log(errorMessage, xhr);
        toastr.error("Unable to upload image. Try again later.", "Uh Oh!");
    });

    dpz.on( "success", function(file, res){
        $(file.previewElement).remove();

        if(res.status == 1){
            toastr.error('Invalid File Upload', 'Uh Oh!');
            return;
        }

        vm.images.push({
            id: res.img.id,
            upl_name: res.img.new_name,
            original_name: res.img.name
        });

        vm.image_ids.push(res.img.id);

        toastr.success("File uploaded!", "Success!");
    });

    $(document).on( "submit", "#mediaForm", function(e){
        e.preventDefault();

        $("#alertStatus").html('<div class="alert alert-info">Please wait</div>');

        var formObj                     =   {
            _token:                         $("input[name=_token]").val(),
            title:                          $("#inputTitle").val(),
            desc:                           $("#inputDesc").val(),
            cid:                            $("#inputCid").val(),
            nsfw:                           $("#inputNSFW").val(),
            page_content:                   CKEDITOR.instances.inputPageContent.getData(),
            status:                         $("#inputMediaStatus").val(),
            questions:                      vm.$get("questions"),
            thumbnail:                      $("#inputThumbnail").val(),
            style:                          $("#inputStyle").val(),
            animation:                      $("#inputAnimation").val(),
            image_ids:                      vm.$get("image_ids")
        };

        $.post( '', formObj).always(function(response){
            console.log(response);

            if(response.status == 2){
                $("#alertStatus").html('<div class="alert alert-success">Successfully updated!</div>');
            }else{
                $("#alertStatus").html('<div class="alert alert-danger">Error! Unable to update poll. <ul></ul></div>');
                response.errors.forEach(function(ele,ind,arr){
                    $("#alertStatus").find("ul").append("<li>" + ele + "</li>");
                });
            }
        });
    });
})(jQuery, window);