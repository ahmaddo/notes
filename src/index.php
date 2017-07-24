<!<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="icon" href="media/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/notes.css">
    <title>Notes</title>
</head>
<body>
<div>
    <?php
        require_once 'class/Notes.php';
        require_once 'class/Templates.php';

        use \notes\Notes as Notes;
        use \notes\Templates as Templates;
    ?>
    <div>
        <?php echo Templates::getFormTemplate(); ?>
    </div>
    <div id="notes-container">
        <div id="notes-list">
            <?php
            $notes = new Notes();
            if(isset($_POST['content'])) {
                //var_dump($_POST);
                $note = $_POST;
                $notes->postData($note);
            }
            $loadedNotes = $notes->getAllNotes();
            echo Templates::getNotesList($loadedNotes);

            echo Templates::getAdsTemplate();
            echo Templates::getAdsTemplate(1);
            ?>
        </div>
        <div id="sidebar">
            <div id="right-sidebar">
                <?php echo Templates::getAdsTemplate('right-side-bar')?>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/notes.js"></script>
</body>
</html>
