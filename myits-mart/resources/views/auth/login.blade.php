<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - myITS Mart</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Menggunakan font Poppins sebagai default */
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Kustomisasi warna utama agar sesuai dengan palet ITS */
        .bg-its-blue {
            background-color: #2775D3;
        }
        .hover\:bg-its-blue-dark:hover {
            background-color: #1E5AAB;
        }
        .text-its-blue {
            color: #2775D3;
        }
        .focus\:ring-its-blue:focus {
            --tw-ring-color: #2775D3;
        }
        .border-its-blue {
            border-color: #2775D3;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        
        <div class="text-center mb-6">
            <svg class="w-16 h-16 mx-auto text-its-blue" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.658-.463 1.243-1.119 1.243H4.559c-.656 0-1.189-.585-1.119-1.243l1.263-12a1.125 1.125 0 0 1 1.12-1.007h8.632c.523 0 .973.342 1.12.833Z" />
            </svg>

            <h1 class="text-3xl font-bold text-gray-800 mt-2">myITS Mart</h1>
            <p class="text-gray-500">Silakan login untuk melanjutkan</p>
        </div>

        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        class="w-full px-4 py-3 bg-gray-50 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-its-blue"
                        value="{{ old('email') }}" 
                        required 
                        autofocus>
                    
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="w-full px-4 py-3 bg-gray-50 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-its-blue"
                        required>

                     @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-its-blue border-gray-300 rounded focus:ring-its-blue">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Ingat Saya</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-its-blue hover:underline">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <div>
                    <button 
                        type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-its-blue hover:bg-its-blue-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-its-blue transition-colors duration-200">
                        Login
                    </button>
                </div>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-its-blue hover:underline">
                    Daftar di sini
                </a>
            </p>
        </div>
        
        <div class="text-center mt-8 text-sm text-gray-500">
            © {{ date('Y') }} myITS Mart. Terinspirasi dari myITS Portal.
        </div>
    </div>

</body>
</html>