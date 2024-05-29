<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Antes de continuar, ¿podrías verificar tu correo pulsando el link que recién te enviamos?') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Se ha enviado un nuevo link de verificación a la dirección de correo electrónico proporcionada.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Reenviar Email de verificación') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
