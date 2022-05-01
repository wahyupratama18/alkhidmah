<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import StoreLayout from '@/Layouts/StoreLayout.vue';
import CategoryCard from '@/Jetstream/CategoryCard.vue';

defineProps({
    categories: Array
})

const remove = (id, cat) => {
    Swal.fire({
        text: `Apakah anda yakin ingin menghapus kategori ${cat}?`,
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true
    }).then(res => {
        if (res.value) {
            console.log('deleted')
        }
    })
}
</script>

<template>
    <StoreLayout title="Daftar Kategori">
        <!-- Content -->
        <div class="p-8">
            <!-- create new -->
            <div class="flex justify-end mb-3">
                <Link :href="route('categories.create')">
                    <JetButton v-text="'Tambah'" />
                </Link>
            </div>
            <!-- end create new -->

            <!-- available categories -->
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
                <CategoryCard v-for="(category, index) in categories" :key="index" :category="category" :detail="true">
                    <!-- edit / delete -->
                    <template #admin>
                        <Link :href="route('categories.edit', {category: category.id})" class="mdi mdi-pencil text-khidmah cursor-pointer" />
                        <i @click="remove(category.id, category.name)" class="mdi mdi-trash-can text-red-500 cursor-pointer" />
                    </template>
                </CategoryCard>
            </div>
            <!-- end available categories -->
        </div>
    </StoreLayout>
</template>