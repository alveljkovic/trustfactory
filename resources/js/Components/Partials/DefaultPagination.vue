<template>
    <div class="mt-6 flex justify-center space-x-2">
        <Link
            v-if="products.prev_page_url"
            :href="products.prev_page_url"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
        >
            Previous
        </Link>

        <span class="px-4 py-2">{{ products.current_page }} / {{ products.last_page }}</span>

        <Link
            v-if="products.next_page_url"
            :href="products.next_page_url"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
        >
            Next
        </Link>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        products: {
            type: Object,
            required: true
        },
    })
    const products = props.products
</script>
