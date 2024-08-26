<template>
    <Head title="Post Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post Create</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-3xl font-bold mb-4">Create a New Post</h1>

                        <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-4">
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input
                                    type="text"
                                    id="title"
                                    v-model="form.title"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                />
                            </div>

                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                                <textarea
                                    id="content"
                                    v-model="form.content"
                                    rows="6"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                ></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select
                                    id="category"
                                    v-model="form.category_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                >
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Image (Optional)</label>
                                <input
                                    type="file"
                                    id="image"
                                    @change="handleImageUpload"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border file:rounded-md file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                />
                            </div>

                            <div>
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Create Post
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';

const form = ref({
    title: '',
    content: '',
    category_id: '',
    image: null
});

const categories = ref([]);


const submitForm = async () => {
    try {
        const formData = new FormData();
        formData.append('title', form.value.title);
        formData.append('content', form.value.content);
        formData.append('category_id', form.value.category_id);
        if (form.value.image) {
            formData.append('image', form.value.image);
        }

        const response = await axios.post('/posts', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        alert('Post created successfully!');
        resetForm();
    } catch (error) {
        console.error(error);
        alert('There was an error creating the post.');
    }
};

const handleImageUpload = (event) => {
    form.value.image = event.target.files[0];
};

const resetForm = () => {
    form.value = {
        title: '',
        category_id: '',
        content: '',
        image: null
    };
};

onMounted(async () => {
    const response = await fetch('/categories/get-categories');
    categories.value = await response.json();
});
</script>