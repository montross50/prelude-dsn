## Dsn, pain-less adapter for PDO configuration [![Build Status](https://travis-ci.org/eridal/prelude.png?branch=master)](https://travis-ci.org/eridal/prelude)

### Why?
PDO provides a nice API for accesing database in a standard way, but the connection part is still handled using strings; and those are vendor-specific.

Dsn provide a simple standard to handle such differences by providing a consistent API to read the configuration, and then giving you the connected PDO object. It simply stays out of your way while integrating nice with others.

### How to use it?

This project was merged into [Prelude\Database](https://github.com/eridal/prelude-database).
It will continue working but as deprecated. Please refactor whenever possible.
