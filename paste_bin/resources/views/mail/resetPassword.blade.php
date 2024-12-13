@if($errors->any()){
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
}
@endif

<form method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $user[0]['id'] }}">
    <input type="password" name="password" placeholder="New Password" required>
    <br>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
    <br>
    <input type="submit" value="Reset Password">
</form>