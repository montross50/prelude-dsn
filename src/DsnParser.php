<?php

namespace Prelude\Dsn;

use Prelude\Database\DsnParser as PreludeDatabaseDsnParser;
use Prelude\Database\DsnException as PreludeDatabaseDsnException;

/**
 * @deprecated Please refactor your code to use `Prelude\Database`
 *             More information: https://github.com/eridal/prelude-database
 */
class DsnParser extends PreludeDatabaseDsnParser {

    /**
     * @deprecated
     */
    static function parseFile($file) {
        try {
            return parent::parseFile($file);
        } catch (PreludeDatabaseDsnException $e) {
            throw DsnException::rethrow($e);
        }
    }

    /**
     * @deprecated
     */
    static function parseEnv($key) {
        try {
            return parent::parseEnv($key);
        } catch (PreludeDatabaseDsnException $e) {
            throw DsnException::rethrow($e);
        }
    }
}


