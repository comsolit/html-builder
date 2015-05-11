<?php

namespace Comsolit\HTMLBuilder;

class HTMLBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function buildTag()
    {
    	$builder = new HTMLBuilder('div');

    	$actual = $builder->build();
    	$expected = '<div></div>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function buildTagWithStringContent()
    {
    	$builder = new HTMLBuilder('div', 'string content');

    	$actual = $builder->build();
    	$expected = '<div>string content</div>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function buildTagWithArrayContent()
    {
    	$builder = new HTMLBuilder('div', ['string', ' ', 'content']);

    	$actual = $builder->build();
    	$expected = '<div>string content</div>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function buildTagWithAttribute()
    {
    	$builder = new HTMLBuilder('div');
    	$builder->addAttribute('role', 'main');

    	$actual = $builder->build();
    	$expected = '<div role="main"></div>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function buildTagWithConditionalAttributeTrue()
    {
    	$builder = new HTMLBuilder('div');
    	$builder->addAttributeIf(true, 'role', 'main');

    	$actual = $builder->build();
    	$expected = '<div role="main"></div>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function buildTagWithConditionalAttributeFalse()
    {
    	$builder = new HTMLBuilder('div');
    	$builder->addAttributeIf(false, 'role', 'main');

    	$actual = $builder->build();
    	$expected = '<div></div>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function addNonExistingClass()
    {
    	$builder = new HTMLBuilder('div');
    	$builder->addClass('row');

    	$actual = $builder->build();
    	$expected = '<div class="row"></div>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function addExistingClass()
    {
    	$builder = new HTMLBuilder('div');
    	$builder->addClass('row')->addClass('row');

    	$actual = $builder->build();
    	$expected = '<div class="row"></div>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function addChild()
    {
    	$parent = new HTMLBuilder('div');
    	$child = new HTMLBuilder('p');

        $actual = $parent->addChild($child)->build();
    	$expected = '<div><p></p></div>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function buildSelfClosingTag()
    {
    	$builder = new HTMLBuilder('input');
    	$builder->setVoid();

    	$actual = $builder->build();
    	$expected = '<input/>';

    	$this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function encapsulateTag()
    {
    	$builder = new HTMLBuilder('p');

    	$actual = $builder->encapsulate('div')->build();
    	$expected = '<div><p></p></div>';

    	$this->assertEquals($expected, $actual);
    }
}