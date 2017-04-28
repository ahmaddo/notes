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
if(isset($_POST['newMoIt'])) {
    $note = $_POST['newMoIt'];
    $notes->addNote($note);
}
$loadedNotes = $notes->getAllNotes();
foreach ($loadedNotes['notes'] as $loadedNote) {
    echo $loadedNote;
    echo "<br />\n";
}