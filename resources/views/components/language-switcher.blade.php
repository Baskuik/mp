<div class="language-switcher">
    <select id="language-select" onchange="window.location.href = '{{ url('set-language') }}/' + this.value;"
        class="px-3 py-2 border border-white/30 rounded-xl text-sm bg-white/10 text-white hover:bg-white/20 cursor-pointer transition-all duration-150">
        <option value="nl" class="text-gray-900" {{ app()->getLocale() === 'nl' ? 'selected' : '' }}>🇳🇱 NL
        </option>
        <option value="de" class="text-gray-900" {{ app()->getLocale() === 'de' ? 'selected' : '' }}>🇩🇪 DE
        </option>
        <option value="en" class="text-gray-900" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>🇬🇧 EN
        </option>
    </select>
</div>
