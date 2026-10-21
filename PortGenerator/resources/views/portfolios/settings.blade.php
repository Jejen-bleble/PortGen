<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortGen - Settings</title>
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link rel="stylesheet" href="/css/settings.css">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&family=Sansation:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
       
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('home') }}" class="logo">PortGen</a>
            <a href="{{ route('home') }}" class="back-home">&larr; Back to Dashboard</a>
        </nav>
    </header>

    <div class="container">
        <div class="page-header">
            <h1>Settings</h1>
            <p>Update your profile information and account security credentials.</p>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="settings-grid">
            <!-- Left Column: Profile & Password -->
            <div>
                <!-- Profile Card -->
                <div class="card">
                    <h3>Profile Information</h3>
                    <p class="desc">Update your account's profile name and email address.</p>

                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required />
                            @error('name') <div class="error-msg">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                            @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn-submit">Save Changes</button>
                    </form>
                </div>

                <!-- Set/Update Password Card -->
                <div class="card">
                    <h3>Security & Password</h3>
                    <p class="desc">Ensure your account is secure by setting a strong password.</p>

                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input id="password" type="password" name="password" placeholder="Leave blank to keep current" />
                            @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" />
                        </div>

                        <button type="submit" class="btn-submit">Update Password</button>
                    </form>
                </div>
            </div>

            <!-- Right Column: Danger Zone -->
            <div>
                <div class="card" style="border-color: rgba(248, 113, 113, 0.4);">
                    <h3 style="color: #f87171;">Delete Account</h3>
                    <p class="desc">Permanently remove your account, portfolios, and uploaded items. This action cannot be undone.</p>

                    <form method="POST" action="{{ route('settings.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? All your portfolios will be permanently wiped out.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Delete Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>