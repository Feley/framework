@extends('site.layouts.index')
@section('title', 'Voom Framework')
@section('content')
<div class="container">
<h2 class="container">
<p>The Framework for The Fast</p>
<p>fast is @_e('fast')</p>
<p>@_ef('%s is fast','voom')</p>
</h2>
</div>
@endsection