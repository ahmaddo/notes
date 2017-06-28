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
            <form method="post" action="'.$_SERVER['PHP_SELF'].'" name="notesForm" accept-charset="utf-8" enctype="multipart/form-data">
                <label for="">Your new NoIt:</label>
                <select name="type">
                  <option name="text">Text</option>
                  <option name="paragraph">Paragraph</option>
                  <option name="link">Link</option>
                </select>
                <input type="text" autocomplete="off" name="content" autofocus style="width: 80%;">
                <textarea name="paragraphContent" hidden></textarea>
                <input type="submit" value="Add">
                <input type="file" name="fileselect[]" multiple="multiple" />
            </form>
        </div>
        ';
    }

    static public function getNotesList($loadedNotes)
    {
        if (!isset($loadedNotes['notes'])) return null;
        $notesLis = '<ul>';
        foreach ($loadedNotes['notes'] as $loadedNote) {
            $loadedNote['content'] = nl2br($loadedNote['content']);
            switch ($loadedNote['type']):
                case 'link':
                    if (exif_imagetype($loadedNote['content'])) {
                        $notesLis .= self::getLi() . self::getImageTemplate($loadedNote['content']) . '</li>' ;
                        break;
                    } else {
                        $notesLis .= self::getLi() . self::getLinkTemplate($loadedNote['content']) . '</li>' ;
                        break;
                    }
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
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
             <link rel="stylesheet" type="text/css" href="css/notes.css">
             <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
             <script src="js/notes.js"></script>
        ';
    }

    static public function getLinkTemplate($link)
    {
        return '<a href="'.$link.'" target="_blank">'.$link.'</a>';
    }

    static public function getImageTemplate($link)
    {
        return '<image src="'.$link.'">';
    }
}