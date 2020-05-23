<?php

namespace Manpro\Tests;

use Manpro\ManproError;
use Manpro\ManproException;
use Manpro\Tools\DataFormat;
use PHPUnit\Framework\TestCase;

class ManproErrorTest extends TestCase
{
    use ManproError;

    public function testGetNoExistError()
    {
        $this->expectException(ManproException::class);
        $this->getKeyError('1');
    }

    public function testBaseError()
    {
        $this->setError('s');
        $this->assertTrue($this->isError());
        $this->setError('error', 'info');
        $arr = $this->getErrors();
        $this->assertIsArray($arr);
        $this->assertArrayHasKey('info', $arr);
    }
}
