<div style="font-family: arial, sans-serif;">
    <div style="width: 100%; background-color: #49BF85; padding: 25px;">
        <h1 style="text-align: center;color: #fff;">{{ trans('email.reset_password') }}</h1>
    </div>
    <p style="text-align: center; color: #424242;">
        {{ trans('email.reset_pass_body') }}
        <br><br><br>
        <a href="{{ route('reset_pass', [ 'code' => $code ]) }}"
           style="padding: 15px; background-color: #00ABD6; border-radius: 5px; color: #fff; text-decoration: none; font-size: 16px; font-weight: bold;">
            {{ trans('email.reset_password') }}
        </a>
    </p>
</div>
