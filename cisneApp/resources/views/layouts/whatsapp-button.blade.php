<div class="fixed bottom-6 right-6 z-50 animate-bounce">
    <a href="https://wa.me/{{ $phone ?? '1234567890' }}?text={{ urlencode($message ?? 'Hola, me gustaría obtener más información sobre sus servicios.') }}"
        target="_blank"
        class="w-16 h-16 flex items-center justify-center rounded-full bg-green-500 hover:bg-green-600 text-white shadow-2xl pulse-green">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16.72 13.06c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.8-1.48-1.77-1.65-2.07-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.5-.17 0-.37 0-.57 0-.2 0-.52.07-.8.37-.27.3-1.05 1.02-1.05 2.48s1.08 2.88 1.23 3.08c.15.2 2.12 3.23 5.12 4.52.72.31 1.28.49 1.72.63.72.23 1.37.2 1.88.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.08-.12-.27-.2-.57-.35z" />
        </svg>
    </a>
</div>
