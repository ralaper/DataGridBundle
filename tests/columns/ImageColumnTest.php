<?php


namespace Pfilsx\DataGrid\tests\columns;


use Pfilsx\DataGrid\Grid\Columns\ImageColumn;
use Pfilsx\DataGrid\Grid\Items\EntityGridItem;
use Pfilsx\tests\OrmTestCase;

/**
 * Class ImageColumnTest
 * @package Pfilsx\DataGrid\tests\columns
 *
 * @property ImageColumn $testColumn
 */
class ImageColumnTest extends OrmTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->testColumn = new ImageColumn($this->serviceContainer, [
            'attribute' => 'testAttribute',
            'width' => 20,
            'height' => 20,
            'alt' => function () {
                return 'Test alt';
            },
            'emptyValue' => 'Empty',
            'template' => $this->template
        ]);
    }

    public function testGetWidth(): void
    {
        $this->assertEquals(20, $this->testColumn->getWidth());
    }

    public function testGetHeight(): void
    {
        $this->assertEquals(20, $this->testColumn->getHeight());
    }

    public function testGetAlt(): void
    {
        $this->assertEquals('Test alt', $this->testColumn->getAlt(null));
    }

    public function testGetNoImageMessage(): void
    {
        $entity = new class
        {
            public function getTestAttribute()
            {
                return null;
            }
        };
        $item = new EntityGridItem($entity);
        $this->assertEquals('Empty', $this->testColumn->getCellContent($item));
    }

    public function testGetCellContent(): void
    {
        $entity = new class
        {
            public function getTestAttribute()
            {
                return '/path/to/image.jpg';
            }
        };
        $item = new EntityGridItem($entity);
        $this->assertEquals('<img src="/path/to/image.jpg" height="20" width="20" alt="Test alt"/>', trim($this->testColumn->getCellContent($item)));

        $column = new ImageColumn($this->serviceContainer, [
            'format' => 'raw',
            'attribute' => 'testAttribute',
            'template' => $this->template
        ]);
        $this->assertEquals('/path/to/image.jpg', $column->getCellContent($item));
    }
}
