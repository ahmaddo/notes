<?php
/**
 * User: Ahmad
 * Project notes
 * Date: 27.04.2017
 * Time: 10:41
 */
require_once 'class/Notes.php';
use \notes\Notes as Notes;

echo 'add note template';
$notes = new Notes();
$newNote = 'first note';
if(isset($newNote)) {
    //$note = $_GET['note'];
    $notes->addNote($newNote);
}
$loadedNotes = $notes->getAllNotes();
foreach ($loadedNotes['notes'] as $loadedNote) {
    echo $loadedNote;
    echo "<br />\n";
}