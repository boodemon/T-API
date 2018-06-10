<h2>Welcome to FOOD@SET MOBILE APPLICATION Member</h2>
<h3>Account Login</h3>
<p><strong>E-mail : </strong> {{ $request->input('email') }}</p>
<p><strong>Password : </strong> {{ $request->input('password') }}</p>
<hr/>
<p><strong>MEMBER DETAIL</strong></p>
<p><strong>Name : </strong>{{ $request->input('name') }}</p>
<p><strong>Username : </strong>{{ $request->input('username') }}</p>
<p><strong>Email : </strong>{{ $request->input('email') }}</p>
<p><strong>Tel : </strong>{{ $request->input('tel') != '' ? $request->input('tel') : '' }}</p>

<hr/>

<br/>
<br/>
<br/>
<p><strong>Rest Regards</strong></p>
<p><strong>FOOD@SET MOBILE APPLICATION</strong></p>
