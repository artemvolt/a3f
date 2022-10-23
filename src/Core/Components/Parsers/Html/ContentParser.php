<?php

namespace A3F\Core\Components\Parsers\Html;

/**
 * class HtmlParser
 */
class ContentParser
{
    public function parse(string $content):TagsCollection {
        preg_match_all('/<(\w+)(\s.*)?>/', $content, $all);
        $collection = new TagsCollection();
        for ($i = 0, $iMax = count($all[0]) - 1; $i <= $iMax; $i++) {
            $collection->append(new Tag($all[1][$i]));
        }
        return $collection;
    }
}