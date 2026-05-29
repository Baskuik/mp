<!-- Terms Modal -->
<div id="termsModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] flex flex-col">

        {{-- Modal Header --}}
        <div
            class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ __('terms.terms_heading_1') }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ __('terms.modal_description') }}</p>
            </div>
        </div>

        {{-- Modal Content (Scrollable) --}}
        <div id="termsContent" class="overflow-y-auto flex-1 px-6 py-6 space-y-6">

            {{-- Terms Section --}}
            <div>
                {{-- Section 1 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.terms_section_1_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.terms_section_1_content') }}</p>
                </div>

                {{-- Section 2 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.terms_section_2_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.terms_section_2_content') }}</p>
                </div>

                {{-- Section 3 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.terms_section_3_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.terms_section_3_content') }}</p>
                </div>

                {{-- Section 4 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.terms_section_4_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.terms_section_4_content') }}</p>
                </div>

                {{-- Section 5 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.terms_section_5_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.terms_section_5_content') }}</p>
                </div>

                {{-- Section 6 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.terms_section_6_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.terms_section_6_content') }}</p>
                </div>

                {{-- Section 7 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.terms_section_7_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.terms_section_7_content') }}</p>
                </div>

                {{-- Section 8 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.terms_section_8_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.terms_section_8_content') }}</p>
                </div>
            </div>

        </div>

        {{-- Scroll Indicator --}}
        <div id="termsScrollIndicator"
            class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-6 py-3 text-center">
            <p class="text-sm text-gray-500">
                <span id="termsScrollPercentage">0</span>% {{ __('terms.scroll_to_accept') }}
            </p>
        </div>

        {{-- Modal Footer --}}
        <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex gap-3 rounded-b-2xl">
            <button onclick="closeTermsModal()"
                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 active:scale-[0.98]">
                {{ __('terms.decline_button') }}
            </button>
            <button id="acceptTermsBtn" onclick="acceptTermsAndOpenPrivacy()" disabled
                class="flex-1 bg-gray-300 text-gray-600 font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 active:scale-[0.98] cursor-not-allowed"
                data-enabled-classes="bg-[#2D6A4F] text-white cursor-pointer"
                data-disabled-classes="bg-gray-300 text-gray-600 cursor-not-allowed">
                {{ __('terms.accept_button_disabled') }}
            </button>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div id="privacyModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] flex flex-col">

        {{-- Modal Header --}}
        <div
            class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl">
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ __('terms.privacy_heading') }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ __('terms.modal_description') }}</p>
            </div>
        </div>

        {{-- Modal Content (Scrollable) --}}
        <div id="privacyContent" class="overflow-y-auto flex-1 px-6 py-6 space-y-6">

            {{-- Privacy Policy Section --}}
            <div>
                {{-- Section 1 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.privacy_section_1_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.privacy_section_1_content') }}</p>
                </div>

                {{-- Section 2 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.privacy_section_2_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.privacy_section_2_content') }}</p>
                </div>

                {{-- Section 3 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.privacy_section_3_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.privacy_section_3_content') }}</p>
                </div>

                {{-- Section 4 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.privacy_section_4_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.privacy_section_4_content') }}</p>
                </div>

                {{-- Section 5 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.privacy_section_5_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.privacy_section_5_content') }}</p>
                </div>

                {{-- Section 6 --}}
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('terms.privacy_section_6_title') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ __('terms.privacy_section_6_content') }}</p>
                </div>
            </div>

        </div>

        {{-- Scroll Indicator --}}
        <div id="privacyScrollIndicator"
            class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-6 py-3 text-center">
            <p class="text-sm text-gray-500">
                <span id="privacyScrollPercentage">0</span>% {{ __('terms.scroll_to_accept') }}
            </p>
        </div>

        {{-- Modal Footer --}}
        <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 flex gap-3 rounded-b-2xl">
            <button onclick="closePrivacyModal()"
                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 active:scale-[0.98]">
                {{ __('terms.decline_button') }}
            </button>
            <button id="acceptPrivacyBtn" onclick="acceptPrivacy()" disabled
                class="flex-1 bg-gray-300 text-gray-600 font-medium py-3 px-6 rounded-xl text-sm transition-all duration-200 active:scale-[0.98] cursor-not-allowed"
                data-enabled-classes="bg-[#2D6A4F] text-white cursor-pointer"
                data-disabled-classes="bg-gray-300 text-gray-600 cursor-not-allowed">
                {{ __('terms.accept_button_disabled') }}
            </button>
        </div>
    </div>
</div>

<script>
    let currentlyAcceptingTerms = false;

    // Terms Modal Variables
    const termsModal = document.getElementById('termsModal');
    const termsContent = document.getElementById('termsContent');
    const acceptTermsBtn = document.getElementById('acceptTermsBtn');
    const termsScrollPercentage = document.getElementById('termsScrollPercentage');

    // Privacy Modal Variables
    const privacyModal = document.getElementById('privacyModal');
    const privacyContent = document.getElementById('privacyContent');
    const acceptPrivacyBtn = document.getElementById('acceptPrivacyBtn');
    const privacyScrollPercentage = document.getElementById('privacyScrollPercentage');

    function openTermsModal() {
        currentlyAcceptingTerms = true;
        termsModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        termsContent.scrollTop = 0;
        updateTermsScrollProgress();
    }

    function closeTermsModal() {
        termsModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentlyAcceptingTerms = false;
        // Uncheck the terms checkbox when declining
        const termsCheckbox = document.getElementById('terms');
        termsCheckbox.checked = false;
    }

    function openPrivacyModal() {
        privacyModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        privacyContent.scrollTop = 0;
        updatePrivacyScrollProgress();
    }

    function closePrivacyModal(isDecline = true) {
        privacyModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        // Only uncheck if it's a decline, not when accepting
        if (isDecline) {
            const termsCheckbox = document.getElementById('terms');
            termsCheckbox.checked = false;
        }
    }

    function updateTermsScrollProgress() {
        const scrollTop = termsContent.scrollTop;
        const scrollHeight = termsContent.scrollHeight - termsContent.clientHeight;
        const scrolled = scrollHeight > 0 ? (scrollTop / scrollHeight) * 100 : 0;

        termsScrollPercentage.textContent = Math.round(scrolled);

        const isAtBottom = scrolled >= 95;

        if (isAtBottom) {
            acceptTermsBtn.disabled = false;
            acceptTermsBtn.classList.remove('cursor-not-allowed');
            acceptTermsBtn.classList.add('bg-[#2D6A4F]', 'text-white', 'cursor-pointer');
            acceptTermsBtn.classList.remove('bg-gray-300', 'text-gray-600');
            acceptTermsBtn.textContent = '{{ __('terms.accept_button') }}';
        } else {
            acceptTermsBtn.disabled = true;
            acceptTermsBtn.classList.add('cursor-not-allowed');
            acceptTermsBtn.classList.remove('bg-[#2D6A4F]', 'text-white', 'cursor-pointer');
            acceptTermsBtn.classList.add('bg-gray-300', 'text-gray-600');
            acceptTermsBtn.textContent = '{{ __('terms.accept_button_disabled') }}';
        }
    }

    function updatePrivacyScrollProgress() {
        const scrollTop = privacyContent.scrollTop;
        const scrollHeight = privacyContent.scrollHeight - privacyContent.clientHeight;
        const scrolled = scrollHeight > 0 ? (scrollTop / scrollHeight) * 100 : 0;

        privacyScrollPercentage.textContent = Math.round(scrolled);

        const isAtBottom = scrolled >= 95;

        if (isAtBottom) {
            acceptPrivacyBtn.disabled = false;
            acceptPrivacyBtn.classList.remove('cursor-not-allowed');
            acceptPrivacyBtn.classList.add('bg-[#2D6A4F]', 'text-white', 'cursor-pointer');
            acceptPrivacyBtn.classList.remove('bg-gray-300', 'text-gray-600');
            acceptPrivacyBtn.textContent = '{{ __('terms.accept_button') }}';
        } else {
            acceptPrivacyBtn.disabled = true;
            acceptPrivacyBtn.classList.add('cursor-not-allowed');
            acceptPrivacyBtn.classList.remove('bg-[#2D6A4F]', 'text-white', 'cursor-pointer');
            acceptPrivacyBtn.classList.add('bg-gray-300', 'text-gray-600');
            acceptPrivacyBtn.textContent = '{{ __('terms.accept_button_disabled') }}';
        }
    }

    function acceptTermsAndOpenPrivacy() {
        closeTermsModal();
        // Open privacy modal after a short delay for smooth transition
        setTimeout(() => {
            openPrivacyModal();
        }, 300);
    }

    function acceptPrivacy() {
        const termsCheckbox = document.getElementById('terms');
        termsCheckbox.checked = true;
        closePrivacyModal(false);
    }

    // Update scroll progress when scrolling
    termsContent.addEventListener('scroll', updateTermsScrollProgress);
    privacyContent.addEventListener('scroll', updatePrivacyScrollProgress);

    // Close modals when clicking outside
    termsModal.addEventListener('click', function(event) {
        if (event.target === termsModal) {
            closeTermsModal();
        }
    });

    privacyModal.addEventListener('click', function(event) {
        if (event.target === privacyModal) {
            closePrivacyModal();
        }
    });

    // Allow close with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            if (!termsModal.classList.contains('hidden')) {
                closeTermsModal();
            } else if (!privacyModal.classList.contains('hidden')) {
                closePrivacyModal();
            }
        }
    });
</script>
