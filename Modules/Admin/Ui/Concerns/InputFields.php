<?php

namespace Modules\Admin\Ui\Concerns;

use LogicException;
use Modules\Support\Money;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Relations\Relation;

trait InputFields
{
    protected function inputField($name, $value, $class, $attributes)
    {
        return "<input name='{$name}' class='form-control {$class}' id='{$name}' {$attributes} value='{$value}'>";
    }

    protected function textareaField($name, $value, $class, $attributes)
    {
        $attributes =  str_replace("required='1'","",$attributes);   //bug fix sementara
        return "<textarea name='{$name}' class='form-control {$class}' id='{$name}' {$attributes}>{$value}</textarea>";
    }

    protected function checkboxField($name, $value, $class, $attributes, $options, $label)
    {
        $checked = array_pull($options, 'checked', false);
        $disabled = array_get($options, 'disabled', false);

        if (! is_null($value)) {
            $checked = $value;
        }

        $html = '<div class="checkbox">';

        if (! $disabled) {
            $html .= "<input type='hidden' value='0' name='{$name}'>";
        }

        $html .= "<input
                    type='checkbox'
                    name='{$name}'
                    class='{$class}'
                    id='{$name}'
                    {$attributes}
                    value='1'"
                    . ($checked ? 'checked ' : '')
                    . ($disabled ? 'disabled' : '') .
                '>';

        $html .= "<label for='{$name}'>{$label}</label>";
        $html .= '</div>';

        return $html;
    }

    protected function selectField($name, $value, $class, $attributes, $options, $list, $textIfNotselected = '')
    {
        $multiple = array_get($options, 'multiple', false);

        $html = "<select name='{$name}' class='form-control custom-select-black {$class}' {$attributes} id='{$name}'>";
        if($textIfNotselected){
            $html .= "<option value=''> $textIfNotselected </option>";
        }
        foreach ($list as $listValue => $listName) {
            $listValue = e($listValue);
            $listName = e($listName);

            if ($multiple && $value instanceof Collection) {
                $selected = $value->where('id', $listValue)->isNotEmpty() ? 'selected' : '';
            } elseif ($multiple && is_array($value)) {
                $selected = in_array($listValue, $value) ? 'selected' : '';
            } else {
                $selected = (! is_null($value) && $value == $listValue) ? 'selected' : '';
            }

            $html .= "<option value='{$listValue}' {$selected}>{$listName}</option>";
        }

        $html .= '</select>';

        return $html;
    }


    protected function field($name, $title, $errors, $entity, $options = [], callable $fieldCallback, ...$args)
    {
        $value = $this->getValue($entity, $name);

        if (is_string($value)) {
            $value = e($value);
        }

        $normalizedName = $this->normalizeTranslatableFieldName($name);
        $name = array_get($options, 'multiple', false) ? "{$name}[]" : $name;
        $required = array_pull($options, 'required', false);
        $help = array_pull($options, 'help', false);

        $params = array_merge([
            $name,
            $value,
            array_pull($options, 'class'),
            $this->generateHtmlAttributes($options),
            $options,
        ], $args);

        $labelCol = array_pull($options, 'labelCol', 3);
        $fieldCol = 12 - $labelCol;

        $html = '<div class="form-group ' . ($errors->has($normalizedName) ? 'has-error' : '') . '">';

        $html .= $this->label($name, $title, $labelCol, $required);

        $html .= "<div class='col-md-{$fieldCol}'>";
        $html .= call_user_func_array($fieldCallback, $params);

        if ($help && ! $errors->has($normalizedName)) {
            $html .= "<span class='help-block'>{$help}</span>";
        }

        $html .= $errors->first($normalizedName, '<span class="help-block">:message</span>');

        $html .= '</div>';
        $html .= '</div>';

        return new HtmlString($html);
    }



    protected function fieldVertical($name, $title, $errors, $entity, $options = [], callable $fieldCallback, ...$args)
    {
        $value = $this->getValue($entity, $name);
        $format_intruction = array_pull($options, 'format_intruction', false);

        if (is_string($value)) {
            $value = e($value);
        }

        if(!empty($format_intruction)){
             $value = $format_intruction;
        }

        $normalizedName = $this->normalizeTranslatableFieldName($name);
        $name = array_get($options, 'multiple', false) ? "{$name}[]" : $name;
        $required = array_keys($options, 'required', false);
        $help = array_pull($options, 'help', false);

        $params = array_merge([
            $name,
            $value,
            array_pull($options, 'class'),
            $this->generateHtmlAttributes($options),
            $options,
        ], $args);

        $labelCol = array_pull($options, 'labelCol', 3);
        $fieldCol = 12 - $labelCol;

        $html = '<div class="form-group ' . ($errors->has($normalizedName) ? 'has-error' : '') . '">';

        $html .= $this->labelVertical($name, $title, $required);

        $html .= call_user_func_array($fieldCallback, $params);

        if ($help && ! $errors->has($normalizedName)) {
            $html .= "<span class='help-block'>{$help}</span>";
        }

        $html .= $errors->first($normalizedName, '<span class="help-block">:message</span>');

        $html .= '</div>';

        return new HtmlString($html);
    }

    private function normalizeTranslatableFieldName($name)
    {
        if (starts_with($name, 'translatable[')) {
            return 'translatable.' . str_between($name, 'translatable[', ']');
        }

        return $name;
    }

    protected function label($name, $title, $labelCol = 3, $required = false)
    {
        $html = "<label for='{$name}' class='col-md-{$labelCol} control-label text-left'>{$title}";

        if ($required) {
            $html .= '<span class="m-l-5 text-red">*</span>';
        }

        return $html .= '</label>';
    }

    protected function labelVertical($name, $title, $required = false)
    {
        $html = "<label for='{$name}'  control-label text-left'>{$title}";

        if ($required) {
            $html .= '<span class="m-l-5 text-red">*</span>';
        }

        return $html .= '</label>';
    }


    private function getValue($entity, $name)
    {
        if (method_exists($entity, 'translate') && $entity->isTranslationAttribute($name)) {
            $translatedValue = optional($entity->translate(locale(), false))->$name;

            return old($name, $translatedValue);
        }

        $camelCaseName = camel_case($name);

        if (method_exists($entity, $camelCaseName) && $entity->{$camelCaseName}() instanceof Relation) {
            $name = $camelCaseName;
        }

        $normalizedName = $this->normalizeTranslatableFieldName($name);
        $name = str_between($name, 'translatable[', ']');

        try {
            $value = data_get($entity, $name);
        } catch (LogicException $e) {
            $value = $entity->getOriginal('url');
        }

        if ($value instanceof Money) {
            $value = $value->amount();
        }

        return old($normalizedName, $value);
    }

    protected function generateHtmlAttributes($options = [])
    {
        $this->unsetUnnecessaryAttributes($options);

        $attributes = '';

        foreach ($options as $attr => $value) {
            $attributes .= "{$attr}='{$value}' ";
        }

        return $attributes;
    }

    protected function unsetUnnecessaryAttributes(&$options = [])
    {
        foreach ($this->unnecessaryAttributes as $attribute) {
            if (array_key_exists($attribute, $options)) {
                unset($options[$attribute]);
            }
        }
    }
}
