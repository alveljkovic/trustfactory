<template>
    <div>
        <Head title="Checkout" />

        <AuthenticatedLayout :cart-details="usePage().props.cartDetails">
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Order Details
                </h2>
            </template>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white rounded shadow p-6">
                        <div class="space-y-4">
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
                                            v-for="item in order.items"
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
                                            Total paid:
                                            <span class="font-bold">
                                                {{ format(order.total) }}
                                            </span>
                                        </p>
                                    </div>
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
    import { router, usePage, Link, Head } from '@inertiajs/vue3'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useCurrency } from '@/Global/currencyFormat'

    const order = usePage().props.order;
    const { format } = useCurrency()
</script>