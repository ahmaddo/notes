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

    public function addNote($note)
    {
        $note['type'] = strtolower($note['type']);
        $this->allNotes['notes'][] = $note;
        $this->writeToNotes();
    }

    private function writeToNotes()
    {
        $file = fopen(self::NOTES_FILE, 'w+');
        fwrite($file, json_encode($this->allNotes));
        fclose($file);
    }

}
