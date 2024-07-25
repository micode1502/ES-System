<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Preferences') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Update your profile preferences such as language.') }}
        </p>
    </header>

    <form method="post" action="{{ route('change-language') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="lang" :value="__('Language')" />
            {{-- <x-text-input id="locale" name="locale" type="password" class="mt-1 block w-full" /> --}}
            <select id="lang" name="lang" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                @foreach (__('actions.lang') as $key => $lang)
                    <option value="{{ $key }}"{{ app()->getLocale() === $key ? ' selected' : '' }}>
                        {{ __($lang) }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->updatePreferences->get('lang')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'preferences-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm bg-green-100 text-green-800 font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
