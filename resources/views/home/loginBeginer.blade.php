<!-- resources/views/auth/login.blade.php -->
beginers
@if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
<form method="POST" action="{{ route('custom.login') }}">
    @csrf
    <div>
        <label for="email">Email:</label>
        <input id="email" name="email" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input id="password" type="text" name="password" required>
    </div>
    <div>
        <button type="submit">Login</button>
    </div>
</form>
