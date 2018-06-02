# Current changes
- choose if you need label for element
  - null or false = whitout label
  - true = label with element's name
  - string = label with this string
- we can assign default value to inputs, if we don't use `->fill();`
  - `Form::text(name, lablel, default)`
  - `Form::textarea(name, lablel, default)`
- change behavior of radio and checkbox for the value
  - `Form::element(name, lablel, value)`
  - if `value` is null or not declared, the value will be element's name
- `checked` property of radio and checkbox *with data filling*
  - if `data` == `value`, will be checked
  - if `data` == `'true', 't', true, 1, '1'`, will be checked 
  - if `data` == `'false', 'f', false, 0, '0'`, will be not checked 
- `checked` property of radio and checkbox, *without data filling*
  - `Form::radio(name, lablel)->checked()`
  - `Form::checkbox(name, lablel)->checked()`
  - by default is not checked (`Form::checkbox(name, lablel)`)
- for radio and checkbox, 
  - the correct syntax isn't `... checked="checked">` but just `... checked>`
  - https://www.w3.org/wiki/HTML/Elements/input/checkbox

# Future changes
- add addon for inputs
- add buttons group