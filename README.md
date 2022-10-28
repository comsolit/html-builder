**THIS REPO IS UNMAINTAINED / A NEW MAINTAINER IS NEEDED**
=================

# HTMLBuilder

Lightweight utility class for building small snippets of HTML in PHP.

## Examples

All examples expect a ```use Comsolit\HTMLBuilder;``` statement.

### Link tag with inner Text

```PHP
$builder = new HTMLBuilder('a', 'comsolit AG');
$builder->addAttribute('href', 'https://www.comsolit.com');

$this->assertEquals(
    '<a href="https://www.comsolit.com">comsolit AG</a>',
    $builder->build()
);
```

### Input tag without closing tag
```PHP
$builder = new HTMLBuilder('input');
$builder
    ->setVoid() // don't build a closing tag
    ->addAttribute('type', 'text')
    ->addAttribute('name', 'some_name');

$this->assertEquals(
    '<input type="text" name="some_name"/>',
    $builder->build()
);
```

### Tag with inner text
```PHP
$builder = new HTMLBuilder('span', 'my text');

$this->assertEquals(
    '<span>my text</span>',
    $builder->build()
);
```

### Using the magic __toString() method
```PHP
$builder = new HTMLBuilder('span');

$this->assertEquals(
    $builder->build(),
    (string)$builder
);
```

### Wrap tags
```PHP
$inputBuilder = (new HTMLBuilder('input'))->setVoid();
$labelBuilder = new HTMLBuilder('label', $inputBuilder);

$this->assertEquals(
    '<label><input/></label>',
    (string)$labelBuilder
);
```

### Encapsulate tags
```PHP
$inputBuilder = (new HTMLBuilder('input'))->setVoid();
$labelBuilder = $inputBuilder->encapsulate('label');

$this->assertEquals(
    '<label><input/></label>',
    (string)$labelBuilder
);
```

### Set attribute conditionally
```PHP
$builder = (new HTMLBuilder('input'))
    ->setVoid()
    ->addAttribute('type', 'checkbox')
    ->addAttributeIf(1 + 1 === 3, 'disabled', 'disabled')
    ->addAttributeIf(1 + 1 === 2, 'checked', 'checked');

$this->assertEquals(
    '<input type="checkbox" checked="checked"/>',
    (string)$builder
);
```

### Special method for classes
```PHP
$builder = (new HTMLBuilder('span'))
    ->addClass('once')
    ->addClass('multiple')
    ->addClass('multiple');

$this->assertEquals(
    '<span class="once multiple"></span>',
    (string)$builder
);
```

### Add multiple children
```PHP
$builder = new HTMLBuilder('ul');

for ($i = 0; $i < 2; ++$i) {
  $builder->addChild(new HTMLBuilder('li', (string)$i));
}

$this->assertEquals(
    '<ul><li>0</li><li>1</li></ul>',
    (string)$builder
);
```

## Related Packages

We've used this builder already in three projects and than evaluated other packages to decide
whether we want to publish this builder or not:

* [QueryPath](http://querypath.org/)
* [FluentDOM](https://github.com/FluentDOM/FluentDOM)
* [php-html-generation-class](http://snipplr.com/view/35538/php--html-generation-class/) - last commit 2012, 9 commits total, not on packagist
* [php-class-html-generator](https://code.google.com/p/php-class-html-generator) - just a snippet, no package
* [phpquery](https://code.google.com/p/phpquery) - last commit 2011
* [ratrijs/html-builder](https://packagist.org/packages/ratrijs/html-builder)
* [howlowck/html-builder](https://packagist.org/packages/howlowck/html-builder)
* [jleagle/html-builder](https://packagist.org/packages/jleagle/html-builder)
