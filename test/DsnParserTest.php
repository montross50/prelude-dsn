<?php

namespace Prelude\Dsn;

use Prelude\Asserts;
use Prelude\Database\Dsn as PreludeDatabaseDsn;

class DsnParserTest extends \PHPUnit_Framework_TestCase {

    private static $STR_CONFIG = array(
        'driver' => 'driver',
          'host' => 'host.tld',
          'user' => 'u',
          'pass' => 'p',
    );

    private static $ARR_CONFIG = array(
        'driver' => 'pgsql',
          'host' => 'pg.sql'
    );

    function test_parseFile_missing() {
        Asserts::throws($this, function () {
            DsnParser::parseFile(__FILE__ . '-missing-file.php');
        }, new DsnException());
    }

    function test_parseFile_array() {
        $dsn = DsnParser::parseFile(__FILE__ . '-array.php');
        $this->go_testDsn($dsn, self::$ARR_CONFIG);
    }

    function test_parseFile_string() {
        $dsn = DsnParser::parseFile(__FILE__ . '-string.php');
        $this->go_testDsn($dsn, self::$STR_CONFIG);
    }

    function test_parseEnv() {
        $_ENV['DATABASE_URL'] = require __FILE__ . '-string.php';
        $dsn = DsnParser::parseEnv('DATABASE_URL');
        $this->go_testDsn($dsn, self::$STR_CONFIG);
    }

    function test_parseUrl() {
        $dsn = DsnParser::parseUrl(require __FILE__ . '-string.php');
        $this->go_testDsn($dsn, self::$STR_CONFIG);
    }

    function test_parseArray() {
        $dsn = DsnParser::parseArray(require __FILE__ . '-array.php');
        $this->go_testDsn($dsn, self::$ARR_CONFIG);
    }

    function test_parse_throwsWithOthers() {
        Asserts::throws($this, function () {
            $_ENV[__METHOD__] = true;
            DsnParser::parseEnv(__METHOD__);
        }, new DsnException());
    }

    function test_parse_throwsWhenKeyIsMissing() {
        Asserts::throws($this, function () {
            unset($_ENV[__METHOD__]);
            DsnParser::parseEnv(__METHOD__);
        }, new DsnException());
    }

    private function go_testDsn(PreludeDatabaseDsn $dsn, array $config) {
        $dsn = new Dsn($dsn->toArray());
        forEach ($config as $key => $value) {
            $this->assertEquals($value, $dsn->{$key});
        }
    }
}
