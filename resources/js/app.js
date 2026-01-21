import collapse from '@alpinejs/collapse';

// Livewire already includes Alpine, so we just need to register our plugins
document.addEventListener('livewire:init', () => {
    if (window.Alpine) {
        window.Alpine.plugin(collapse);
    }
});
