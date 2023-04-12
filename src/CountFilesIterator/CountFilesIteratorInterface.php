<?php

namespace App\CountFilesIterator;

/**
 * @template-extends \IteratorAggregate<string, string> returns [filePath => value]
 */
interface CountFilesIteratorInterface extends \IteratorAggregate
{
}
