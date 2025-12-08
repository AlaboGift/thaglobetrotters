@if(session('error'))
    <div class="alert alert-close alert-danger">
        <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
        <p>{{ session('error') }}</p>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-close alert-success">
        <a href="#" title="Close" class="glyph-icon alert-close-btn icon-remove"></a>
        <p>{{session('success')}}</p>
    </div>
@endif
 
@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif