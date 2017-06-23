<?php
/**
 * User: Ahmad
 * Project notes
 * Date: 27.04.2017
 * Time: 10:56
 */

namespace notes;


class Templates
{

    static public function getNoteTemplate()
    {
        return '
        <div>
            <form method="post" action="'.$_SERVER['PHP_SELF'].'" name="notesForm">
                <label for="">Your new NoIt:</label>
                <select name="type">
                  <option name="text">Text</option>
                  <option name="paragraph">Paragraph</option>
                  <option name="link">Link</option>
                  <option name="file">File</option>
                </select>
                <input type="text" autocomplete="off" name="content" autofocus style="width: 80%;">
                <input type="submit" value="Add">
            </form>
        </div>
        ';
    }

    static public function getNotesList($loadedNotes)
    {
        if (!isset($loadedNotes['notes'])) return null;
        $notesLis = '
            <ul>
        ';
        foreach ($loadedNotes['notes'] as $loadedNote) {
            $notesLis .= '<li>' . $loadedNote['content'];
            $notesLis .= '</li>' ;
        }
        $notesLis .= '</ul>';

        return $notesLis;
    }

    static public function getHeaders()
    {
        return '
             <link rel="stylesheet" type="text/css" href="css/notes.css">
        ';
    }
}