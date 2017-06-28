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
                        $notesLis .= '<li>' . self::getLinkTemplate($loadedNote['content'], self::getImageTemplate($loadedNote['content']))  . '</li>' ;
                        break;
                    } else {
                        $notesLis .= '<li>' . self::getLinkTemplate($loadedNote['content']) . '</li>' ;
                        break;
                    }
                default:
                    $notesLis .= '<li>' . $loadedNote['content'] . '</li>' ;
            endswitch;
        }
        $notesLis .= '</ul>';

        return $notesLis;
    }

    static public function getLinkTemplate($link, $innerText = null)
    {
        if (!$innerText) {
            return '<a href="'.$link.'" target="_blank">'.$link.'</a>';
        }
        return '<a href="'.$link.'" target="_blank">'. $innerText .'</a>';
    }

    static public function getImageTemplate($link)
    {
        return '<image src="'.$link.'">';
    }
}