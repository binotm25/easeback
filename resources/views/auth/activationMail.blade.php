@component('layouts.email')
	
	@slot('title')
		Email Activation
	@endslot

	@slot('content')
		<p>Hi there, {{ $user->name }}</p>
		<p>Please activate Your Account by clicking the button.</p>
		<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
		    <tbody>
		        <tr>
		            <td align="left">
		                <table border="0" cellpadding="0" cellspacing="0">
		                    <tbody>
		                        <tr>
		                            <td> 
		                            	<a href="http://localhost:8080/#/user-activate/{{ $user->email }}/{{ $code }}">Verify</a>
		                            	{{-- <a href="{{ route('activate', ['email'=>$user->email, 'code'=>$code]) }}" target="_blank">Activate Your Email</a>  --}}
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		            </td>
		        </tr>
		    </tbody>
		</table>
		<p>Please Ignore if you haven't register with EaseMyPay or already activated your account!</p>
		<p>Good luck!</p>
	@endslot
	
@endcomponent