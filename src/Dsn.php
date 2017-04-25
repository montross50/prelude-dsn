<?php

namespace Prelude\Dsn;

use Prelude\Database\Dsn as PreludeDatabaseDsn;

/**
 * @deprecated Please refactor your code to use `Prelude\Database`
 *             More information: https://github.com/eridal/prelude-database
 */
class Dsn extends PreludeDatabaseDsn {

    function __construct(array $config) {

        try {
            parent::__construct($config);
        } catch(\Prelude\Database\DsnException $e) {
            throw DsnException::rethrow($e);
        }
    }
}
