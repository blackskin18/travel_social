<!doctype html>
<html lang="{{ app()->getLocale() }}">
<body>
<div class="containter">
    <div class="row">
        <form action="sendmessage" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="text" name="message">
            <input type="submit" value="send">
        </form>
    </div>
</div>
</body>
</html>
