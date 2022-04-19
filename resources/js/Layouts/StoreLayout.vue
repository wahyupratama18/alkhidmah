<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import InvertButton from '@/Jetstream/InvertButton.vue';
import route from '../../../vendor/tightenco/ziggy/src/js';

defineProps({
    title: String
});

const showingNavigationDropdown = ref(false);

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && showingNavigationDropdown.value == true) {
        showingNavigationDropdown.value = false;
    }
}

onMounted(() => {
    document.addEventListener('keydown', closeOnEscape)
})

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape)
    document.body.style.overflow = null
})

const logout = () => {
    Inertia.post(route('logout'))
}

const form = useForm({
    search: null
})

const searching = () => {
    if (form.search != null && form.search != undefined) {
        form.get(route('search'), {
            preserveScroll: true
        })
    }
}

const admin = (user) => {
    return user && user.is_admin
}
</script>

<template>
    <div>
        <Head :title="title" />

        <!-- Header -->
        <header class="w-full fixed top-0 z-20 mx-auto flex h-20 shadow-md bg-white">
            <!-- Left Nav -- logo -->
            <div class="flex items-center py-2 px-4 pr-3">
                <JetAuthenticationCardLogo />
            </div>
            <!-- End left nav -->

            <!-- Right Nav [Ex: bg-gradient-to-br from-khidmah to-khidmah/90 rounded-bl-[5rem] ] -->
            <div class="flex items-center justify-center px-8 flex-grow text-khidmah">

                <!-- Search box -->
                <div class="hidden sm:flex items-center pl-4 grow justify-center h-full">
                    <JetNavLink :href="route('category.index')" class="text-sm mr-4" v-if="!admin($page.props.user)">Kategori</JetNavLink>
                    
                    <form class="relative rounded-md shadow-md" @submit.prevent="searching" v-if="!admin($page.props.user)">
                        <!-- <slot name="big" /> -->
                        <JetInput
                            type="text"
                            v-model="form.search"
                            class="lg:w-96 md:w-80 py-1"
                            placeholder="Cari kitab" />
                        <div class="absolute inset-y-0 right-0 flex items-center h-full">
                            <JetButton
                                type="submit"
                                class="h-full bg-khidmah/80 hover:bg-khidmah/70 focus:bg-khidmah/60 text-white"
                                v-html="'<i class=\'mdi mdi-magnify mdi-18px\' />'" />
                        </div>
                    </form>

                    <div v-else class="space-x-8 sm:-my-px sm:ml-10 sm:flex h-full">
                        <JetNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </JetNavLink>

                        <JetNavLink :href="route('categories.index')" :active="route().current('categories.index')">
                            Daftar Kategori
                        </JetNavLink>
                    </div>
                </div>
                <!-- End search box -->

                <!-- carts and user account etc -->
                <div class="hidden lg:flex items-between md:ml-4 font-medium divide-x divide-khidmah gap-x-3">
                    <Link
                    v-if="!admin($page.props.user)"
                    :href="route('carts')"
                    v-html="'<i class=\'mdi mdi-shopping mdi-18px\' />'"
                    />
                    
                    <!-- Login / Registration -->
                    <div class="flex gap-x-3 pl-3" v-if="!$page.props.user">
                        <Link :href="route('login')">
                            <InvertButton
                                type="button"
                                v-text="'Masuk'"
                                />
                        </Link>

                        <Link :href="route('register')">
                            <JetButton type="button" v-text="'Daftar'" />
                        </Link>
                    </div>
                    <!-- End Login / Registration -->

                    <!-- Authenticated -->
                    <JetDropdown align="right" width="48" v-else>
                        <template #trigger>
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition">
                                <img
                                    v-if="$page.props.jetstream.managesProfilePhotos"
                                    class="h-8 w-8 rounded-full object-cover"
                                    :src="$page.props.user.profile_photo_url"
                                    :alt="$page.props.user.name"
                                >

                                {{ $page.props.user.name }}

                                <svg
                                    class="ml-2 -mr-0.5 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                    

                                    <svg
                                        class="ml-2 -mr-0.5 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span> -->
                        </template>

                        <template #content>
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Manage Account
                            </div>

                            <JetDropdownLink :href="route('profile.show')">
                                Profile
                            </JetDropdownLink>

                            <JetDropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                API Tokens
                            </JetDropdownLink>

                            <div class="border-t border-gray-100" />

                            <!-- Authentication -->
                            <form @submit.prevent="logout">
                                <JetDropdownLink as="button">
                                    Log Out
                                </JetDropdownLink>
                            </form>
                        </template>
                    </JetDropdown>
                    <!-- End Authenticated  -->

                </div>
                <!-- End carts and user account -->

                <!-- Mini Hamburger -->
                <div class="flex lg:hidden ml-4 md:ml-0">
                    <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-khidmah hover:bg-foreground focus:outline-none focus:bg-foreground focus:text-khidmah transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown}"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown}"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
                <!-- End Mini Hamburger -->
            </div>
            <!-- End right nav -->

        </header>
        <!-- End header -->

        <transition leave-active-class="duration-200">
            <div v-show="showingNavigationDropdown" class="fixed inset-0 overflow-y-auto z-10" scroll-region>
                <transition enter-active-class="ease-out duration-300"
                        enter-from-class="opacity-0"
                        enter-to-class="opacity-100"
                        leave-active-class="ease-in duration-200"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0">
                    <div v-show="showingNavigationDropdown" class="fixed inset-0 transform transition-all z-10" @click="close">
                        <div class="absolute inset-0 bg-darken opacity-75"></div>
                    </div>
                </transition>

                <transition enter-active-class="ease-in-out duration-1000"
                        enter-from-class="transform -translate-x-full"
                        enter-to-class="transform transform-x-0"
                        leave-active-class="ease-in-out duration-1000"
                        leave-from-class="transform transform-x-0"
                        leave-to-class="transform -translate-x-full">
                    <div v-show="showingNavigationDropdown" class="fixed top-0 bottom-0 bg-gradient-to-br from-khidmah to-khidmah/80 text-white w-64 transform transition-all z-10 mt-20 pt-4">
                        <slot name="responsive" />
                        testing
                    </div>
                </transition>
            </div>
        </transition>

        <!-- Main view -->
        <main class="mt-20 bg-pattern min-h-screen">
            <slot />
        </main>
        <!-- End Main View -->
        
        <!-- Footer -->
        <footer class="bg-foreground/75 p-8">
            <div class="grid md:grid-cols-3">
                <div class="my-3">
                    <!-- <div class="flex items-center mb-4"> -->
                        <!-- <img src="storage/alkhidmah.png" class="w-[65px] h-[65px]"> -->
                        <p class="text-khidmah text-sm font-bold mb-4">
                            Koperasi Jama'ah Al Khidmah<br>
                            PD Kota Malang
                        </p>
                    <!-- </div> -->

                    <Link :href="route('about')" class="font-medium text-khidmah">
                        <i class="mdi mdi-chevron-right" /> Tentang
                    </Link>
                </div>
            </div>
        </footer>
        <!-- End Footer -->
    </div>
</template>