--TEST--
Test mb_strrpos() function : mb_strrpos offset is byte count for negative values
--SKIPIF--
<?php
extension_loaded('mbstring') or die('skip');
function_exists('mb_strrpos') or die("skip mb_strrpos() is not available in this build");
?>
--FILE--
<?php
/* Prototype  : int mb_strrpos(string $haystack, string $needle [, int $offset [, string $encoding]])
 * Description: Find position of last occurrence of a string within another
 * Source code: ext/mbstring/mbstring.c
 */

/*
 * Test that mb_strrpos offset is byte count for negative values (should be character count)
 */

$offsets = array(-25, -24, -13, -12);
// Japanese string in UTF-8
$string_mb = "日本語テキストです。01234５６７８９。";
$needle = "。";

foreach ($offsets as $i) {
    echo "\n-- Offset is $i --\n";
    echo "Multibyte String:\n";
    try {
        var_dump( mb_strrpos($string_mb, $needle, $i, 'UTF-8') );
    } catch (\ValueError $e) {
        echo $e->getMessage() . \PHP_EOL;
    }
    echo "ASCII String:\n";
    echo "mb_strrpos:\n";
    try {
        var_dump(mb_strrpos('This is na English ta', 'a', $i));
    } catch (\ValueError $e) {
        echo $e->getMessage() . \PHP_EOL;
    }
    echo "strrpos:\n";
    try {
        var_dump(strrpos('This is na English ta', 'a', $i));
    } catch (\ValueError $e) {
        echo $e->getMessage() . \PHP_EOL;
    }
}
?>
--EXPECT--
-- Offset is -25 --
Multibyte String:
Offset not contained in string
ASCII String:
mb_strrpos:
Offset not contained in string
strrpos:
Offset not contained in string

-- Offset is -24 --
Multibyte String:
Offset not contained in string
ASCII String:
mb_strrpos:
Offset not contained in string
strrpos:
Offset not contained in string

-- Offset is -13 --
Multibyte String:
bool(false)
ASCII String:
mb_strrpos:
bool(false)
strrpos:
bool(false)

-- Offset is -12 --
Multibyte String:
int(9)
ASCII String:
mb_strrpos:
int(9)
strrpos:
int(9)
