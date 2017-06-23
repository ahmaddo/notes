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
    static public function getFormTemplate()
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
                <textarea name="paragraphContent" hidden></textarea>
                <input type="submit" value="Add">
            </form>
        </div>
        ';
    }

    static public function getNotesList($loadedNotes)
    {
        if (!isset($loadedNotes['notes'])) return null;
        $notesLis = '<ul>';
        foreach ($loadedNotes['notes'] as $loadedNote) {
            switch ($loadedNote['type']):
                case 'file':
                    if (exif_imagetype($loadedNote['content'])) {
                        $notesLis .= self::getLi() . self::getImageTemplate($loadedNote['content']) . '</li>' ;
                    } else {
                        $notesLis .= self::getLi() . $loadedNote['content'] . '</li>' ;
                    }
                    break;
                case 'link':
                    $notesLis .= self::getLi() . self::getLinkTemplate($loadedNote['content']) . '</li>' ;
                    break;
                default:
                    $notesLis .= self::getLi() . $loadedNote['content'] . '</li>' ;
            endswitch;
        }
        $notesLis .= '</ul>';

        return $notesLis;
    }

    static public function getLi()
    {
        return  '<li>';
    }

    static public function getHeaders()
    {
        return '
             <link rel="stylesheet" type="text/css" href="css/notes.css">
             <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
             <script src="js/notes.js"></script>
        ';
    }

    static public function getLinkTemplate($link)
    {
        return '<a href="'.$link.'">'.$link.'</a>';
    }

    static public function getImageTemplate($link)
    {
        return '<image src="'.$link.'" target="_blank">';
    }
}