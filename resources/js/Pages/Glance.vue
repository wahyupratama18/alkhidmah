<script setup>
import StoreLayout from '@/Layouts/StoreLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    categories: Array
})
</script>

<template>
    <StoreLayout title="Dashboard">
        <!-- Content -->
        <div class="p-8 gap-y-4 divide-y divide-khidmah">
            <!-- Loopline -->
            <ol v-for="(category, index) in categories" :key="index">
                <li class="mt-4">
                    <!-- Headings -->
                    <div class="flex items center gap-x-2">
                        <h3 class="font-bold text-lg" v-text="category.name" />
                        <Link
                            class="text-khidmah text-sm font-medium"
                            :href="route('category.show', {category: category.slug})"
                            v-text="'Lihat semua'" />
                    </div>
                    <!-- End Heading -->
                    
                    <!-- Products -->
                    <ol v-for="(product, prod) in category.products" :key="prod">
                        <li>
                            <!-- Product card came here -->
                        </li>
                    </ol>
                    <!-- End Products -->
                </li>
            </ol>
            <!-- End loop -->

        </div>
        <!-- End Content -->
    </StoreLayout>
</template>