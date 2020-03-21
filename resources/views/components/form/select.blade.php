<div class="form-group">
    {{ Form::label($name, null, ['class' => 'control-label']) }}
    {{Form::select($name,[
    '1' => '1 minute',
    '5' => '5 minute',
    '15' => '15 minute',
    '30' => '30 minute',
    '60' => '1 hour',
    '360' => '6 hour',
    '720' => '12 hour',
    '1440' => '24 hour'
])}}
</div>


 
   