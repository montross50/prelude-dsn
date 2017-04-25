<?php

namespace Prelude\Dsn;

use Prelude\Database\DsnException as PreludeDsnException;

/**
 * @deprecated Please refactor your code to use `Prelude\Database`
 *             More information: https://github.com/eridal/prelude-database
 */
class DsnException extends PreludeDsnException {

    /**
     * @throws Prelude\Dsn\DsnException
     */
    static function rethrow(PreludeDsnException $e) {
        throw new DsnException($e->getMessage(), $e->getCode(), $e);
    }

}
