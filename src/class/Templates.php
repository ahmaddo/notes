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
            if (($loadedNote['type']) == 'link') {
                if (substr($loadedNote['content'], 0, 6) == 'upload' && exif_imagetype($loadedNote['content'])) {
                    $notesLis .= '<li>' . self::getLinkTemplate($loadedNote['content'], self::getImageTemplate($loadedNote['content']))  . '</li>' ;
                } else {
                    $notesLis .= '<li>' . self::getLinkTemplate($loadedNote['content']) . '</li>' ;
                }
            }else{
                $notesLis .= '<li>' . $loadedNote['content'] . '</li>' ;
            }
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

    static public function getAdsTemplate($nr = 0)
    {
        $ads = [
            '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- notes -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-5424113881121819"
                 data-ad-slot="4545244281"
                 data-ad-format="auto"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>',

            '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- notes footer -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-5424113881121819"
                 data-ad-slot="7359109885"
                 data-ad-format="auto"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>'
        ];

        return $ads[$nr];
    }
}