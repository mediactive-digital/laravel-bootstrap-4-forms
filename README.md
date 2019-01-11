# Bootstrap 4 forms for Laravel 5

This is a package for creating Bootstrap 4 styled form elements in Laravel 5.

## Features

-   Labels
-   Error messages
-   Bootstrap 4 markup and classes (including state, colors, and sizes)
-   Error validation messages
-   Form fill (using Model instance, array or after form submission when a validation error occurs)
-   Internationalization
-   Add parameters using php chaining approach
-   Zero dependences (no Laravel Collective dependency)

## Introduction

### Before

```html
<div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control @if($errors->has('username')) is-invalid @endif " id="username" value="{{old('username', $username)}}">
    @if($errors->has('username'))
    <div class="invalid-feedback">
        {{$errors->first('username')}}
    </div>
    @endif
</div>
```

### After

```php
Form::text('username', 'Username')
```

## Installation

#### Require the package using Composer.

```bash
composer require mediactive-digital/laravel-bootstrap-4-forms
```

### Laravel 5.5 or above

If you is using Laravel 5.5, the auto discovery feature will make everything for you and your job is done, you can start using now. Else, follow the steps below to install.

### Laravel 5.4

#### Add the service provider to your config/app.php file

```php
'providers' => [
    //...
	NetoJose\Bootstrap4Forms\Bootstrap4FormsServiceProvider::class,
],
```

#### Add the BootForm facade to the aliases array in config/app.php:

```php
'aliases' => [
    //...
    'Form' => NetoJose\Bootstrap4Forms\Bootstrap4FormsFacade::class,
],
```

## Usage

### Basic form controls

#### Opening and closing a form

```php
// Opening a form using POST method
{!!Form::open()!!}

// Opening a form using POST method with specific errors message bag
{!!Form::open('messageBag')!!}

// ... Form components here

// Closing a form
{!!Form::close()!!}
```

> Opening the form will add \_token field automatically for you

#### Inline form

```php
// Making all inputs inline
{!!Form::inlineForm()!!}
```

#### Fieldset

| Param   | Type   | Default | Description     |
| ------- | ------ | ------- | --------------- |
| $legend | string | null    | Fieldset Legend |
| $name   | string | null    | Fieldset Error  |
| $wrap   | bool   | false   | Fieldset Wrap   |

```php
// Examples

// Open fieldset
{!!Form::fieldsetOpen()!!}

// Open fieldset with legend
{!!Form::fieldsetOpen('Legend title')!!}

// Open fieldset with error display by field name
{!!Form::fieldsetOpen('Legend title', 'field_name')!!}

// Open fieldset as wrapper (checkbox/radio)
{!!Form::fieldsetOpen('Legend title', 'field_name', true)!!}

// Open fieldset with help text
{!!Form::fieldsetOpen('Legend title')->help('Help')!!}

// Open fieldset with error display by field name and help text
{!!Form::fieldsetOpen('Legend title', 'field_name')->help('Help')!!}

// ... Fieldset content

// Close fieldset
{!!Form::fieldsetClose()!!}

// Close fieldset with error display by field name
{!!Form::fieldsetClose('field_name')!!}

// Close fieldset with help text
{!!Form::fieldsetClose()->help('Help')!!}

// Close fieldset with error display by field name and help text
{!!Form::fieldsetClose('field_name')->help('Help')!!}
```

### Basic inputs

#### Text inputs

| Param    | Type   | Default | Description   |
| -------- | ------ | ------- | ------------- |
| $name    | string | null    | Input name    |
| $label   | string | null    | Input label   |
| $default | string | null    | Default value |

```php
// Example
{!!Form::text('name', 'User name')!!}
```

##### Textarea

| Param    | Type   | Default | Description   |
| -------- | ------ | ------- | ------------- |
| $name    | string | null    | Input name    |
| $label   | string | null    | Input label   |
| $default | string | null    | Default value |

```php
// Example
{!!Form::textarea('description', 'Description')!!}
```

##### Select

| Param    | Type   | Default | Description    |
| -------- | ------ | ------- | -------------- |
| $name    | string | null    | Input name     |
| $label   | string | null    | Input label    |
| $options | array  | []      | Select options |
| $default | string | null    | Default value  |

```php
// Example
{!!Form::select('city', 'Choose your city', [1 => 'Gotham City', 2 => 'Springfield'])!!}
```

##### Checkbox

| Param    | Type    | Default | Description   |
| -------- | ------- | ------- | ------------- |
| $name    | string  | null    | Input name    |
| $label   | string  | null    | Input label   |
| $value   | string  | null    | Input value   |
| $default | boolean | null    | Default value |

```php
// Example
{!!Form::checkbox('orange', 'Orange')!!}
```

##### Radio

| Param    | Type    | Default | Description   |
| -------- | ------- | ------- | ------------- |
| $name    | string  | null    | Input name    |
| $label   | string  | null    | Input label   |
| $value   | string  | null    | Input value   |
| $default | boolean | null    | Default value |

```php
// Example
{!!Form::radio('orange', 'Orange')!!}
```

#### Range inputs

| Param    | Type   | Default | Description   |
| -------- | ------ | ------- | ------------- |
| $name    | string | null    | Input name    |
| $label   | string | null    | Input label   |
| $default | string | null    | Default value |

```php
// Example
{!!Form::range('name', 'User name')!!}
```

#### Plain text inputs

| Param    | Type   | Default | Description   |
| -------- | ------ | ------- | ------------- |
| $name    | string | null    | Input name    |
| $label   | string | null    | Input label   |
| $default | string | null    | Default value |

```php
// Example
{!!Form::plainText('name', 'User name')!!}
```

##### Hidden

| Param    | Type    | Default | Description   |
| -------- | ------- | ------- | ------------- |
| $name    | string  | null    | Input name    |
| $default | boolean | null    | Default value |

```php
// Example
{!!Form::hidden('user_id')!!}
```

##### Anchor

| Param  | Type   | Default | Description |
| ------ | ------ | ------- | ----------- |
| $value | string | null    | Anchor text |
| $url   | string | null    | Anchor url  |

```php
// Example
{!!Form::anchor("Link via parameter", 'foo/bar')!!}
```

##### Buttons

| Param  | Type   | Default | Description  |
| ------ | ------ | ------- | ------------ |
| $value | string | null    | Button value |
| $color | string | null    | Button color |
| $size  | string | null    | button size  |

###### Submit

```php
// Example
{!!Form::submit("Send form")!!}
```

###### Button

```php
// Example
{!!Form::button("Do something", "warning", "lg")!!}
```

###### Reset

```php
// Example
{!!Form::reset("Clear form")!!}
```

### Chainable methods

> This package uses [chaining](https://en.wikipedia.org/wiki/Method_chaining) feature, allowing easly pass more parameters.

### Filling a form

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $data | object | array   | null        | DAta fo fill form inputs |

```php
// Examples

// With initial data using a Model instance
$user = User::find(1);
{!!Form::open()->fill($user)!!}

// With initial array data
$user = ['name' => 'Jesus', 'age' => 33];
{!!Form::open()->fill($user)!!}
```

### Url

Use in anchors and forms openings

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $url  | string | null    | Url         |

```php
// Example
{!!Form::anchor("Link via url")->url('foo/bar')!!}
```

### Route

Use in anchors and forms openings

| Param  | Type   | Default | Description |
| ------ | ------ | ------- | ----------- |
| $route | string | null    | Route name  |

```php
// Example
{!!Form::anchor("Link via route")->route('home')!!}
```

### Checked

Set the checkbox/radio checked status

| Param    | Type    | Default | Description    |
| -------- | ------- | ------- | -------------- |
| $checked | boolean | true    | Checked status |

```php
// Examples

// Make checkbox checked
{!!Form::checkbox('agree', 'I agree')->checked()!!}

// You can use FALSE to turn off checked status
{!!Form::checkbox('agree', 'I agree')->checked(false)!!}
```

### Inline

Set the checkbox/radio inline

```php
// Examples
{!!Form::radio('orange', 'Orange')->inline()!!}

{!!Form::checkbox('orange', 'Orange')->inline()!!}
```

### Placeholder

| Param        | Type   | Default | Description      |
| ------------ | ------ | ------- | ---------------- |
| $placeholder | string | null    | Placeholder text |

```php
// Example
{!!Form::text('name', 'Name')->placeholder('Input placeholder')!!}
```

### Autocomplete

| Param         | Type    | Default | Description         |
| ------------- | ------- | ------- | ------------------- |
| $autocomplete | boolean | true    | Autocomplete status |

```php
// Examples

// Set autocomplete on input
{!!Form::text('name', 'Name')->autocomplete()!!}

// You can use FALSE to turn off autocomplete status
{!!Form::text('name', 'Name')->autocomplete(false)!!}
```

### SrOnly

Set the label sr-only status

| Param    | Type    | Default | Description    |
| -------- | ------- | ------- | -------------- |
| $srOnly  | boolean | true    | SrOnly status  |

```php
// Examples

// Set sr-only style on label
{!!Form::text('name', 'Name')->srOnly()!!}

// You can use FALSE to turn off sr-only status
{!!Form::text('name', 'Name')->srOnly(false)!!}
```

### Prepend

Prepend content to input

| Param    | Type    | Default | Description    |
| -------- | ------- | ------- | -------------- |
| $prepend | string  | null    | Input prepend  |

```php
// Example
{!!Form::text('name', 'Name')->prepend('Input prepend')!!}
```

### Select Multiple

```php
// Example
{!!Form::select('city', 'Choose your city', [1 => 'Gotham City', 2 => 'Springfield'])->multiple()!!}
```

### Locale

Using locale, the package will look for a resources/lang/{CURRENT_LANG}/forms/user.php language file and uses labels and help texts as keys for replace texts

```php
// Example
{!!Form::open()->locale('forms.user')!!}
```

### Help Text

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $text | string | null    | Help text   |

```php
// Example
{!!Form::text('name', 'Name')->help('Help text here')!!}
```

### Custom attributes

| Param  | Type  | Default | Description             |
| ------ | ----- | ------- | ----------------------- |
| $attrs | array | []      | Custom input attributes |

```php
// Example
{!!Form::text('name', 'Name')->attrs(['data-foo' => 'bar', 'rel'=> 'baz'])!!}
```

### Readonly

| Param   | Type    | Default | Description      |
| ------- | ------- | ------- | ---------------- |
| $status | boolean | true    | Read only status |

```php
// Examples

// Using readonly field
{!!Form::text('name', 'Name')->readonly()!!}

// You can use FALSE to turn off readonly status
{!!Form::text('name', 'Name')->readonly(false)!!}
```

### Disabled

| Param   | Type    | Default | Description     |
| ------- | ------- | ------- | --------------- |
| $status | boolean | true    | Disabled status |

```php
// Examples

// Disabling a field
{!!Form::text('name', 'Name')->disabled()!!}

// Disabling a fieldset
{!!Form::fieldsetOpen('User data')->disabled()!!}

// You can use FALSE to turn off disabled status
{!!Form::text('name', 'Name')->disabled(false)!!}
```

### Required

| Param   | Type    | Default | Description     |
| ------- | ------- | ------- | --------------- |
| $status | boolean | true    | Required status |

```php
// Examples

// Make a field required
{!!Form::text('name', 'Name')->required()!!}

 // Make a fieldset required
{!!Form::fieldsetOpen('User data')->required()!!}

 // You can use FALSE to turn off required status
{!!Form::text('name', 'Name')->required(false)!!}
```

### Block

| Param   | Type    | Default | Description     |
| ------- | ------- | ------- | --------------- |
| $status | boolean | true    | Disabled status |

```php
// Examples

// Set block style on a field
{!!Form::text('name', 'Name')->block()!!}

// You can use FALSE to turn off block status
{!!Form::text('name', 'Name')->block(false)!!}
```

### Simple

| Param   | Type    | Default | Description   |
| ------- | ------- | ------- | ------------- |
| $simple | boolean | true    | Simple status |

```php
// Examples

// Set simple status for a button
{!!Form::button('Button')->simple()!!}

// Set simple status for an anchor
{!!Form::anchor('Anchor')->simple()!!}

// You can use FALSE to turn off simple status
{!!Form::button('Button')->simple(false)!!}
```

### Id

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $id   | string | null    | Field id    |

```php
// Example
{!!Form::text('name', 'Name')->id('user-name')!!}
```

### Class

| Param   | Type   | Default | Description |
| ------- | ------ | ------- | ----------- |
| $class  | string | null    | Field class |

```php
// Example
{!!Form::text('name', 'Name')->class('class')!!}
```

### Wrapper class

| Param   | Type   | Default | Description   |
| ------- | ------ | ------- | ------------- |
| $class  | string | null    | Wrapper class |

```php
// Example
{!!Form::text('name', 'Name')->wrapperClass('class')!!}
```

### Label class

| Param   | Type   | Default | Description |
| ------- | ------ | ------- | ----------- |
| $class  | string | null    | Label class |

```php
// Example
{!!Form::text('name', 'Name')->labelClass('class')!!}
```

### Id prefix

| Param   | Type   | Default | Description |
| ------- | ------ | ------- | ----------- |
| $prefix | string | null    | Id prefix   |

```php
// Example
{!!Form::open()->idPrefix('register')!!}
```

### General class

| Param   | Type   | Default | Description    |
| ------- | ------ | ------- | -------------- |
| $class  | string | null    | General class  |

```php
// Example
{!!Form::open()->generalClass('class')!!}
```

### Multipart

| Param      | Type    | Default | Description    |
| ---------- | ------- | ------- | -------------- |
| $multipart | boolean | true    | Multipart flag |

```php
// Examples
{!!Form::open()->multipart()!!}

// You can use FALSE to turn off multipart
{!!Form::open()->multipart(false)!!}
```

### Method

| Param   | Type   | Default | Description |
| ------- | ------ | ------- | ----------- |
| $method | string | null    | HTTP method |

```php
// Examples
{!!Form::open()->method('get')!!}
{!!Form::open()->method('post')!!}
{!!Form::open()->method('put')!!}
{!!Form::open()->method('patch')!!}
{!!Form::open()->method('delete')!!}
```

### explicit HTTP verbs

```php
// Examples
{!!Form::open()->get()!!}
{!!Form::open()->post()!!}
{!!Form::open()->put()!!}
{!!Form::open()->patch()!!}
{!!Form::open()->delete()!!}
```

### Color

| Param  | Type   | Default | Description |
| ------ | ------ | ------- | ----------- |
| $color | string | null    | Color name  |

```php
// Examples
{!!Form::button("Do something")->color("warning")!!}

{!!Form::button("Do something")->color("primary")!!}
```

### explicit color

```php
// Examples
{!!Form::button("Button label")->warning()!!}
{!!Form::button("Button label")->outline()!!}
{!!Form::button("Button label")->success()!!
{!!Form::button("Button label")->danger()!!}
{!!Form::button("Button label")->secondary()!!}
{!!Form::button("Button label")->info()!!}
{!!Form::button("Button label")->light()!!}
{!!Form::button("Button label")->dark()!!}
{!!Form::button("Button label")->link()!!}
```

### Size

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $size | string | null    | Size name   |

```php
// Examples
{!!Form::button("Do something")->size("sm")!!}

{!!Form::button("Do something")->size("lg")!!}
```

### Explicit size

```php
// Examples
{!!Form::button("Button label")->sm()!!}
{!!Form::button("Button label")->lg()!!}
```

### Type

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $type | string | null    | Type field  |

```php
// Examples

// Password field
{!!Form::text('password', 'Your password')->type('password')!!}

// Number field
{!!Form::text('age', 'Your age')->type('number')!!}

// Email field
{!!Form::text('email', 'Your email')->type('email')!!}
```

### Name

| Param | Type   | Default | Description |
| ----- | ------ | ------- | ----------- |
| $name | string | null    | Input name  |

```php
// Examples
{!!Form::text('text')->name('name')!!}
```

### Label

| Param  | Type   | Default | Description |
| ------ | ------ | ------- | ----------- |
| $label | string | null    | Input label |

```php
// Examples
{!!Form::text('age')->label('Your age')!!}
```

### Default Value

| Param  | Type  | Default | Description |
| ------ | ----- | ------- | ----------- |
| $value | mixed | null    | Input value |

```php
// Example
{!!Form::text('name', 'Your name')->value('Maria')!!}
```

### Render

| Param   | Type   | Default | Description |
| ------- | ------ | ------- | ----------- |
| $render | string | null    | Render name |

```php
// Examples

// Number field
{!!Form::render('text')->name('age')->label('Your age')!!}
```

### Chaining properties

You can use chaining feature to use a lot of settings for each component

```php
// Examples

{!!Form::open()->locale('forms.user')->put()->multipart()->route('user.add')->data($user)!!}

{!!Form::text('name', 'Name')->placeholder('Type your name')->lg()!!}

{!!Form::anchor("Link as a button")->sm()->info()->outline()!!}

{!!Form::submit('Awesome button')->id('my-btn')->disabled()->danger()->lg()!!}

{!!Form::close()!!}
```
