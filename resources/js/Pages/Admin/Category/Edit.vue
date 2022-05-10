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
import iziToast from 'izitoast';

const props = defineProps({
    category: Object,
    categories: Array
})

const form = useForm({
    _method: 'PUT',
    name: props.category.name,
    category_id: props.category.category_id,
    description: props.category.description,
    image: null
})

const submitted = () => {
    form.put(route('categories.update', {category: props.category.id}), {
        onSuccess: () => {
            iziToast.success(notifier())
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

            form.image = data.data
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
    <StoreLayout title="Tambah Kategori">
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

            <!-- sub category -->
            <div class="mb-4">
                <JetLabel for="category_id" value="Sub Kategori (apabila ingin nested)" />
                <vSelect
                    v-model="form.category_id"
                    class="mt-1 block w-full"
                    :options="categories"
                    label="name"
                    :reduce="category => category.id" />
                <JetInputError :message="form.errors.category_id" class="mt-2" />
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
                <JetLabel for="image" value="Gambar Baru" />
                <FilePond
                    name="image"
                    ref="pond"
                    accepted-file-types="image/jpeg, image/png"
                    :server="server"
                    :files="form.image"
                />
                <JetInputError :message="form.errors.image" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <JetButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" v-text="'Simpan'" />
            </div>
        </form>
    </StoreLayout>
</template>