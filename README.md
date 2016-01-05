# Monolog Extra Bundle

[![Build Status](https://travis-ci.org/jdecool/MonologExtraBundle.svg)](https://travis-ci.org/jdecool/MonologExtraBundle)

This Symfony2 bundles provides common additionnal Monolog processors for the framework.

## Installation

Install the latest version with

```bash
$ composer require jdecool/monolog-extra-bundle
```

## Configuration

Basic configuration :

```yaml
jdecool_monolog_extra:
    processor:
        security: true
        session:  true
```

Complete configuration :

```yaml
jdecool_monolog_extra:
    processor:
        security:
            enable: true
            env:    ~

        session:
            enable: true
            env:    dev
```
