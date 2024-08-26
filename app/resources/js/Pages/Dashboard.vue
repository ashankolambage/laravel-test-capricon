<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    posts: Array,
    categories: Array,
});

const selectedCategory = ref('');
const filteredPosts = ref(props.posts);

watch(selectedCategory, (newCategory) => {
    if (newCategory === '') {
        filteredPosts.value = props.posts;
    } else {
        filteredPosts.value = props.posts.filter(post => post.category_id === newCategory);
    }
});

const editPost = (id) => {
    Inertia.visit(`/posts/${id}/edit`);
};

const deletePost = (id) => {
    if (confirm('Are you sure you want to delete this post?')) {
        Inertia.delete(`/posts/${id}`, {
            onSuccess: () => {
                filteredPosts.value = filteredPosts.value.filter(post => post.id !== id);
            },
            onError: () => {
                alert('There was an error deleting the post.');
            }
        });
    }
};
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
                        <div class="mb-4">
                            <select v-model="selectedCategory" class="border px-8 py-2 rounded">
                                <option value="">All Categories</option>
                                <option v-for="category in props.categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>
                        <ul class="p-6">
                            <li v-for="post in filteredPosts" :key="post.id" class="border-b py-4 flex items-center justify-between">
                                <div>
                                    <a :href="'/posts/' + post.slug" class="text-blue-600 hover:underline">
                                        {{ post.title }}
                                    </a>
                                </div>
                                <div>
                                    <button @click="editPost(post.id)" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 mr-2">
                                        Edit
                                    </button>
                                    <button @click="deletePost(post.id)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </div>
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