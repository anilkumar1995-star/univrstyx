<p>Hello {{ $name }},</p>

<p>Welcome to the company. Here are your login credentials:</p>

<ul>
    <li><strong>Mobile:</strong> {{ $mobile }}</li>
    <li><strong>Password:</strong> {{ $password }}</li>
</ul>

<p>Please change your password after logging in for the first time.</p>
 <p style="margin-top: 20px;">
            👉 <a href="{{url('/')}}" style="color: #007bff;">Click Here To Login</a>
        </p>

<p>Thank you,<br>
<p>Regards,<br>HR Team</p>
