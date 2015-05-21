<?php

namespace Comsolit\HTMLBuilder;

class HTMLBuilder
{
    private $attributes = [];
    private $children = [];
    private $tag;
    private $void = false;

    public function __construct($tag, $content = [])
    {
        if (!is_array($content)) {
            $content = [$content];
        }

        foreach ($content as $element) {
            if (is_string($element)) {
                $element = new TextTag($element);
            }
            $this->addChild($element);
        }

        if (!is_string($tag)) {
            throw new \Exception('$tag must be string, got: '.print_r($tag, true));
        }
        $this->tag = $tag;
    }

    /**
     * Add attribute to tag.
     * @param string $name The attribute name.
     * @param string $value The attribute value.
     * @return \Comsolit\HTMLBuilder\HTMLBuilder
     */
    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * Add class to tag.
     * @param string $name Class name.
     * @return \Comsolit\HTMLBuilder\HTMLBuilder
     */
    public function addClass($name)
    {
    	$classes = array_key_exists('class', $this->attributes)
    		? array_flip(explode(' ', $this->attributes['class']))
    		: [];

    	$classes[$name] = null;

    	$this->attributes['class'] = implode(' ', array_keys($classes));

    	return $this;
    }

    /**
     * Add attribute only if $condition is true.
     * @param boolean $condition Condition to evaluate.
     * @param string $name The attribute name.
     * @param string $name The attribute value.
     * @return \Comsolit\HTMLBuilder\HTMLBuilder
     */
    public function addAttributeIf($condition, $name, $value)
    {
        if ($condition) {
            $this->addAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Add child.
     * @param HTMLBuilder $child Encapsulated tag.
     * @throws \Exception
     * @return \Comsolit\HTMLBuilder\HTMLBuilder
     */
    public function addChild(HTMLBuilder $child)
    {
        if ($this->void) {
            throw new \Exception('tag coundn\'t be void and have content at the same time');
        }
        $this->children[] = $child;

        return $this;
    }

    /**
     * @param $void boolean Whether this element is rendered without content, immediately closing,
     *                      e.g. <link/> instead of <link></link>
     * @return \Comsolit\HTMLBuilder\HTMLBuilder
     */
    public function setVoid($void = true)
    {
        if (!empty($this->children)) {
            throw new \Exception('tag coundn\'t be void and have content at the same time');
        }
        $this->void = $void;

        return $this;
    }

    /**
     * Builds the html string.
     * @return string
     */
    public function build()
    {
        $html = '<' . $this->tag;
        foreach ($this->attributes as $key => $value) {
            $html .= ' ' . $key . '="' . $value . '"';
        }

        $html .=  $this->void
            ? '/>'
            : '>' . $this->renderContent() . '</' . $this->tag . '>';

        return $html;
    }

    public function __toString()
    {
        return $this->build();
    }

    private function renderContent()
    {
        return array_reduce($this->children, function ($acc, $child) {
            return $acc .= $child->build();
        }, '');
    }

    /**
     * Encapsulates the tag in another tag. Returns a new tag.
     * @param string $tag Tag name.
     * @return \Comsolit\HTMLBuilder\HTMLBuilder
     */
    public function encapsulate($tag)
    {
        return new self($tag, $this);
    }
}
