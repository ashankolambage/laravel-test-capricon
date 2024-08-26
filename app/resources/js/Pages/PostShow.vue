<script setup>
import { defineProps, computed, ref } from 'vue';
import HomeLayout from '@/Layouts/HomeLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: Object,
    authUser: Object,
});

const defaultImage = "/uploads/blog/default-post-image.jpg";
const imageSrc = computed(() => {
    return props.post.image ? `/uploads/blog/${props.post.image}` : defaultImage;
});

const form = useForm({
    content: ''
});

const submitComment = () => {
    form.post(`/posts/${props.post.id}/comments`, {
        onSuccess: () => {
            form.reset('content');
        }
    });
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) + ' ' +
           date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
};
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

                        <div v-html="props.post.content" class="prose lg:prose-xl mb-8"></div>
                        <div class="comments-section">
                            <h3 class="text-2xl font-semibold mb-4">Comments</h3>

                            <div v-if="props.post.comments && props.post.comments.length > 0">
                                <div v-for="comment in props.post.comments" :key="comment.id" class="mb-4">
                                    <strong>{{ comment.user.name }}</strong>:
                                    <p>{{ comment.content }}</p>
                                    <small class="text-gray-500">{{ formatDate(comment.created_at) }}</small>
                                </div>
                            </div>
                            <div v-else>
                                <p>No comments yet. Be the first to comment!</p>
                            </div>
                            
                            <div v-if="$page.props.auth.user">
                                <form @submit.prevent="submitComment">
                                    <textarea
                                        v-model="form.content"
                                        class="w-full p-2 border rounded mb-4"
                                        placeholder="Add your comment..."
                                        required
                                    ></textarea>
                                    <button
                                        type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded"
                                        :disabled="form.processing"
                                    >Submit</button>
                                </form>
                            </div>
                            <div v-else>
                                <p class="text-gray-500">You must be logged in to comment.</p>
                            </div>
                        </div>
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
