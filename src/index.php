<?php
/**
 * User: Ahmad
 * Project notes
 * Date: 27.04.2017
 * Time: 10:41
 */
require_once 'class/Notes.php';
require_once 'class/Templates.php';

use \notes\Notes as Notes;
use \notes\Templates as Templates;

echo Templates::getNoteTemplate();
$notes = new Notes();
if(isset($_POST['content'])) {
    var_dump($_POST);
    $note = $_POST;
    $notes->addNote($note);
}
$loadedNotes = $notes->getAllNotes();
echo Templates::getNotesList($loadedNotes);
