<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    posts: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg">My Post List</span>
                            <a href="/posts/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create New Post</a>
                        </div>
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
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.prose {
    max-width: none;
}
</style>