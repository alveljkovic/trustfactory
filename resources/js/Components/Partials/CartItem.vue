<template>
    <div class="flex items-center justify-between border p-4 rounded">
        <div>
            <h2 class="font-semibold">
                {{ item.product.name }}
            </h2>

            <p class="text-sm text-gray-600">
                Price: {{ format(item.product.price) }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <input
                type="number"
                min="1"
                :value="item.quantity"
                @change="updateQuantity(item.product.id, $event.target.value)"
                class="w-20 border rounded px-2 py-1"
            />

            <button
                @click="removeItem(item.product.id)"
                class="text-red-600 text-sm"
            >
                Remove
            </button>
        </div>

        <div class="font-semibold">
            {{ format(item.product.price * item.quantity) }}
        </div>

        <ToastMessage v-if="toast" :message="toast.message" :type="toast.type" />
    </div>
</template>

<script setup>
    import { router, usePage } from '@inertiajs/vue3'
    import ToastMessage from '@/Components/Partials/ToastMessage.vue';
    import { ref } from 'vue'
    import { useCurrency } from '@/Global/currencyFormat'

    const props = defineProps({
        item: {
            type: Object,
            required: true
        },
    })

    const { format } = useCurrency()
    let toast = ref(null)
    const loading = ref(false)
    const quantity = ref(props.item.quantity)

    const updateQuantity = (productId, newQuantity) => {
        router.patch(route('cart.update', productId), {
            quantity: newQuantity
        }, {
            preserveState: true,

            onSuccess: () => {
                loading.value = false
                quantity.value = 1

                toast.value = { message: 'Product quantity updated successfully', type: 'success' }
                setTimeout(() => toast.value = null, 3000)
            },

            onError: (errors) => {
                loading.value = false

                toast.value = { message: 'Failed to update product quantity', type: 'error' }
                setTimeout(() => toast.value = null, 3000)
            },

            onFinish: () => {
                loading.value = false
            },
        })
    }

    const removeItem = (productId) => {
        router.delete(route('cart.destroy', productId, {}), {
            preserveState: true,

            onSuccess: () => {
                loading.value = false

                toast.value = { message: 'Product removed from cart successfully', type: 'success' }
                setTimeout(() => toast.value = null, 3000)
            },

            onError: (errors) => {
                loading.value = false

                toast.value = { message: 'Failed to remove product from cart', type: 'error' }
                setTimeout(() => toast.value = null, 3000)
            },

            onFinish: () => {
                loading.value = false
            },
        })
    }
</script>