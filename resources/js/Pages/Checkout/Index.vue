<template>
    <div>
        <Head title="Checkout" />

        <AuthenticatedLayout :cart-details="usePage().props.cartDetails">
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Checkout
                </h2>
            </template>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white rounded shadow p-6">
                        <div v-if="items.length === 0" class="text-gray-500">
                            Your cart is empty.
                        </div>

                        <div v-else class="space-y-4">
                            <div>
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="p-4">Product</th>
                                            <th class="p-4 text-center">Quantity</th>
                                            <th class="p-4 text-right">Price</th>
                                            <th class="p-4 text-right">Subtotal</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr
                                            v-for="item in items"
                                            :key="item.id"
                                            class="border-t"
                                        >
                                            <td class="p-4">
                                            {{ item.product.name }}
                                            </td>

                                            <td class="p-4 text-center">
                                            {{ item.quantity }}
                                            </td>

                                            <td class="p-4 text-right">
                                            {{ format(item.product.price) }}
                                            </td>

                                            <td class="p-4 text-right font-medium">
                                            {{ format(item.quantity * item.product.price) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- TOTAL -->
                                <div class="flex justify-end p-6 border-t bg-gray-50">
                                    <div class="text-right">
                                        <p class="text-lg">
                                            Total:
                                            <span class="font-bold">
                                                {{ format(subtotal) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <!-- ACTIONS -->
                                <div class="flex justify-between items-center mt-8">
                                    <Link
                                        :href="route('products.index')"
                                        class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 transition"
                                    >
                                        Continue Shopping
                                    </Link>

                                    <button
                                        @click="processOrder"
                                        :disabled="!cart.items.length"
                                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-50"
                                    >
                                        Seal the Deal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
    import { computed, ref } from 'vue'
    import { router, usePage, Link, Head } from '@inertiajs/vue3'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useCurrency } from '@/Global/currencyFormat'
    import ToastMessage from '@/Components/Partials/ToastMessage.vue';

    const cart = computed(() => usePage().props.cartSummary)
    const items = computed(() => cart.value.items)
    const subtotal = computed(() => cart.value.subtotal)
    const { format } = useCurrency()
    let loading = ref(false)
    let toast = ref(null)

    const processOrder = () => {
        loading.value = true

        router.post(
            route('order.process'),
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    loading.value = false
                    toast.value = { message: 'Order successfully placed!', type: 'success' }
                    setTimeout(() => toast.value = null, 3000)
                },
                onError: (errors) => {
                    loading.value = false
                    toast.value = { message: 'Something went wrong with your order!', type: 'error' }
                    setTimeout(() => toast.value = null, 3000)
                },
            }
        )
    }
</script>