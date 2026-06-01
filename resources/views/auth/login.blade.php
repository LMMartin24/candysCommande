<x-guest-layout>
    <x-auth-session-status class="mb-4 text-xs font-bold text-green-600 uppercase tracking-widest" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-widest text-dark mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full border-4 border-dark rounded-xl px-4 py-3 font-bold text-dark bg-paper focus:outline-none focus:border-accent">
            @error('email')
                <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-black uppercase tracking-widest text-dark mb-1">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full border-4 border-dark rounded-xl px-4 py-3 font-bold text-dark bg-paper focus:outline-none focus:border-accent">
            @error('password')
                <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-accent border-4 border-dark font-black uppercase tracking-widest py-3 rounded-xl shadow-[4px_4px_0_#231F20] active:translate-y-1 transition-transform text-dark text-sm">
            Se connecter →
        </button>
    </form>
</x-guest-layout>
