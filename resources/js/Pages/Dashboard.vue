<template>
    <div>
        <Head title="Dashboard" />
        <AuthenticatedLayout>
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Dashboard
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 text-gray-900">
                            <div v-if="orders.length === 0" class="text-gray-500">
                                Your orders are empty.
                            </div>

                            <div v-else class="space-y-4">
                                <div
                                    v-for="order in orders"
                                    :key="order.id"
                                >
                                    <OrderListItem :order="order" />
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
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, usePage, Link } from '@inertiajs/vue3';
    import OrderListItem from '@/Components/Partials/OrderListItem.vue';

    const orders = usePage().props.orders;
</script>
