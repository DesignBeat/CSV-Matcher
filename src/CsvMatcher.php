<?php

namespace DesignBeat\Matchers\CSV;

use InvalidArgumentException;

class CsvMatcher
{

    const MAGICAL = '.';

    /** @var CsvReader */
    private $reader;

    /**
     * @param CsvReader $reader
     */
    public function __construct(CsvReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param array $scheme
     * @return array
     */
    public function match(array $scheme)
    {
        $result = [];
        while (($line = $this->reader->readLine()) !== FALSE) {
            $this->validateLineScheme($scheme, $line);

            $liner = [];
            foreach ($line as $n => $v) {
                // Skip it
                if (!isset($scheme[$n]) || $scheme[$n] === NULL) continue;

                // Match value
                $this->matchValue($v, $liner, $this->parseMagical($scheme[$n]));
            }

            $result[] = $liner;
        }

        return $result;
    }

    /**
     * HELPERS *****************************************************************
     */

    /**
     * @param mixed $value
     * @param array $liner [reference]
     * @param array $keys
     */
    protected function matchValue($value, &$liner, $keys)
    {
        if (count($keys) > 1) {
            $tmp = array_shift($keys);
            if (!isset($liner[$tmp])) $liner[$tmp] = [];
            $liner[$tmp][current($keys)] = [];
            $this->matchValue($value, $liner[$tmp], $keys);
        } else {
            $liner[current($keys)] = $value;
        }
    }

    /**
     * @param string $field
     * @return array
     */
    protected function parseMagical($field)
    {
        return explode(self::MAGICAL, $field);
    }

    /**
     * @param array $scheme
     * @param array $line
     * @throws InvalidArgumentException
     */
    protected function validateLineScheme(array $scheme, array $line)
    {
        if (count($scheme) > count($line)) {
            throw new InvalidArgumentException('Scheme has more fields then line');
        }
    }

}