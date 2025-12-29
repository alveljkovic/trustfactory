<script setup>
    defineProps({
        message: String,
        type: {
            type: String,
            default: 'success'
        }
    })
</script>

<template>
    <div
        class="fixed top-4 right-4 px-4 py-2 rounded shadow text-white"
        :class="type === 'success' ? 'bg-green-600' : 'bg-red-600'"
    >
        {{ message }}
    </div>
</template>
