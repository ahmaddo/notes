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
        $notesList = '<ul>';
        foreach ($loadedNotes['notes'] as $loadedNote) {
            if (isset($loadedNote['uuid'])) {
                $notesList .= '<li name="'. $loadedNote['uuid'] .'">';
            } else {
                $notesList .= '<li>';
            }

            $loadedNote['content'] = nl2br($loadedNote['content']);
            if (($loadedNote['type']) == 'link') {
                $notesList .= self::handelLinks($loadedNote);
            }else{
                $notesList .= $loadedNote['content']  ;
            }

            echo '</li>';
        }
        $notesList .= '</ul>';

        return $notesList;
    }

    //TODO refactor
    static private function handelLinks($loadedNote)
    {
        if (substr($loadedNote['content'], 0, 6) == 'upload' ) {
            if (file_exists($loadedNote['content'])){
                if (exif_imagetype($loadedNote['content'])) {
                    return  self::getLinkTemplate($loadedNote['content'], self::getImageTemplate($loadedNote['content'])) ;
                } else {
                    return self::getLinkTemplate($loadedNote['content']) ;
                }
            }
        } else {
            $multipleLinesLinks = self::hasMultipleLines($loadedNote['content']);
            if (count($multipleLinesLinks) > 1) {
                $links = '';
                foreach ($multipleLinesLinks as $link) {
                    $loadedNote['content'] = $link;
                     $links .= self::handelLinks($loadedNote). '<br />';
                }
                return $links;
            }

            return self::getLinkTemplate($loadedNote['content'], null, '')  ;
        }
        return '';
    }

    static public function hasMultipleLines($links)
    {
        $links = explode('<br />', $links);
        if (is_array($links)) {
            return $links;
        }

        return false;
    }

    static public function getLinkTemplate($link, $innerText = null, $preDir =  Notes::UPLOAD_DIR . '/' )
    {
        if (!$innerText) {
            $link = self::reformatFileTitle($link);
            return '<a href="' . $preDir . $link.'" target="_blank">'.$link.'</a>';
        }
        return '<a href="'.$link.'" target="_blank">'. $innerText .'</a>';
    }

    static public function reformatFileTitle($link)
    {
        $dirs = explode('/', $link);
        if ($dirs[0] == Notes::UPLOAD_DIR){
            return substr($link, 7);
        }

        return $link;
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
            </script>',

            'right-side-bar' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- notes-right-sidebar -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-5424113881121819"
                     data-ad-slot="1358279323"
                     data-ad-format="auto"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>',

            'Rojava-sidebar-1' => '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Rojava-sidebar-1 -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-5424113881121819"
                     data-ad-slot="2327603840"
                     data-ad-format="auto"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>'
        ];

        return $ads[$nr];
    }
}