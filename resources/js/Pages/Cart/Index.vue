<template>
    <div>
        <Head title="My Cart" />

        <AuthenticatedLayout :cart-details="usePage().props.cartDetails">
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    My Cart
                </h2>
            </template>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white rounded shadow p-6">
                        <div v-if="items.length === 0" class="text-gray-500">
                            Your cart is empty.
                        </div>

                        <div v-else class="space-y-4">
                            <div
                                v-for="item in items"
                                :key="item.id"
                            >
                                <CartItem :item="item" />
                            </div>

                            <div class="flex justify-between items-center border-t pt-4 mt-6">
                                <span class="text-xl font-bold">Total</span>
                                <span class="text-xl font-bold">
                                    {{ format(subtotal) }}
                                </span>
                            </div>

                            <div class="text-right pt-6">
                                <Link
                                    :href="route('checkout.index')"
                                    class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700"
                                >
                                    Checkout
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
    import { computed } from 'vue'
    import { router, usePage, Link, Head } from '@inertiajs/vue3'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import CartItem from '@/Components/Partials/CartItem.vue';
    import { useCurrency } from '@/Global/currencyFormat'

    const page = usePage()
    const cart = computed(() => page.props.cartSummary)
    const items = computed(() => cart.value.items)
    const subtotal = computed(() => cart.value.subtotal)
    const { format } = useCurrency()
</script>