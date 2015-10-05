<?php

namespace DesignBeat\Matchers\CSV;

class CsvReader
{

    /** @var string */
    protected $file;

    /** @var string */
    protected $content;

    /** @var int */
    protected $pointer = 0;

    /** @var string */
    protected $delimiter;

    /** @var string */
    protected $enclosure;

    /**
     * @param string $file
     * @param string $delimiter
     * @param string $enclosure
     */
    function __construct($file, $delimiter = ';', $enclosure = '"')
    {
        $this->file = $file;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    /**
     * Read file contents
     */
    private function _read()
    {
        if ($this->content === NULL) {
            // Read from file
            $this->content = @file($this->file);
            // Parse CSV
            foreach ($this->content as $n => $line) {
                $this->content[$n] = str_getcsv($this->content[$n], $this->delimiter, $this->enclosure);
            }
        }
    }

    /**
     * Read line from CSV
     *
     * @return array
     */
    public function readLine()
    {
        $this->_read();
        if (isset($this->content[$this->pointer])) {
            return $this->content[$this->pointer++];
        }
        return FALSE;
    }

    /**
     * Read all lines from CSV
     *
     * @return array
     */
    public function read()
    {
        $this->_read();
        return $this->content;
    }

}
