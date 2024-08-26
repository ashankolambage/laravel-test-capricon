<script setup>
import { defineProps, ref, watch } from 'vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { Head } from '@inertiajs/vue3';

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
                    <div class="p-6 text-gray-900">
                        <div class="mb-4">
                            <select v-model="selectedCategory" class="border px-8 py-2 rounded">
                                <option value="">All Categories</option>
                                <option v-for="category in props.categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>

                        <ul class="p-6">
                            <li v-for="post in filteredPosts" :key="post.id" class="border-b py-4">
                                <a :href="'/posts/' + post.slug" class="text-blue-600 hover:underline">
                                    {{ post.title }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </HomeLayout>
</template>
