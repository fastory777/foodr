<template>
    <div v-if="show" class="fixed bottom-6 right-6 z-50">
        <div class="bg-white p-4 rounded-xl shadow-lg w-80 animate-slide-up relative border border-gray-200">
            <button
                @click="$emit('close')"
                class="absolute top-2 right-3 text-gray-400 hover:text-black text-lg cursor-pointer"
            >
                ✖
            </button>
            <img
                src="/storage/app/public/assets/chef.png"
                alt="Chef"
                class="w-90 mt-7"
            />
            <h2 class="text-xl font-bold mb-1 dark:text-gray-700">Tired of choosing a recipe?</h2>
            <p class="text-base text-gray-600">Try our AI assistant — get a tasty dinner idea in seconds!</p>
            <form @submit.prevent="askAi" class="mt-4">
                <label class="block text-sm text-gray-600 mb-1">Describe your mood or craving:</label>
                <input
                    v-model="userInput"
                    type="text"
                    class="w-full border border-gray-300 rounded-md p-2 mb-2 text-sm focus:ring focus:ring-blue-200 dark:text-gray-900"
                    placeholder="I want something warm and spicy..."
                />
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2 text-sm"
                    :disabled="loading"
                >
                    {{ loading ? 'Thinking and cooking...' : 'Ask AI' }}
                </button>
            </form>

            <div v-if="response && !loading" class="mt-3 text-sm text-gray-800">
                <strong>AI Suggestion:</strong>
                <p>{{ response }}</p>
            </div>

            <div v-if="error" class="mt-2 text-sm text-red-600 italic">
                {{ error }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            loading: false,
            userInput: '',
            response: null,
            error: null,
        }
    },
    methods: {
        askAi() {
            if (!this.userInput.trim()) return;
            this.loading = true;
            this.response = null;
            this.error = null;

            setTimeout(() => {
                fetch('http://localhost:8000/recommend', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ mood: this.userInput })
                })
                    .then(res => {
                        if (!res.ok) throw new Error('AI error');
                        return res.json();
                    })
                    .then(data => {
                        this.response = data.recommendation;
                    })
                    .catch(err => {
                        console.error(err);
                        this.error = 'Oops! Something went wrong while talking to the AI.';
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }, 1500);
        }
    }
}
</script>

<style scoped>
@keyframes slideUp {
    from {
        opacity: 1;
        transform: translateY(300px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-slide-up {
    animation: slideUp 0.8s ease-out;
}
</style>
