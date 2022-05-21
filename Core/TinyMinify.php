<?php namespace Core;
defined('BASEPATH') or die('ACCESS DENIED');
use Core\Htmlminifier;

class TinyMinify {
    static function html($html, $options = []) {
        $minifier = new Htmlminifier($options);
        return $minifier->minify($html);
    }
}