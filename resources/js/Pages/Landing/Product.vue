<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetLabel from '@/Jetstream/Label.vue';
import Textarea from '@/Jetstream/Textarea.vue';
import StoreLayout from '@/Layouts/StoreLayout.vue';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';


defineProps({
    product: Object
})
</script>

<template>
    <StoreLayout title="Daftar Kategori">
        
        <!-- Content -->
        <div class="p-8">
            <!-- current categories -->
            <div class="grid md:grid-cols-3 gap-6">
                <Carousel>
                    <Slide v-for="(picture, index) in product.pictures" :key="index">
                        <img :src="picture.image_url" :alt="product.name">
                    </Slide>

                    <template #addons>
                        <Navigation />
                        <Pagination />
                    </template>
                </Carousel>

                <div>
                    <h1 class="font-extrabold text-xl text-khidmah" v-text="product.name" />

                    <h5 class="font-bold text-2xl" v-text="product.price" />
                    
                    <hr><h6>Detail</h6>
                    <p v-html="product.description" />

                </div>

                <div class="border-khidmah">
                    <h3 class="text-lg">Yuk beli!</h3>

                    <template v-if="product.variants.length > 1">
                        <h4>Pilih varian</h4>

                        <template v-for="(variant, index) in product.variants" :key="index">
                            <div
                            class="h-20"
                            :style="`background: '${variant.name}'`"
                            v-if="variant.type == 1"/>
                            <div
                            class="h-20 flex items-center"
                            v-else
                            v-text="variant.name"/>
                        </template>
                    </template>
                </div>
            </div>
            <!-- end current categories -->
        </div>
    </StoreLayout>
</template>