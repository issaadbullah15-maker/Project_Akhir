<x-layouts.guest title="Masuk">
    <div class="w-full max-w-[420px] rounded-lg border border-line bg-white p-8">
        <div class="flex flex-col gap-2">
            <h2 class="text-[24px] leading-[1.5] text-ink">Masuk ke akun Anda</h2>
            <p class="text-sm leading-[1.5] text-muted">Gunakan akun yang telah terdaftar.</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="mt-6 flex flex-col gap-6">
            @csrf

            <x-field label="Email" name="email" type="email" placeholder="nama@tamanbaca.id" required autofocus />
            <x-field label="Kata sandi" name="password" type="password" placeholder="••••••••••••" required />

            <x-button type="submit" class="w-full">Masuk</x-button>
        </form>
    </div>
</x-layouts.guest>
