<h1> Verify Your Email {{ $name }} </h1>
<span>To confirm your email : <a href='{{ URL::to("/api/verify-email/$verification_token") }}'>Click Here</a></span>
