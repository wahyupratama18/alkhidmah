<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    category: Object,
    detail: {
        type: Boolean,
        default: false
    }
})
const imageStyle = computed(() => {
    return props.category.image_url ? `background: url(${props.category.image_url})` : ''
})

</script>

<template>
    <div class="bg-white rounded-lg shadow">
        <!-- Title -->
        <Link
            :href="route('categories.show', {category: category.id})"
            class="h-48 rounded-t-lg bg-no-repeat bg-center bg-cover bg-khidmah/80 flex items-center justify-center text-white text-lg"
            :style="imageStyle"
            v-text="category.name" />
        
        <!-- Content if enabled -->
        <div v-if="detail" class="p-6 pt-3">
            <div class="flex justify-end mb-2" v-if="$page.props.user.is_admin">
                <slot name="admin" />
            </div>
            
            <h5 class="font-medium" v-html="category.description" />
            <h6 class="text-sm">Statistik:</h6>
            <p class="text-sm">
                Produk: {{ category.products_count }}<br>
                Sub Kategori: {{ category.categories_count }}
            </p>
        </div>
    </div>
</template>