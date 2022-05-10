<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    product: Object,
    detail: {
        type: Boolean,
        default: false
    },
    admin: {
        type: Boolean,
        default: false
    }
})
const imageStyle = computed(() => {
    return props.product.image_url ? `background: url(${props.product.image_url})` : ''
})

</script>

<template>
    <Link
        :href="
            admin
            ? route('categories.products.show', {category: product.category_id, product: product.id})
            : route('product.show', {product: product.slug})"
        class="bg-white rounded-lg shadow">
        <!-- Title -->
        <div
            class="h-48 rounded-t-lg bg-no-repeat bg-center bg-cover bg-khidmah/80 text-lg"
            :style="imageStyle" />
        
        <!-- Content if enabled -->
        <div v-if="detail" class="p-6 pt-3">
            <div class="flex justify-end mb-2" v-if="$page.props.user.is_admin">
                <slot name="admin" />
            </div>

            <h3 class="font-bold text-khidmah" v-text="product.name" />
            <h6 v-text="product.price" />
        </div>
    </Link>
</template>