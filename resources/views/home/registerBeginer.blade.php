<!-- resources/views/auth/register.blade.php -->
<form method="POST" action="{{ route('custom.register') }}">
    @csrf
    <div>
        sssssssss
        <label for="name">Name:</label>
        <input id="name" type="text" name="name" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input id="email" type="email" name="email" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input id="password" type="text" name="password" required>
    </div>
    <div>
        <button type="submit">Register</button>
    </div>
</form>
