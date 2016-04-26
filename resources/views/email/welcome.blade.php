<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Verify Your Email Address</h2>

        <div>
            Hi {{$name}},
            Thanks for creating an account.
            We welcome you to Hitch.
            Please follow the link below to verify your email address
            {{URL::to('confirm/'.$id.'/'.$authkey)}}<br/>

        </div>

    </body>
</html>
