<?php

class loggingService {

    public static function log($action) {

        $file = __DIR__ . '/../../logs/audit.log';

        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($file, "[$timestamp] $action" . PHP_EOL, FILE_APPEND);

    }

}

?>