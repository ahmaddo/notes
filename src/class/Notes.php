<?php
/**
 * User: Ahmad
 * Project notes
 * Date: 27.04.2017
 * Time: 09:23
 */

namespace notes;


class Notes
{

    const NOTES_FILE = 'notes.json';
    const UPLOAD_DIR = 'upload';
    private $allNotes =[];


    function __construct()
    {
        if (is_readable(self::NOTES_FILE)){
            $this->allNotes = json_decode(file_get_contents(self::NOTES_FILE), true);
        } else {
            touch(self::NOTES_FILE);
            $this->allNotes['notes'] = [];
        }
    }

    public function getAllNotes()
    {
        $this->sortAllNotesDESC();
        return $this->allNotes;
    }

    private function sortAllNotesDESC()
    {
        krsort($this->allNotes['notes']);
    }

    public function postData($notes)
    {
        if ($_FILES['fileselect']['size'][0] > 0) {
            if (!is_dir(self::UPLOAD_DIR)) {
                mkdir(self::UPLOAD_DIR, 0755);
            }
            $files = $_FILES['fileselect'];
            foreach ($files['name'] as $fileNumber => $fileName){
                $fileNameArray = array_reverse( explode('.', $fileName));
                $fileExtension = $fileNameArray[0];
                $tempRandomName = uniqid() . '.' . $fileExtension;
                $newFileName =  self::UPLOAD_DIR ."/". $tempRandomName;
                move_uploaded_file($files['tmp_name'][$fileNumber], $newFileName);
                chmod($newFileName, 0644);
                $note['content'] = $newFileName;
                $note['type'] = 'link';
                $this->addNote($note);
            }
        } else {
            $this->addNote($notes);
        }
    }

    public function addNote($note)
    {
        $note['type'] = strtolower($note['type']);
        if ($note['type'] == 'paragraph') {
            $note['content'] = $note['paragraphContent'];
        }

        $note['content'] = htmlspecialchars($note['content']);
        unset($note['paragraphContent']);
        $this->allNotes['notes'][] = $note;
        $this->writeToNotes();
    }

    private function writeToNotes()
    {
        $file = fopen(self::NOTES_FILE, 'w+');
        fwrite($file, json_encode($this->allNotes, JSON_PRETTY_PRINT));
        fclose($file);
    }

}
