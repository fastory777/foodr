<template>
    <section class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
        <div class="max-w-xl">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray 900 dark:text-white">
                    Comments ({{ comments ? comments.length : 0 }})
                </h2>

                <button @click="loadComments">
                    <refresh-ccw class="w-6 h-6 text-gray-500 dark:text-gray-300 cursor-pointer"/>
                </button>

            </div>

            <form class="mb-6" @submit.prevent="submitComment">
                <div class="mb-2">
                    <input
                        v-model="form.author_name"
                        type="text"
                        placeholder="Your name"
                        class="w-full p-2 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                    />

                    <p v-if="errors.author_name" class="text-red-500 text-sm mt-2">
                        {{ errors.author_name[0] }}
                    </p>
                </div>

                <div class="py-2 px-4 mb-4 mt-3 bg-white rounded-lg border dark:bg-gray-800 dark:border-gray-700">
                    <label for="comment" class="sr-only">Comment</label>
                    <textarea
                        v-model="form.content"
                        id="comment"
                        rows="4"
                        placeholder="Post a comment..."
                        class="w-full text-sm text-gray-900 border-0 focus:ring-0 dark:text-white dark:bg-gray-800"
                    ></textarea>
                    <p v-if="errors.content" class="text-red-500 text-sm">
                        {{ errors.content[0] }}
                    </p>
                </div>

                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700 cursor-pointer"
                >
                    Send comment
                </button>
            </form>

            <div v-if="loading" class="text-gray-500">Loading comments...</div>

            <article
                v-for="comment in comments"
                :key="comment.id"
                class="p-6 mb-3 text-base bg-white rounded-lg dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700"
            >
                <footer class="flex justify-between items-center mb-2">
                    <div>
                        <p class="inline-flex items-center mr-3 text-sm font-semibold text-gray-900 dark:text-white">
                            <img
                                class="mr-2 w-6 h-6 rounded-full"
                                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                alt="avatar"
                            />
                            {{ comment.author_name }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ formatDate(comment.created_at) }}
                        </p>
                    </div>
                    <div class="relative">
                        <button @click="toggleMenu(comment.id)"
                                class="cursor-pointer">
                            <EllipsisVertical class="w-5 h-5 text-gray-500 dark:text-gray-300"/>
                        </button>

                        <div
                            v-if="openMenuId === comment.id"
                            class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-800 border rounded shadow z-10"
                        >
                            <button
                                @click="editComment(comment)"
                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                Edit
                            </button>
                            <button
                                @click="deleteComment(comment.id)"
                                class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </footer>
                <p class="text-gray-500 dark:text-gray-200">{{ comment.content }}</p>
            </article>
        </div>
    </section>
</template>

<script>
import axios from 'axios'
import {RefreshCcw, EllipsisVertical} from "lucide-vue-next";

export default {
    components: {
        RefreshCcw,
        EllipsisVertical,
    },
    name: 'DishComments',
    props: {
        dish: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            comments: [],
            loading: true,
            form: {
                dish_id: this.dish.id,
                author_name: '',
                content: '',
            },
            errors: {},
            openMenuId: null,
        }
    },
    methods: {
        async loadComments() {
            this.loading = true
            try {
                const response = await axios.get(`/api/comments?dish_id=${this.dish.id}`)
                this.comments = response.data.data ?? response.data
            } catch (error) {
                console.error('Loading comments failed', error)
            } finally {
                this.loading = false
            }
        },
        async submitComment() {
            try {
                const response = await axios.post('/api/comments', this.form)
                console.log('RESPONSE:', response);
                this.comments.unshift(response.data);
                console.log('ALL COMMENTS:', this.comments);
                this.form.content = ''
                this.form.author_name = ''
                this.errors = {}
            } catch (error) {
                if (error.response?.status === 422) {
                    this.errors = error.response.data.errors
                }
            }
        },
        async deleteComment(id) {
            if (!confirm('Are you sure you want to delete this comment?')) return
            try {
                await axios.delete(`/api/comments/${id}`)
                this.comments = this.comments.filter(comment => comment.id !== id)
            } catch (error) {
                console.error('Deleting comment failed', error)
            }
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString()
        },
        toggleMenu(id) {
            this.openMenuId = this.openMenuId === id ? null : id
        },
        closeMenu(id) {
            if (this.openMenuId === id) this.openMenuId = null
        },
        editComment(comment) {
            alert('Edit: ' + comment.id)
        }
    },
    mounted() {
        this.loadComments()
    }
}
</script>


