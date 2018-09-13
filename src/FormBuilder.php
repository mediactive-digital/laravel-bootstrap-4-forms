<?php

namespace NetoJose\Bootstrap4Forms;

class FormBuilder {

    /**
     * Form input labels locale
     *
     * @var string
     */
    private $_Flocale;
    
    /**
     * Form inline form flag
     *
     * @var string
     */
    private $_FinlineForm;

    /**
     * Form method
     *
     * @var string
     */
    private $_Fmethod;

    /**
     * Multipart flag
     *
     * @var boolean
     */
    private $_Fmultipart;

    /**
     * Form array data
     *
     * @var array
     */
    private $_Fdata;

    /**
     * Inputs id prefix
     *
     * @var string
     */
    private $_FidPrefix;

    /**
     * Inputs generic class
     *
     * @var string
     */
    private $_Fclass;

    /**
     * Form elements arrays indexes
     *
     * @var array
     */
    private $_Findexes = [];

    /**
     * Form old data
     *
     * @var bool
     */
    private $_Fold = false;

    /**
     * Form errors
     *
     * @var mixed
     */
    private $_Ferrors = null;

    /**
     * Input meta data
     *
     * @var array
     */
    private $_meta;

    /**
     * Input attributes
     *
     * @var array
     */
    private $_attrs;

    /**
     * Form control type
     *
     * @var string
     */
    private $_type;

    /**
     * Form/Link
     *
     * @var string
     */
    private $_url;

    /**
     * Input placeholder
     *
     * @var string
     */
    private $_placeholder;

    /**
     * Flag to determine checkbox/radio style
     *
     * @var boolean
     */
    private $_checkInline;

    /**
     * Input size
     *
     * @var string
     */
    private $_size;

    /**
     * Readonly flag
     *
     * @var boolean
     */
    private $_readonly;

    /**
     * Disabled flag
     *
     * @var boolean
     */
    private $_disabled;

    /**
     * Required flag
     *
     * @var boolean
     */
    private $_required;

    /**
     * Checked flag
     *
     * @var boolean
     */
    private $_checked;

    /**
     * Input id
     *
     * @var string
     */
    private $_id;

    /**
     * Input class
     *
     * @var string
     */
    private $_class;

    /**
     * Input name
     *
     * @var string
     */
    private $_name;

    /**
     * Input label
     *
     * @var string
     */
    private $_label;

    /**
     * Select options
     *
     * @var array
     */
    private $_options;

    /**
     * Input help text
     *
     * @var string
     */
    private $_help;

    /**
     * Input color
     *
     * @var string
     */
    private $_color;

    /**
     * Input outline flag
     *
     * @var boolean
     */
    private $_outline;

    /**
     * Input block flag
     *
     * @var boolean
     */
    private $_block;

    /**
     * Input value
     *
     * @var boolean
     */
    private $_value;

    /**
     * Select multiple flag
     *
     * @var boolean
     */
    private $_multiple;

    /**
     * Element array name
     *
     * @var mixed
     */
    private $_arrayName;

    /**
     * Element array index
     *
     * @var int
     */
    private $_index;

    /**
     * Input sr-only
     *
     * @var bool
     */
    private $_srOnly;

    /**
     * Input prepend
     *
     * @var string
     */
    private $_prepend;

    public function __construct()
    {
        $this->_resetFlags();
        $this->_resetFormFlags();
    }

    /**
     * Set a class attribute
     *
     * @param string $attr
     * @param mixed $value
     */
    public function set(string $attr, $value)
    {
        $this->{'_' . $attr} = $value;
    }

    /**
     * Retrieve a class attribute
     *
     * @param string $attr
     * @return mixed
     */
    public function get(string $attr)
    {
        return $this->{'_' . $attr};
    }

    /**
     * Return a open form tag
     *
     * @return string
     */
    public function open(): string
    {
        $props = [
            'action' => $this->_url,
            'method' => $this->_Fmethod === 'get' ? 'get' : 'post'
        ];

        if($this->_Fmultipart){
            $props['enctype'] = 'multipart/form-data';
        }

        if($this->_FinlineForm) {
            $props['class'] = 'form-inline d-block d-sm-flex';
        }

        $attrs = $this->_buildAttrs($props, ['class-form-control']);

        $ret = '<form ' . $attrs . '>';

        if ($this->_Fmethod !== 'get') {
            $ret .= csrf_field();

            if ($this->_Fmethod !== 'post') {
                $ret .= method_field($this->_Fmethod);
            }
        }

        $this->_resetFlags();

        return $ret;
    }

    /**
     * Return a close form tag
     *
     * @return string
     */
    public function close(): string
    {
        $ret = '</form>';

        $this->_resetFormFlags();
        $this->_resetFlags();

        return $ret;
    }

    /**
     * Return a open fieldset tag
     *
     * @return string $ret
     */
    public function fieldsetOpen(): string {

        $attrs = $this->_buildAttrs(['class' => 'form-group' . (isset($this->_meta['wrap']) ? '' : ' mb-0')]);
        $ret = '<fieldset' . ($attrs ? (' ' . $attrs) : '') . '>' . ($this->_FinlineForm ? '<div class="form-group mb-0">' : '');
        $help = $this->_getHelpText($this->_FinlineForm ? ' mt-sm-0 ml-sm-2' : '');
        $error = $this->_getValidationFieldMessage($this->_FinlineForm ? ' w-auto mt-sm-0 ml-sm-2' : '');

        if (isset($this->_meta['legend'])) {

            $ret .= '<div class="form-group mb-2' . ($this->_FinlineForm ? ' my-sm-1 mx-sm-1' : '') . '"><legend class="mb-0 w-auto' . ($this->_FinlineForm ? ' d-sm-inline-block' : '') . '">' . $this->_e($this->_meta['legend']) . '</legend>' . $help . $error . '</div>';
        }
        else {

            $ret .= $help . $error;
        }

        $this->_resetFlags();

        return $ret;
    }

    /**
     * Return a close fieldset tag
     *
     * @return string $ret
     */
    public function fieldsetClose(): string {

        $ret = $this->_getHelpText($this->_FinlineForm ? ' mt-sm-0 mx-sm-1' : '') . $this->_getValidationFieldMessage($this->_FinlineForm ? ' w-auto mt-sm-0 mx-sm-1' : '') . ($this->_FinlineForm ? '</div>' : '') . '</fieldset>';

        $this->_resetFlags();

        return $ret;
    }

    /**
     * Return a file input tag
     *
     * @return string
     */
    public function file(): string {

        $attrs = $this->_buildAttrs(['class' => 'form-control-file']);

        return $this->_renderWrapperCommomField('<input ' . $attrs . '>');
    }

    /**
     * Return a text input tag
     *
     * @return string
     */
    public function text(): string
    {
        return $this->_renderInput();
    }

    /**
     * Return a plain text input tag
     *
     * @return string
     */
    public function plainText(): string {

        $attrs = $this->_buildAttrs(['value' => $this->_getValue(), 'type' => 'text', 'class' => 'form-control-plaintext', 'readonly' => true]);

        return $this->_renderWrapperCommomField('<input ' . $attrs . '>');
    }

    /**
     * Return a password input tag
     *
     * @return string
     */
    public function password(): string
    {
        return $this->_renderInput();
    }

    /**
     * Return a range input tag
     *
     * @return string
     */
    public function range(): string {

        $attrs = $this->_buildAttrs(['value' => $this->_getValue(), 'type' => 'range', 'class' => 'form-control-range']);

        return $this->_renderWrapperCommomField('<input ' . $attrs . '>');
    }


    /**
     * Return a email input tag
     *
     * @return string
     */
    public function email(): string
    {
        return $this->_renderInput();
    }

    /**
     * Return a number input tag
     *
     * @return string
     */
    public function number(): string
    {
        return $this->_renderInput();
    }

    /**
     * Return a hidden input tag
     *
     * @return string
     */
    public function hidden(): string
    {
        $value = $this->_getValue();
        $attrs = $this->_buildAttrs(['value' => $value], ['class-form-control']);

        $this->_resetFlags();

        return '<input ' . $attrs . '>';
    }

    /**
     * Return a textarea tag
     *
     * @return string
     */
    public function textarea(): string
    {
        $attrs = $this->_buildAttrs(['rows' => 3]);
        $value = $this->_getValue();

        return $this->_renderWrapperCommomField('<textarea ' . $attrs . '>' . $value . '</textarea>');
    }

    /**
     * Return a select tag
     *
     * @return string
     */
    public function select(): string
    {
        $attrs = $this->_buildAttrs();
        $value = $this->_getValue();
        $options = '';

        if ($this->_multiple) {
            if (!is_array($value)) {
                $value = [$value];
            }

            foreach ($this->_options as $key => $label) {

                if (in_array($key, $value)) {
                    $match = true;
                } else {
                    $match = false;
                }

                $checked = ($match) ? ' selected' : '';
                $options .= '<option value="' . $key . '"' . $checked . '>' . $label . '</option>';
            }
        } else {
            foreach ($this->_options as $optvalue => $label) {
                $checked = $optvalue == $value ? ' selected' : '';
                $options .= '<option value="' . $optvalue . '"' . $checked . '>' . $label . '</option>';
            }
        }

        return $this->_renderWrapperCommomField('<select ' . $attrs . '>' . $options . '</select>');
    }

    /**
     * Return a checkbox tag
     *
     * @return string
     */
    public function checkbox(): string
    {
        return $this->_renderCheckboxOrRadio();
    }

    /**
     * Return a radio tag
     *
     * @return string
     */
    public function radio(): string
    {
        return $this->_renderCheckboxOrRadio();
    }

    /**
     * Return a button tag
     *
     * @return string
     */
    public function button(): string
    {
        return $this->_renderButtonOrAnchor();
    }

    /**
     * Return a submit input tag
     *
     * @return string
     */
    public function submit(): string
    {
        return $this->_renderButtonOrAnchor();
    }

    /**
     * Return a reset button tag
     *
     * @return string
     */
    public function reset(): string
    {
        return $this->_renderButtonOrAnchor();
    }

    /**
     * Return a anchor tag
     *
     * @return string
     */
    public function anchor(): string
    {
        return $this->_renderButtonOrAnchor();
    }

    /**
     * Return a generic input tag
     *
     * @param string $type
     * @return string
     */
    private function _renderInput($type = 'text'): string
    {
        $value = $this->_getValue();
        $attrs = $this->_buildAttrs(['value' => $value, 'type' => $type]);

        return $this->_renderWrapperCommomField('<input ' . $attrs . '>');
    }

    /**
     * Return a button or anchor tag
     *
     * @return string
     */
    private function _renderButtonOrAnchor(): string
    {
        $size = $this->_size ? ' btn-' . $this->_size : '';
        $outline = $this->_outline ? 'outline-' : '';
        $block = $this->_block ? ' btn-block' : '';
        $inlineClass = $this->_FinlineForm ? ' my-sm-1 mx-sm-1' : '';
        $disabled = $this->_disabled ? ' disabled' : '';
        $value = $this->_e($this->_value);
        $cls = 'btn btn-' . $outline . $this->_color . $size . $block . $inlineClass;

        if ($this->_type == 'anchor') {
            $href = $this->_url ?: 'javascript:void(0)';
            $attrs = $this->_buildAttrs(
                    [
                        'class' => $cls . $disabled,
                        'href' => $href,
                        'role' => 'button',
                        'aria-disabled' => $disabled ? 'true' : null
                    ]
            );
            $ret = '<a ' . $attrs . '>' . $value . '</a>';
        } else {
            $attrs = $this->_buildAttrs(['class' => $cls, 'type' => $this->_type]);
            $ret = '<button ' . $attrs . ' ' . $disabled . '>' . $value . '</button>';
        }

        $this->_resetFlags();

        return $ret;
    }

    /**
     * Return a label tag
     *
     * @return string $result
     */
    private function _getLabel(): string
    {

        $label = $this->_label === true ? $this->_name : $this->_label;
        $result = '';

        if ($label) {

            $id = $this->_getId();
            $cls = '';

            if ($this->_srOnly) {

                $cls = 'sr-only';
            }

            $cls .= $this->_FinlineForm ? ' mr-sm-2' : '';
            $cls = $cls ? ' class="' . $cls . '"' : $cls;

            $result = '<label for="' . $id . '"' . $cls . '>' . $this->_e($label) . '</label>';
        }

        return $result;
    }

    /**
     * Return a string with HTML element attributes
     *
     * @param array $props
     * @return string
     */
    private function _buildAttrs(array $props = [], array $ignore = []): string {

        $ret = '';

        $props['type'] = $this->_type;
        $props['name'] = $this->_name;
        $props['autocomplete'] = $props['name'];
        $props['id'] = $this->_getId();
        $props['class'] = isset($props['class']) ? $props['class'] : '';

        if ($this->_type == 'select' && $this->_multiple) {
            $props['name'] = $props['name'] . '[]';
        }

        if ($this->_placeholder) {
            $props['placeholder'] = $this->_placeholder;
        }

        if ($this->_help) {
            $props['aria-describedby'] = $this->_getIdHelp();
        }

        if (!in_array('class-form-control', $ignore)) {

            if (!$props['class']) {

                $props['class'] = 'form-control';
            }

            if ($this->_size) {

                $props['class'] .= ' form-control-' . $this->_size;
            }
        }

        $cls = $this->_getClass();
        $props['class'] .= $cls ? ' ' . $cls : '';

        $validationFieldClass = $this->_getValidationFieldClass();
        $props['class'] .= $validationFieldClass ? ' ' . $validationFieldClass : '';

        if (isset($this->_attrs['class'])) {
            $props['class'] .= ' ' . $this->_attrs['class'];
        }

        $props['class'] = trim($props['class']);

        if(!$props['class']) {
            $props['class'] = null;
        }

        if ($this->_type == 'select' && $this->_multiple) {
            $ret .= 'multiple ';
        }

        if ($this->_readonly) {
            $ret .= 'readonly ';
        }

        if ($this->_disabled) {
            $ret .= 'disabled ';
        }

        if ($this->_required) {
            $ret .= 'required ';
        }

        if (in_array($this->_type, ['radio', 'checkbox'])) {

            if ($this->_checked) {

                $ret .= 'checked ';
            }
            else {

                $value = $this->_getValue();
                $ret .= ($this->_type == 'checkbox' && is_array($value) ? in_array($this->_meta['value'], $value) : $value == $this->_meta['value']) ? 'checked ' : '';
            }
        }

        if ($this->_type == 'hidden') {

            unset($props['autocomplete']);
        }

        $allProps = array_merge($this->_attrs, $props);
        foreach ($allProps as $key => $value) {
            if ($value === null) {
                continue;
            }
            $ret .= $key . '="' . htmlspecialchars($value) . '" ';
        }

        return trim($ret);
    }

    /**
     * Return a input value
     *
     * @return mixed $value
     */
    private function _getValue() {

        if ($this->_Fold) {

            $value = $this->_getOldValue();
        }
        elseif ($this->_value !== null) {

            $value = $this->_value;
        }
        else {

            $value = $this->_getFdataValue();
        }

        return $value;
    }

    /**
     * Return old value
     *
     * @return mixed $value
     */
    private function _getOldValue() {

        $hasIndex = $this->_index !== null;
        $name = $hasIndex ? $this->_arrayName : $this->_name;
        $old = isset($this->_Fold[$name]) ? $this->_Fold[$name] : null;

        return $hasIndex ? (isset($old[$this->_index]) ? $old[$this->_index] : null) : $old;
    }

    /**
     * Return true value for Fdata (models array flattening)
     *
     * @return mixed $value
     */
    private function _getFdataValue() {

        $value = null;
        $hasIndex = $this->_index !== null;
        $name = $hasIndex ? $this->_arrayName : $this->_name;

        if (isset($this->_Findexes[$name]['value'])) {

            $value = $this->_Findexes[$name]['value'];
        }
        elseif (isset($this->_Fdata[$name])) {

            $value = $this->_Fdata[$name];

            if (is_array($value)) {

                $currentValue = current($value);
                $value = is_array($currentValue) && array_key_exists('id', $currentValue) ? array_column($value, 'id') : $value;

                if ($hasIndex && $this->_type != 'checkbox') {

                    $value = isset($value[$this->_index]) ? $value[$this->_index] : null;
                }
            }

            if ($hasIndex) {

                $this->_Findexes[$name]['value'] = $value;
            }
        }

        return $value;
    }

    /**
     * Return an element id
     *
     * @return string
     */
    private function _getId()
    {
        $id = $this->_id;

        if (!$id && $this->_name) {
            $id = $this->_name;
            if ($this->_type == 'radio') {
                $id .= '-' . str_slug($this->_meta['value']);
            }
        }

        if(!$id) {
            return null;
        }

        return $this->_FidPrefix . $id;
    }

    /**
     * Return an element class
     *
     * @return string
     */
    private function _getClass() {

        $cls = $this->_Fclass . ($this->_class ? ' ' . $this->_class : '');

        return $cls ? $cls : null;
    }

    /**
     * Return a help text id HTML element
     *
     * @return string
     */
    private function _getIdHelp()
    {
        $id = $this->_getId();

        return $id ? 'help-' . $id : '';
    }

    /**
     * Return a help text
     *
     * @param string $class
     * @return string $help
     */
    private function _getHelpText(string $class = ''): string {

        $help = '';

        if ($this->_help) {

            $id = $this->_getIdHelp();
            $id = $id ? ' id="' . $id . '"' : '';

            $help = '<small' . $id . ' class="form-text text-muted' . $class . '">' . $this->_e($this->_help) . '</small>';
        }

        return $help;
    }

    /**
     * Return a text with translations, if available
     *
     * @param string $key
     *
     * @return string
     */
    private function _e($key): string
    {
        $fieldKey = $key ?: $this->_name;

        return $this->_Flocale ? __($this->_Flocale . '.' . $fieldKey) : $fieldKey;
    }

    /**
     * Return validation field class
     *
     * @return string
     */
    private function _getValidationFieldClass(): string {

        if (!$this->_name || !$this->_Ferrors) {

            return '';
        }

        if ($this->_getValidationFieldMessage()) {

            return 'is-invalid';
        }

        return 'is-valid';
    }

    /**
     * Return a checkbox or radio HTML element
     *
     * @return string
     */
    private function _renderCheckboxOrRadio(): string {

        $attrs  = $this->_buildAttrs(["class" => "form-check-input", "type" => $this->_type, "value" => $this->_meta['value']]);
        $inline = $this->_checkInline ? ' form-check-inline' : '';
        $inlineClass = $this->_FinlineForm ? ' my-sm-1 mx-sm-1' : '';
        $label  = $this->_e($this->_label);
        $id = $this->_getId();

        $this->_resetFlags();

        return '<div class="form-check' . $inline . $inlineClass . '"><input ' . $attrs . '><label class="form-check-label" for="' . $id . '">' . $label . '</label></div>';
    }

    /**
     * Return a input with a wrapper HTML markup
     *
     * @param type $field
     * @return string
     */
    private function _renderWrapperCommomField(string $field): string {

        $label = $this->_getLabel();
        $help = $this->_getHelpText($this->_FinlineForm ? ' mt-sm-0 ml-sm-2' : '');
        $error = $this->_getValidationFieldMessage($this->_FinlineForm ? ' w-auto mt-sm-0 ml-sm-2' : '');
        $formInputOpen = $formInputClose = $inlineClass = '';

        if ($this->_FinlineForm) {

            $inlineClass = ' my-sm-1 mx-sm-1';

            if ($this->_prepend || in_array($this->_type, ['file', 'range', 'plainText'])) {

                $formInputOpen = '<div class="input-group">';
                $formInputClose = '</div>';

                if ($this->_prepend) {

                    $formInputOpen .= '<div class="input-group-prepend"><div class="input-group-text">' . $this->_prepend . '</div></div>';
                }
            }
        }

        $this->_resetFlags();

        return '<div class="form-group' . $inlineClass . '">' . $label . $formInputOpen . $field . $formInputClose . $help . $error . '</div>';
    }

    /**
     * Return a validation error message
     *
     * @param string $class
     * @return string
     */
    private function _getValidationFieldMessage(string $class = ''): string {

        if (!$this->_name || !$this->_Ferrors) {

            return '';
        }

        $arrayName = $this->_index !== null ? $this->_arrayName : null;
        $error = $this->_type == 'checkbox' && $arrayName ? (isset($this->_Ferrors[$arrayName]) ? $this->_Ferrors[$arrayName] : null) : null;

        if (!$error) {

            $name = $arrayName ? $arrayName . '.' . $this->_index : $this->_name;
            $error = isset($this->_Ferrors[$name]) ? $this->_Ferrors[$name] : null;
        }

        if (!$error) {

            return '';
        }

        if (is_array($error)) {

            foreach ($error as $item) {

                $error = $item;

                break;
            }
        }

        return '<div class="invalid-feedback d-block' . ($class ? ' ' . $class : '') . '">' . $error . '</div>';
    }

    /**
     * Reset input flags
     */
    private function _resetFlags()
    {

        $this->_render = null;
        $this->_meta = [];
        $this->_attrs = [];
        $this->_type = null;
        $this->_url = null;
        $this->_placeholder = null;
        $this->_checkInline = false;
        $this->_size = null;
        $this->_readonly = false;
        $this->_disabled = false;
        $this->_required = false;
        $this->_checked = false;
        $this->_id = null;
        $this->_class = null;
        $this->_name = null;
        $this->_label = null;
        $this->_options = [];
        $this->_help = null;
        $this->_color = "primary";
        $this->_outline = false;
        $this->_block = false;
        $this->_value = null;
        $this->_multiple = false;
        $this->_arrayName = null;
        $this->_index = null;
        $this->_srOnly = false;
        $this->_prepend = null;
    }

    /**
     * Reset form flags
     */
    private function _resetFormFlags()
    {

        $this->_Flocale = null;
        $this->_Fmethod = 'post';
        $this->_Fmultipart = false;
        $this->_FinlineForm = false;
        $this->_Fdata = null;
        $this->_FidPrefix = '';
        $this->_Fclass = '';
        $this->_Findexes = [];
        $this->_Fold = false;
        $this->_Ferrors = null;
    }
}