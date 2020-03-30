<div class="form-group">
    {{ Form::checkbox($name, $value, $default, array_merge(['class' => 'custom-check-input'], $attributes)) }} 
    {{ Form::label( $value, null, array_merge( ['class' => 'form-check-label'], $attributes) ) }}
</div>