<?php

class Cache
{

    function get($fileName)
    {
        $fileName = ROOT . DS . 'tmp' . DS . 'cache' . DS . $fileName;

        if (file_exists($fileName)) {
            $handle = fopen($fileName, 'rb');
            $variable = fread($handle, filesize($fileName));
            fclose($handle);
            return unserialize($variable);
        } else {
            return null;
        }
    }

    function set($fileName, $variable)
    {
        if (!file_exists(ROOT . DS . 'tmp' . DS . 'cache')) {
            mkdir(ROOT . DS . 'tmp' . DS . 'cache', 0777, true);
        }

        $fileName = ROOT . DS . 'tmp' . DS . 'cache' . DS . $fileName;
        $handle = fopen($fileName, 'a');
        fwrite($handle, serialize($variable));
        fclose($handle);
    }

}
