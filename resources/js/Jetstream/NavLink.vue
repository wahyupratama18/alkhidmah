<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-khidmah text-sm font-medium leading-5 text-khidmah focus:outline-none focus:border-khidmah/70 transition'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-khidmah hover:text-khidmah/70 hover:border-khidmah/30 focus:outline-none focus:text-khidmah/70 focus:border-khidmah/30 transition';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
