@extends('layouts.app')

@section('title', __('messages.settings'))

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.settings') }}</h1>
                <p class="text-gray-600 mt-2">{{ __('messages.manage_your_account_settings') }}</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                    <p class="text-green-600 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-4 py-3 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Settings Container with Sidebar Navigation -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar Navigation (Story 400) -->
                <div class="lg:col-span-1">
                    <nav class="space-y-2 bg-white rounded-xl p-4 border border-gray-200">
                        <a href="#language-settings"
                            class="block px-4 py-2.5 rounded-lg text-left text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors"
                            onclick="scrollToSection('#language-settings')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10m-5 10l-4-8m4 8l1-3m-6 3l-1-3m0 3h-.5" />
                                </svg>
                                {{ __('messages.language_settings') }}
                            </span>
                        </a>
                        <a href="#personal-information"
                            class="block px-4 py-2.5 rounded-lg text-left text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors"
                            onclick="scrollToSection('#personal-information')">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.personal_information') }}
                            </span>
                        </a>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Language Settings Section (Story 402) -->
                    <section id="language-settings" class="bg-white rounded-xl border border-gray-200 p-6 scroll-mt-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('messages.language_settings') }}</h2>

                        <form method="POST" action="{{ route('settings.language') }}" novalidate>
                            @csrf

                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    {{ __('messages.preferred_language') }}
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10m-5 10l-4-8m4 8l1-3m-6 3l-1-3m0 3h-.5" />
                                    </svg>
                                    <select id="language" name="language" required
                                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('language') border-red-400 @enderror"
                                        value="{{ $user->language ?? 'nl' }}">
                                        <option value="">{{ __('messages.select_language') }}</option>
                                        @foreach ($languages as $code => $label)
                                            <option value="{{ $code }}"
                                                {{ ($user->language ?? 'nl') === $code ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('language')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="mt-6 px-6 py-2.5 bg-[#2D6A4F] text-white rounded-xl text-sm font-medium hover:bg-[#245a41] transition-colors">
                                {{ __('messages.save_changes') }}
                            </button>
                        </form>
                    </section>

                    <!-- Personal Information Section (Story 403) -->
                    <section id="personal-information" class="space-y-6 scroll-mt-8">
                        <!-- Change Password -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('messages.change_password') }}</h3>

                            <form method="POST" action="{{ route('settings.password') }}" novalidate>
                                @csrf

                                {{-- Current Password --}}
                                <div class="mb-4">
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        {{ __('messages.current_password') }}
                                    </label>
                                    <div class="relative">
                                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <input id="current_password" type="password" name="current_password" required
                                            class="w-full pl-10 pr-11 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('current_password') border-red-400 @enderror">
                                        <button type="button" onclick="togglePassword('current_password', this)"
                                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- New Password --}}
                                <div class="mb-4">
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        {{ __('messages.new_password') }}
                                    </label>
                                    <div class="relative">
                                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <input id="new_password" type="password" name="new_password" required
                                            class="w-full pl-10 pr-11 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('new_password') border-red-400 @enderror">
                                        <button type="button" onclick="togglePassword('new_password', this)"
                                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="mb-4">
                                    <label for="new_password_confirmation"
                                        class="block text-sm font-medium text-gray-700 mb-1.5">
                                        {{ __('messages.confirm_password') }}
                                    </label>
                                    <div class="relative">
                                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <input id="new_password_confirmation" type="password"
                                            name="new_password_confirmation" required
                                            class="w-full pl-10 pr-11 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('new_password_confirmation') border-red-400 @enderror">
                                        <button type="button" onclick="togglePassword('new_password_confirmation', this)"
                                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('new_password_confirmation')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="px-6 py-2.5 bg-[#2D6A4F] text-white rounded-xl text-sm font-medium hover:bg-[#245a41] transition-colors">
                                    {{ __('messages.update_password') }}
                                </button>
                            </form>
                        </div>

                        <!-- Change Phone Number -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('messages.phone_number') }}</h3>

                            <form method="POST" action="{{ route('settings.phone') }}" novalidate>
                                @csrf

                                <div class="mb-4">
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        {{ __('messages.phone_number') }}
                                    </label>
                                    <div class="relative">
                                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <input id="phone_number" type="tel" name="phone_number"
                                            value="{{ $user->phone_number }}" placeholder="+31 6 12 34 56 78"
                                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('phone_number') border-red-400 @enderror">
                                    </div>
                                    <p class="text-gray-500 text-xs mt-1.5">{{ __('messages.phone_format_help') }}</p>
                                    @error('phone_number')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="px-6 py-2.5 bg-[#2D6A4F] text-white rounded-xl text-sm font-medium hover:bg-[#245a41] transition-colors">
                                        {{ __('messages.save_changes') }}
                                    </button>

                                    @if ($user->phone_number)
                                        <button type="button" onclick="removePhone()"
                                            class="px-6 py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-xl text-sm font-medium hover:bg-red-100 transition-colors">
                                            {{ __('messages.remove_phone') }}
                                        </button>
                                    @endif
                                </div>
                            </form>

                            @if ($user->phone_number)
                                <form method="POST" action="{{ route('settings.phone') }}" id="removePhoneForm"
                                    class="hidden">
                                    @csrf
                                    <input type="hidden" name="phone_number" value="">
                                </form>
                            @endif
                        </div>

                        <!-- Change Email -->
                        <div class="bg-white rounded-xl border border-gray-200 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('messages.email_address') }}</h3>

                            <form method="POST" action="{{ route('settings.email') }}" novalidate>
                                @csrf

                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                                        {{ __('messages.email_address') }}
                                    </label>
                                    <div class="relative">
                                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <input id="email" type="email" name="email" value="{{ $user->email }}"
                                            required
                                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 bg-white placeholder-gray-400 focus:outline-none focus:border-[#2D6A4F] focus:ring-4 focus:ring-[#2D6A4F]/10 transition-all @error('email') border-red-400 @enderror">
                                    </div>
                                    @if (!$user->email_verified_at)
                                        <p class="text-yellow-600 text-xs mt-1.5">{{ __('messages.email_not_verified') }}
                                        </p>
                                    @else
                                        <p class="text-green-600 text-xs mt-1.5">{{ __('messages.email_verified') }}</p>
                                    @endif
                                    @error('email')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="px-6 py-2.5 bg-[#2D6A4F] text-white rounded-xl text-sm font-medium hover:bg-[#245a41] transition-colors">
                                    {{ __('messages.save_changes') }}
                                </button>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Helpers -->
    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
        }

        function removePhone() {
            if (confirm('{{ __('messages.confirm_remove_phone') }}')) {
                document.getElementById('removePhoneForm').submit();
            }
        }

        function scrollToSection(sectionId) {
            const section = document.querySelector(sectionId);
            if (section) {
                section.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    </script>
@endsection
