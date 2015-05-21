<?php

namespace Comsolit\HTMLBuilder;

class ReadmeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider parseReadme
     */
    public function testReadme($example)
    {
        $code = str_replace('HTMLBuilder', '\Comsolit\HTMLBuilder\HTMLBuilder', $example);

        eval($code);
    }

    public function parseReadme()
    {
        $readme = file_get_contents(__DIR__ . '/../README.md');

        $matches = [];
        preg_match_all('/(?:```PHP([^`]*)```)/ism', $readme, $matches);

        return array_map(
            function($x) {return [$x];},
            $matches[1]
        );
    }
}