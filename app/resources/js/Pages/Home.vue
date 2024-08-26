<script setup>
import { defineProps } from 'vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    posts: Array,
});
</script>

<template>
    <Head title="Home" />

    <HomeLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Home</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">See the blog list</div>
                    <ul class="p-6">
                        <li v-for="post in props.posts" :key="post.id" class="border-b py-4">
                            <a :href="'/posts/' + post.slug" class="text-blue-600 hover:underline">
                                {{ post.title }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </HomeLayout>
</template>
