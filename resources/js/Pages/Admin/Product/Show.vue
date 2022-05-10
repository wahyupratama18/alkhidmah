<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetLabel from '@/Jetstream/Label.vue';
import Textarea from '@/Jetstream/Textarea.vue';
import StoreLayout from '@/Layouts/StoreLayout.vue';
import CategoryCard from '@/Jetstream/CategoryCard.vue';
import vSelect from 'vue-select';

defineProps({
    category: Object
})

const remove = (cat, product) => {
    Swal.fire({
        text: `Apakah anda yakin ingin menghapus produk ${product.name}?`,
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true
    }).then(res => {
        if (res.value) {
            Inertia.delete(route('categories.product.destroy', {category: cat, product: product.id}))
            // console.log('deleted')
        }
    })
}
</script>

<template>
    <StoreLayout title="Daftar Kategori">
        
        <!-- Content -->
        <div class="p-8">
            <!-- current categories -->
            <div class="grid md:grid-cols-3 gap-6">
                <img :src="category.image_url" :alt="category.name">

                <div class="md:col-span-2">
                    <!-- name -->
                    <div class="mb-4">
                        <JetLabel for="name" value="Nama*" />
                        <JetInput
                            id="name"
                            :value="category.name"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="name"
                            disabled
                        />
                    </div>

                    <!-- sub category -->
                    <div class="mb-4">
                        <JetLabel for="category_id" value="Sub Kategori" />
                        <JetInput
                            id="name"
                            :value="category.category ? category.category.name : null"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="name"
                            disabled
                        />
                    </div>

                    <!-- description -->
                    <div class="mb-4">
                        <JetLabel for="description" value="Deskripsi*" />
                        <Textarea
                            id="description"
                            :value="category.description"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="description"
                        />
                    </div>

                </div>
            </div>
            <!-- end current categories -->

            <!-- products -->
            <div class="mt-3">
                <div class="flex justify-end mb-3">
                    <Link :href="route('categories.products.create', {category: category.id})">
                        <JetButton v-text="'Tambah Produk'" />
                    </Link>
                </div>

                <template v-if="category.products">
                    <h2 v-html="'Produk tersedia'"></h2>
                    
                    <CategoryCard v-for="(product, index) in category.products" :key="index" :category="product">
                        <!-- edit / delete -->
                        <template #admin>
                            <Link :href="route('categories.edit', {category: category.id})" class="mdi mdi-pencil text-khidmah cursor-pointer" />
                            <i @click="remove(category.id, product)" class="mdi mdi-trash-can text-red-500 cursor-pointer" />
                        </template>
                    </CategoryCard>
                </template>
            </div>
            <!-- end products -->
        </div>
    </StoreLayout>
</template>