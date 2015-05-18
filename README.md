# HTMLBuilder

Lightweight utility class for building HTML in PHP.

## Example: Build a text input
### 1. Create an instance of HTMLBuilder with the tag name
```PHP
$builder = new HTMLBuilder('input');
```

### 2. Add attributes and classes
```PHP
$builder->setVoid();
        ->addAttribute('type', 'text')
        ->addAttribute('name', 'some_name')
        ->addAttributeIf(isset($elementId), 'id', $elementId)
        ->addClass('form-control');
```

### 3. Build the HTML
```PHP
$html = $builder->build();
```