<p>Сообщение от проекта {{ config('app.name') }}</p>

@foreach($message as $key=>$value )
<p>{{ $key }}: {{ $value }}</p>
@endforeach
<pre style="font-size: 18px;line-height: 1.5;word-spacing: 5px;">{!! $trace !!}</pre>
