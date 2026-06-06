<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - PT. Jaya Raya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }, colors: { primary: '#2563EB' } } }
        }
    </script>
</head>
<body class="font-sans text-slate-800 antialiased bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-primary flex items-center justify-center text-white font-bold text-3xl mx-auto shadow-lg mb-4">J</div>
            <h1 class="text-2xl font-extrabold text-slate-900">JAYA RAYA</h1>
            <p class="text-sm text-slate-500 font-semibold">Portal Admin</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2 mb-6">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Admin</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Captcha: <span class="text-primary font-extrabold">{{ $captchaData['question'] }}</span>
                    </label>
                    <input type="text" name="captcha" required placeholder="Jawaban"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-colors @error('captcha') border-red-400 @enderror">
                    @error('captcha')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary focus:ring-primary">
                        <span class="text-sm text-slate-600">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline font-medium">Lupa password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition-colors text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-lock"></i> Masuk sebagai Admin
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('staff.login') }}" class="text-sm text-slate-500 hover:text-slate-700">
                    <i class="fa-solid fa-user"></i> Login sebagai Staff
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">ERP System &copy; PT. Jaya Raya</p>
    </div>
</body>
</html>
