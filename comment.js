$(document).ready(function(){
    function danger(obj) {
        obj.css("border", "2px solid red");
    }
    function safe(obj) {
        obj.css("border", "2px solid #cccccc");
    }

    var $error_msg = $("#error-msg");
    var $success_msg = $("#success-msg");
    var $comment_form_wrapper = $("#comment-form-wrapper");
    var $comment_type = $("#comment-type");
    var $comment_body= $("#comment-body");
    var $comment_notify = $("#comment-notify");
    var $comment_email = $("#comment-email");
    var $comment_email_wrapper = $("#comment-email-wrapper");
    $comment_email_wrapper.hide();

    $comment_notify.click(function() {
        if($(this).attr("checked")) {
            $comment_email_wrapper.show();
        } else {
            $comment_email_wrapper.hide();
        }
    });

    $("#comment-form").submit(function(e) {
        /* reset all the previous errors */
        var errors = 0;
        safe($comment_type);
        safe($comment_body);
        safe($comment_email);
        
        if(!$("#example").val()) {
            $error_msg.html("Please select a category, book, chapter and an example before reporting a bug.")
            $error_msg.show();
            errors = 1;
        }
        if(!$comment_type.val()){
            danger($comment_type);
            errors = 1;
        } 
        if(!$comment_body.val()) {
            danger($comment_body);
            errors = 1;
        } 
        if($comment_notify.attr("checked") && !$comment_email.val()) {
            danger($comment_email);
            errors = 1;
        }
        if(!errors) {
            $.ajax({
                url: "comment.php",
                data: {
                    category: $("#categories").val(),
                    books: $("#books").val(),
                    chapter: $("#books").val(),
                    example: $("#example").val(),
                    type: $comment_type.val(),
                    comment: $comment_body.val(),
                    email: $comment_email.val(),
                },
                type: "POST",
                dataType: "html",
                success: function(data) {
                    $comment_form_wrapper.hide();
                    $success_msg.show();
                }
            });
        }
        e.preventDefault();
    });

    $("#commentBtn").click(function() {
        $error_msg.hide();
        $success_msg.hide();
        $comment_form_wrapper.show();
    });
});

