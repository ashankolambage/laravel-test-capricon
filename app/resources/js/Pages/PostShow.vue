<script setup>
import { defineProps, computed } from 'vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    post: Object,
});

const defaultImage = "/uploads/blog/default-post-image.jpg";
const imageSrc = computed(() => {
    return props.post.image ? `/uploads/blog/${props.post.image}` : defaultImage;
});
</script>

<template>
    <Head title="Post Details" />

    <HomeLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Post Details</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-3xl font-bold mb-4">{{ props.post.title }}</h1>

                        <img :src="imageSrc" alt="Post Image" class="mb-4 w-full max-w-lg h-auto rounded-lg shadow-lg object-cover">

                        <div v-html="props.post.content" class="prose lg:prose-xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </HomeLayout>
</template>

<style scoped>
.prose {
    max-width: none;
}
</style>
