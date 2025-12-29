<template>
    <div class="border rounded-lg p-4 shadow hover:shadow-lg transition flex justify-between items-center">
        <h2 class="text-lg font-semibold">
            Order #{{ order.id }} - Total: {{ format(order.total) }}
        </h2>
        <Link
            :href="route('order.show', order)"
            class="no-underline bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
            View Details
        </Link>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import { useCurrency } from '@/Global/currencyFormat'

    const props = defineProps({
        order: {
            type: Object,
            required: true
        }
    })

    const { format } = useCurrency()
</script>
