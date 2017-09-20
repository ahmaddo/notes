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
        if ($this->allNotes['notes']){
            krsort($this->allNotes['notes']);
        }
    }

    public function postData($notes)
    {
        if ($_FILES['fileselect']['size'][0] > 0) {
            $this->uploadFile($notes);
        } else {
            $this->addNote($notes);
        }
    }

    private function uploadFile($notes)
    {
        $subDir = $notes['content'] ? $notes['content'] : date('Y-m-d');

        if (!is_dir(self::UPLOAD_DIR)) {
            $this->makeDir();
        }

        if (!is_dir(self::UPLOAD_DIR.'/'.$subDir)) {
            $this->makeDir($subDir);
        }


        $files = $_FILES['fileselect'];
        foreach ($files['name'] as $fileNumber => $fileName){
            $fileName =  self::UPLOAD_DIR ."/".$subDir . '/'. $fileName;
            move_uploaded_file($files['tmp_name'][$fileNumber], $fileName);
            $this->givePermission($fileName);
            $note['content'] = $fileName;
            $note['type'] = 'link';
            $this->addNote($note);
        }
    }

    private function makeDir($dir = '')
    {
        try{
            mkdir(self::UPLOAD_DIR . '/' . $dir, 0755);
        } catch (\Exception $e ) {
            $e->getMessage();
        }
    }

    private function givePermission($fileName)
    {
        $mime = mime_content_type ($fileName);
        if (strpos($mime,'application')){
            chmod($fileName, 0444);
        } else {
            chmod($fileName, 0644);
        }
    }

    public function addNote($note)
    {
        $note['post_date'] = date('Y-m-d H:i:s');
        $note['ip_address'] = $_SERVER['REMOTE_ADDR'];

        $note['uuid'] = $this->getRandomId();
        $note['type'] = strtolower($note['type']);
        if ($note['type'] == 'paragraph') {
            $note['content'] = $note['paragraphContent'];
        }
        $firstFourLetters =  substr($note['content'], 0,4);
        if (
            in_array($firstFourLetters,  ['http',  'ftp:', 'www.'])) {
            $note['type'] = 'link';
        }
        $note['content'] = htmlspecialchars($note['content']);
        unset($note['paragraphContent']);
        $this->allNotes['notes'][] = $note;
        $this->writeToNotes();
    }

    private function getRandomId()
    {
        return uniqid();
        // fot php 7
        //$bytes = random_bytes(5);
        //return bin2hex($bytes);
    }

    private function writeToNotes()
    {
        $file = fopen(self::NOTES_FILE, 'w+');
        fwrite($file, json_encode($this->allNotes, JSON_PRETTY_PRINT));
        fclose($file);
    }

}
