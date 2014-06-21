<?php 
    $elements = array();
    require_once('db-connect.php');

    /* initializing variables */
    $chapter_id = 0;
    $preference_id = 0;
    $category_id = 0;

    function get_elements($example_id) {
        /* retreving examples */
        $query = "SELECT id, caption, number, chapter_id FROM textbook_companion_example 
            WHERE cloud_err_status=0 AND chapter_id = (
                SELECT chapter_id FROM textbook_companion_example WHERE id = {$example_id}
            )
        ";
        $result = mysql_query($query);
        $data = '<select name="example" id="example">';
        $data .= '<option value="">-- Select an example --</option>';
        while($row = mysql_fetch_object($result)) {
            if($example_id == $row->id) $selected = "selected"; else $selected="";
            $data .= "<option value='{$row->id}' {$selected}>" . $row->number . ' &nbsp;-&nbsp; ' . $row->caption . '</option>';
            $chapter_id = $row->chapter_id;
        }
        $data .= '</select>';
        $data .= '<span id="example-download" style="display: inline;"> <a href="#">Download Example</a></span>';
        $elements["examples"] = $data;
        
        /* retreving chapters */
        $query = "
            SELECT id, name, number, preference_id FROM textbook_companion_chapter 
            WHERE cloud_chapter_err_status=0 AND preference_id = (
                SELECT preference_id FROM textbook_companion_chapter WHERE id = {$chapter_id}
            ) 
            ORDER BY number ASC
        ";
        $result = mysql_query($query);
        $data = '<select name="chapter" id="chapter">';
        $data .= '<option value="">-- Select chapter --</option>';
        while($row = mysql_fetch_object($result)){
            if($chapter_id == $row->id) $selected = "selected"; else $selected="";
            $data .= "<option value='{$row->id}' {$selected}>" . $row->number . ' &nbsp;-&nbsp; ' . $row->name . '</option>';
            $preference_id = $row->preference_id;
        }
        $data .= '</select>';
        $data .= '<span id="chapter-download" style="display: inline;"> <a href="#">Download Chapter</a></span>';
        $elements["chapters"] = $data;
        
        /* retreving  books*/
        $query = "
            SELECT pre.id, pre.book, author, category FROM textbook_companion_preference pre 
            WHERE pre.approval_status=1 AND pre.category = (
                SELECT category FROM textbook_companion_preference WHERE id = {$preference_id}
            ) AND cloud_pref_err_status=0 and pre.proposal_id IN (
                SELECT id from textbook_companion_proposal where proposal_status=3
            ) ORDER BY pre.book ASC
        ";
        $result = mysql_query($query);
        $data = '<select id="books" name="books">';
        $data .= '<option value="">-- Select book --</option>';
        $counter = 1;
        while($row = mysql_fetch_object($result)){
            $counter_str = '';
            if($counter < 10) {
                $counter_str = '&nbsp;&nbsp;&nbsp;'.$counter.'.&nbsp;&nbsp;';
            }elseif($counter < 100) {
                $counter_str = '&nbsp;'.$counter.'.&nbsp;&nbsp;';
            }else {
                $counter_str = $counter.'.&nbsp;&nbsp;';
            }
            if($preference_id == $row->id) $selected = "selected"; else $selected="";
            $data .= "<option value='{$row->id}' {$selected}>" . $counter_str . $row->book . ' (' . $row->author . ')</option>';
            $counter++;
            $category_id = $row->category;
        }
        $data .= '</select>';
        $data .= '<span id="book-download" style="display: inline;"> <a href="#">Download Book</a></span>';
        $elements["books"] = $data;
        $elements["category"] = $category_id;
        
        /* retreving cloud_comments */
        $query = "
            SELECT id FROM scilab_cloud_comment WHERE example = {$example_id}
        ";
        $result = mysql_query($query);
        $elements["nos"] = mysql_num_rows($result);
        
        /* retreving contributor details */
        $book_id = $preference_id;
        $output = "";
        $query = "select * from textbook_companion_preference where id = {$book_id}";
        $result = mysql_query($query);
        $preference =mysql_fetch_array($result);
        $query = "select * from textbook_companion_proposal where id = {$preference['proposal_id']}";
        $result = mysql_query($query);
        $proposal = mysql_fetch_array($result);
        $output .= "<div class='contributor'><b>Contributor:</b> {$proposal['full_name']} </div>";
        $output .= "<div class='teacher'><b>Mentor:</b> {$proposal['faculty']} </div>";
        $output .= "<div class='reviewer'><b>Book Reviewer:</b> {$proposal['reviewer']} </div>";
        $output .= "<div class='download'><b>College Name:</b> {$proposal['university']} </div>";
        $elements["contrib"] = $output;
        
        return $elements;
    }
?>
