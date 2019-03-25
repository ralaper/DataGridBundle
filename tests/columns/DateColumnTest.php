<?php


namespace Pfilsx\DataGrid\tests\columns;


use DateTime;
use Pfilsx\DataGrid\Grid\Columns\DateColumn;

/**
 * Class DateColumnTest
 * @package Pfilsx\DataGrid\tests
 *
 * @property DateColumn $testColumn
 */
class DateColumnTest extends ColumnCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->testColumn = new DateColumn($this->containerArray, [
            'attribute' => 'testAttribute',
            'dateFormat' => 'm-d-Y'
        ]);
    }

    public function testGetFormat(): void
    {
        $this->assertEquals('m-d-Y', $this->testColumn->getDateFormat());
    }

    public function testGetCellContent(): void
    {
        $entity = new class
        {
            public $date;

            public function getTestAttribute()
            {
                return $this->date;
            }
        };
        $entity->date = new DateTime('01-01-1970');
        $this->assertEquals('01-01-1970', $this->testColumn->getCellContent($entity));
        $entity->date = '01-01-1970';
        $this->assertEquals('01-01-1970', $this->testColumn->getCellContent($entity));
    }

    public function testGetCellContentNoFormat(): void
    {
        $column = new DateColumn($this->containerArray, [
            'value' => function () {
                return '01-01-1970';
            },
            'dateFormat' => null
        ]);
        $this->assertEquals('01-01-1970', $column->getCellContent(null));
    }
}
