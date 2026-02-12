@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-24 w-24 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Berhasil Logout
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Anda telah berhasil keluar dari sistem. Terima kasih telah menggunakan Aplikasi Kasir.
            </p>
        </div>

        <div class="mt-8 space-y-6">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="space-y-4">
                    <p class="text-center text-gray-700">
                        Untuk melanjutkan, silakan login kembali.
                    </p>

                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}"
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center transition duration-200">
                            Login Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-500">
                    Sistem akan otomatis redirect dalam <span id="countdown" class="font-semibold">5</span> detik...
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    let countdown = 5;
    const countdownElement = document.getElementById('countdown');

    const timer = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;

        if (countdown <= 0) {
            clearInterval(timer);
            window.location.href = '{{ route("login") }}';
        }
    }, 1000);
</script>
@endsection