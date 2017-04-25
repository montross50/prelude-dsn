<?php

namespace Prelude\Dsn;

use Prelude\Asserts;

class DsnTest extends \PHPUnit_Framework_TestCase {

    /**
     * Tested object
     */
    private $dsn;

    const DRIVER =  Dsn::MYSQL;
    const HOST   = 'example.org';
    const PORT   =  1234;
    const DBNAME = 'name-of-db';
    const USER   = 'user-of-db';
    const PASS   = 's-e-c-r-e-t';

    function setUp() {
        $this->dsn = new Dsn(array(
            'driver' => self::DRIVER,
              'host' => self::HOST,
              'port' => self::PORT,
            'dbname' => self::DBNAME,
              'user' => self::USER,
              'pass' => self::PASS
        ));
    }

    function tearDown() {
        $this->dsn = null;
    }

    function test___construct() {
        $this->assertTrue($this->dsn instanceof Dsn);

        Asserts::throws($this, function($test) {
            new Dsn(array());
        }, new DsnException());
    }

    function test___get() {
        $this->assertEquals(self::DRIVER, $this->dsn->driver);
        $this->assertEquals(self::HOST  , $this->dsn->host);
        $this->assertEquals(self::PORT  , $this->dsn->port);
        $this->assertEquals(self::DBNAME, $this->dsn->dbName);
        $this->assertEquals(self::USER, $this->dsn->user);
        $this->assertEquals(self::PASS, $this->dsn->pass);
    }

    function test___set() {
        $this->assertEquals(Dsn::PGSQL, $this->dsn->driver = Dsn::PGSQL);
        $this->assertEquals(Dsn::PGSQL, $this->dsn->driver);

        $this->assertEquals(100, $this->dsn->port = 100);
        $this->assertEquals(100, $this->dsn->port);
    }

    function test___toString() {
        $this->go_toString((string) $this->dsn);
    }

    function test_toString() {
        $this->dsn->pass = 'secret';
        $this->go_toString($this->dsn->toString());
    }

    function go_toString($dsnStr) {
        $this->assertEquals(0, strpos($dsnStr, self::DRIVER));
    }

    function test_toArray() {
        $dsnArr = $this->dsn->toArray();
        $this->assertInternalType('array', $dsnArr);

        $keys = array(
            'driver',
            'host',
            'dbname',
            'port',
            'user',
            'pass'
        );

        forEach ($keys as $key) {
            $this->assertArrayHasKey($key, $dsnArr);
            $const = constant(__CLASS__ . '::' . strtoupper($key));
            $this->assertEquals($const, $dsnArr[$key]);
        }
    }

    function testIssue_missing_driver_throws() {

        Asserts::throws($this, function () {
            new Dsn(array());
        });

        Asserts::throws($this, function () {
            new Dsn(array(
                'host' => 'h.h',
                'user' => 'test'
            ));
        });
    }

    function testIssue_driver_at_config() {
        $driver = 'db';
        $dsn = new Dsn(array(
            'driver' => $driver,
              'host' => 'example.org'
        ));

        $this->assertEquals($driver, $dsn->driver);
        $this->assertArrayHasKey('driver', $dsn->toArray());
        $this->assertEquals("$driver:host=example.org", $dsn->toString());
    }

    function testIssue_sqlite_dont_use_host() {

        $driver = Dsn::SQLITE;
        $path = '/path/to/db.sql';

        $dsn = new Dsn(array(
            'driver' => $driver,
              'host' => $path
        ));

        $this->assertEquals($driver, $dsn->driver);
        $this->assertEquals($path, $dsn->host);
        $this->assertStringStartsWith("$driver:$path", $dsn->toString());

        $this->assertEquals(Dsn::SQLITE, $dsn->driver);
        $this->assertEquals($path, $dsn->host);
    }

    function testIssue_pgsql_dont_use_pass() {
        $driver = Dsn::PGSQL;

        $dsn = new Dsn(array(
            'driver' => $driver,
              'host' => 'example.org',
              'user' => 'user',
              'pass' => 'pass'
        ));

        $this->assertEquals('pass', $dsn->pass);
        $this->assertEquals(Dsn::PGSQL . ':host=example.org', $dsn->toString());
    }
}
