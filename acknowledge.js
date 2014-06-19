$(document).ready(function() {
    $categories = $("#categories");
    $books = $("#books");
    $chapter = $("#chapter");
    $example = $("#example");
    $acknowledge = $("#acknowledge");

    $books.live("change", function() {
        var book_id = $(this).val();
        $.ajax({
            url: "acknowledge.php",
            type: "POST",
            data: {
                book_id: book_id
            },
            dataType: "html",
            success: function(data) {
                $acknowledge.html(data);
                $("#contrib").show();
                $("#book-download").show();
            }
        });
    });
    $chapter.live("change", function() {
        $("#chapter-download").show();
    });
    $example.live("change", function() {
        $("#example-download").show();
    });
    $categories.change(function() {
        $("#contrib").hide();
        $("#book-download").hide();
        $("#chapter-download").hide();
        $("#example-download").hide();
    });

    /* book, chapter and example download */
    $("#book-download").live("click", function() {
        window.location = "http://scilab.in/download/book/" + $("#books").val();
    });
    $("#chapter-download").live("click", function() {
        window.location = "http://scilab.in/download/chapter/" + $("#chapter").val();
    });
    $("#example-download").live("click", function() {
        window.location = "http://scilab.in/download/example/" + $("#example").val();
    });
});
