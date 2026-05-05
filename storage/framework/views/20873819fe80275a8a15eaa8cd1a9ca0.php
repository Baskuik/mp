<div class="language-switcher">
    <form id="language-form" method="POST" class="inline">
        <?php echo csrf_field(); ?>
        <select id="language-select"
            onchange="document.getElementById('language-form').action = '<?php echo e(url('set-language')); ?>/' + this.value; document.getElementById('language-form').submit();"
            class="px-3 py-2 border border-white/30 rounded-xl text-sm bg-white/10 text-white hover:bg-white/20 cursor-pointer transition-all duration-150">
            <option value="nl" class="text-gray-900" <?php echo e(app()->getLocale() === 'nl' ? 'selected' : ''); ?>>🇳🇱 NL
            </option>
            <option value="de" class="text-gray-900" <?php echo e(app()->getLocale() === 'de' ? 'selected' : ''); ?>>🇩🇪 DE
            </option>
            <option value="en" class="text-gray-900" <?php echo e(app()->getLocale() === 'en' ? 'selected' : ''); ?>>🇬🇧 EN
            </option>
            <option value="be" class="text-gray-900" <?php echo e(app()->getLocale() === 'be' ? 'selected' : ''); ?>>🇧🇪 BE
            </option>
        </select>
    </form>
</div>
<?php /**PATH C:\Users\bas15\mp\resources\views/components/language-switcher.blade.php ENDPATH**/ ?>