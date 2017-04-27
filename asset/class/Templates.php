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
                <input type="text" autocomplete="off" id="newMoIt" name="newMoIt" autofocus>
                <input type="submit" value="Add">
            </form>
        </div>
        ';
    }
}