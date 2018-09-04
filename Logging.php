<?php

namespace Extension\Google;

class Logging extends \Core\Module
{
    public static function logCommand($command, $args, $options)
    {
        echo "moi\n";
        return true;
    }
}
