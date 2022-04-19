<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-transparent border border-khidmah rounded-md font-semibold text-xs text-khidmah uppercase tracking-widest hover:border-khidmah/70 focus:outline-none focus:border-khidmah/90 focus:ring focus:ring-khidmah/30 disabled:opacity-25 transition">
        <slot />
    </button>
</template>
