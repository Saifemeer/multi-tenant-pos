<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | SaaS POS</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #06070A; }
        .glass {
            background: rgba(17,19,24,0.85);
            border: 1px solid rgba(255,255,255,0.06);
        }
        .input-modern {
            background: #111318;
            border: 1px solid rgba(255,255,255,0.1);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            width: 100%;
            font-size: 14px;
            outline: none;
        }
        .input-modern:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover { opacity: 0.9; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 text-white">

    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold">Forgot your password?</h1>
            <p class="text-sm text-gray-400 mt-2">No worries — enter your email and we'll send you a reset link.</p>
        </div>

        <div class="glass rounded-2xl p-6">
            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-3 rounded-xl text-sm mb-5">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-3 rounded-xl text-sm mb-5">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="input-modern" placeholder="you@example.com">
                </div>
                <button type="submit" class="btn-primary">Send Reset Link</button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold">← Back to Login</a>
        </p>
    </div>

</body>
</html>