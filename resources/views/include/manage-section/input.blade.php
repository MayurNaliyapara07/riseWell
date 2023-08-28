<?php
$class = !empty($configInput['class']) ? $configInput['class'] : '';
$label = !empty($configInput['label']) ? $configInput['label'] : 'Default';
$type = !empty($configInput['type']) ? $configInput['type'] : '';
$placeHolder = !empty($configInput['notes']) ? $configInput['notes'] : '';
$value = !empty($configInput['value']) ? $configInput['value'] : '';
?>
<div class="form-group {{ $class }}">
    <label class="form-label">
        {{ $label }}
    </label>
    @if ($type == 'text' || $type == 'number')
        <input type="{{ $type }}" class="form-control" id="{{ $inputName }}" placeholder="{{$placeHolder}}" name="{{ $inputName }}" value="{{ $value }}">
    @elseif($type == 'textarea')
        <textarea class="form-control summernote" id="{{ $inputName }}" name="{{ $inputName }}">{{ $value }}</textarea>
    @elseif($type == 'file')
        <input type="{{ $type }}" class="form-control" multiple id="{{ $inputName }}" placeholder="{{$placeHolder}}" name="{{ $inputName }}" value="{{ $value }}">

    @endif
</div>
