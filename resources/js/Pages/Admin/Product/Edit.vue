<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import Textarea from '@/Jetstream/Textarea.vue';
import StoreLayout from '@/Layouts/StoreLayout.vue';
import vSelect from 'vue-select';
import vueFilePond from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'

const props = defineProps({
    product: Object,
    types: Array
})

const form = useForm({
    _method: 'PUT',
    name: props.product.name,
    description: props.product.description,
    images: [],
    deleted: [],
    variants: props.product.variants
})

const newVariant = () => {
    form.variants.push({
        type: null,
        name: null,
        price: null,
        stock: null
    })
}

const removeVariant = index => {
    Swal.fire({
        text: `Apakah anda yakin ingin menghapusnya?`,
        icon: 'warning',
        showCancelButton: true,
        reverseButtons: true
    }).then(res => {
        if (res.value) {
            form.variants.splice(index, 1)
        }
    })
}

const submitted = () => {
    form.put(route('categories.products.update', {category: props.product.category_id, product: props.product.id}), {
        onSuccess: () => {
        }
    })
}

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
)

const server = {
    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
        const cancel = axios.CancelToken.source(),
            upload = new FormData()

        upload.append('file', file, file.name)

        axios.post(route('pond.store'), upload, {
            cancelToken: cancel.token,
            onUploadProgress: e => {
                progress(e.lengthComputable, e.loaded, e.total)
            }
        }).then(data => {
            load(data.data)

            form.images.push(data.data)
        }).catch(err => {
            error('Failed')
        })

        // Should expose an abort method so the request can be cancelled
        return {
            abort: () => {
                // This function is entered if the user has tapped the cancel button
                cancel.cancel('Operation canceled')
                // Let FilePond know the request has been cancelled
                abort();
            },
        };
    },
    load: 'pond/'
}

</script>

<template>
    <StoreLayout title="Edit Produk">
        <!-- Content -->
        <form class="p-8" @submit.prevent="submitted">
            <!-- name -->
            <div class="mb-4">
                <JetLabel for="name" value="Nama*" />
                <JetInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="name"
                />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- description -->
            <div class="mb-4">
                <JetLabel for="description" value="Deskripsi*" />
                <Textarea
                    id="description"
                    v-model="form.description"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="description"
                />
                <JetInputError :message="form.errors.description" class="mt-2" />
            </div>

            <!-- image -->
            <div class="mb-4">
                <JetLabel for="image" value="Gambar" />
                <FilePond
                    name="image"
                    ref="pond"
                    accepted-file-types="image/jpeg, image/png"
                    :server="server"
                    :files="form.images"
                    :allowMultiple="true"
                />
                <JetInputError :message="form.errors.images" class="mt-2" />
            </div>

            <!-- Variants -->
            <JetButton type="button" v-text="'Tambah Varian'" @click="newVariant" />
            <template class="mt-4 p-4 border" v-for="(variant, index) in form.variants" :key="index">

                <div class="flex justify-end">
                    <i class="mdi mdi-trash-can cursor-pointer text-red-500" @click="removeVariant(index)" />
                </div>
                
                <!-- Type -->
                <div class="mb-4">
                    <JetLabel for="image" value="Tipe*" />
                    <vSelect
                    v-model="form.variants[index].type"
                    class="mt-1 block w-full"
                    :options="types"
                    label="name"
                    :reduce="type => type.id" />
                    <JetInputError :message="form.errors[`variants.${index}.type`]" class="mt-2" />
                </div>

                <template v-if="variant.type">
                    <!-- Variant's Name -->
                    <div class="mb-4" v-if="variant.type === 1">
                        <JetLabel :for="`name[${index}]`" value="Pilih Warna*" />
                        <JetInput
                            :id="`name[${index}]`"
                            v-model="form.variants[index].name"
                            type="color"
                            class="mt-1 block w-full"
                            autocomplete="name"
                        />
                        <JetInputError :message="form.errors[`variants.${index}.name`]" class="mt-2" />
                    </div>

                    <div class="mb-4" v-else>
                        <JetLabel :for="`name[${index}]`" value="Varian*" />
                        <JetInput
                            :id="`name[${index}]`"
                            v-model="form.variants[index].name"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="name"
                        />
                        <JetInputError :message="form.errors[`variants.${index}.name`]" class="mt-2" />
                    </div>
                    <!-- End variants name -->

                    <!-- Price -->
                    <div class="mb-4">
                        <JetLabel :for="`price[${index}]`" value="Harga*" />
                        <JetInput
                            :id="`price[${index}]`"
                            v-model="form.variants[index].price"
                            type="number"
                            class="mt-1 block w-full"
                            autocomplete="price"
                        />
                        <JetInputError :message="form.errors[`variants.${index}.price`]" class="mt-2" />
                    </div>

                    <!-- Stok -->
                    <div class="mb-4">
                        <JetLabel :for="`stock[${index}]`" value="Stok*" />
                        <JetInput
                            :id="`stock[${index}]`"
                            v-model="form.variants[index].stock"
                            type="number"
                            class="mt-1 block w-full"
                            autocomplete="stock"
                        />
                        <JetInputError :message="form.errors[`variants.${index}.stock`]" class="mt-2" />
                    </div>
                </template>

            </template>

            <div class="flex justify-end">
                <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" v-text="'Simpan'" />
            </div>
        </form>
    </StoreLayout>
</template>