{{--
<div class="row">
	<div class="md-col-12">
		<h1>Signup</h1>
	</div>
</div>
--}}
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		{{ Form::open(array('url'=>'api/user/signup', 'method'=>'post')) }}
		<div class="errors"></div>
		<!-- First Name -->
		<div class="form-group">
			{{ Form::label('fname', 'First Name') . Form::text('fname', Input::old('fname'), array('placeholder'=>'First Name', 'class'=>'form-control')) }}
		</div>
		<!-- Last Name -->
		<div class="form-group">
			{{ Form::label('lname', 'Last Name') . Form::text('lname', Input::old('lname'), array('placeholder'=>'Last Name', 'class'=>'form-control')) }}
		</div>
		<!-- Email -->
		<div class="form-group">
			{{ Form::label('email', 'Email') . Form::text('email', Input::old('email'), array('placeholder'=>'Email', 'class'=>'form-control')) }}
		</div>
		<!-- Password -->
		<div class="form-group">
			{{ Form::label('password', 'Password') . Form::password('password', array('placeholder'=>'Password', 'class'=>'form-control')) }}
		</div>
		<!-- Submit -->
		{{ Form::submit('Signup', array('class'=>'btn btn-default')) }}
		{{ Form::token() . Form::close() }}
	</div>
</div>
