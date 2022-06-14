@component('mail::message')
<h2>Hello {{$body['email']}},</h2>

<p>Please use the below code to reset your password

<h2> {{$body['code']}} </h2>

<p> This code is valid for 30 minutes only</p>
</p>

Thanks,<br>
GP
@endcomponent