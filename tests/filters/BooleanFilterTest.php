<?php

namespace Pfilsx\DataGrid\tests\filters;

use Pfilsx\DataGrid\Grid\Filters\BooleanFilter;
use Pfilsx\tests\OrmTestCase;

/**
 * Class BooleanFilterTest
 * @package Pfilsx\DataGrid\tests\filters
 *
 * @property BooleanFilter $testFilter
 */
class BooleanFilterTest extends OrmTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->testFilter = new BooleanFilter($this->serviceContainer, [
            'trueChoice' => 'yes',
            'falseChoice' => 'no',
            'template' => $this->template
        ]);
    }

    public function testGetTrueChoice(): void
    {
        $this->assertEquals('yes', $this->testFilter->getTrueChoice());
    }

    public function testGetFalseChoice(): void
    {
        $this->assertEquals('no', $this->testFilter->getFalseChoice());
    }

    public function testRender(): void
    {
        $this->assertEquals('select>option>1:yes option>0:no', trim($this->testFilter->render('testAttribute', '1')));
    }
}
