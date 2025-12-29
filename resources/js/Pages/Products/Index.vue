<template>
    <div>
        <Head title="Products" />

        <AuthenticatedLayout :cart-details="usePage().props.cartDetails">
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Products
                </h2>
            </template>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white rounded shadow p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            <div
                                v-for="product in products.data"
                                :key="product.id"
                                class="border rounded-lg p-4 shadow hover:shadow-lg transition"
                            >
                                <h2 class="text-lg font-semibold mb-2">{{ product.name }}</h2>
                                <p class="text-gray-700 mb-2">Price: {{ format(product.price) }}</p>

                                <div class="flex space-x-2">
                                    <Link
                                        :href="route('products.show', product.id)"
                                        class="w-full flex justify-center items-center no-underline bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                                    >
                                        View
                                    </Link>
                                    <button
                                        @click="addToCart(product.id)"
                                        :disabled="1 > product.stock_quantity"
                                        class="w-full flex justify-center items-center no-underline bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 disabled:opacity-50"
                                    >
                                        Add to cart
                                    </button>
                                </div>

                                <ToastMessage v-if="toast" :message="toast.message" :type="toast.type" />
                            </div>
                        </div>

                        <!-- Default Laravel Pagination -->
                        <DefaultPagination :products="products" />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
    import { Link, Head, router, usePage } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import DefaultPagination from '@/Components/Partials/DefaultPagination.vue';
    import ToastMessage from '@/Components/Partials/ToastMessage.vue';
    import { useCurrency } from '@/Global/currencyFormat'

    const props = defineProps({
        products: {
            type: Object,
            required: true
        },
    })

    const { format } = useCurrency()
    let cartDetails = usePage().props.cartDetails;
    let quantity = ref(1)
    let loading = ref(false)
    let toast = ref(null)

    const addToCart = async (productId) => {
        loading.value = true

        router.post(
            route('cart.store'),
            {
                product_id: productId,
                quantity: quantity.value,
            },
            {
                preserveScroll: true,

                onSuccess: () => {
                    loading.value = false
                    quantity.value = 1

                    toast.value = { message: 'Added to cart', type: 'success' }
                    setTimeout(() => toast.value = null, 3000)
                },

                onError: (errors) => {
                    loading.value = false
                    toast.value = { message: 'Failed to add to cart', type: 'error' }
                    setTimeout(() => toast.value = null, 3000)
                },

                onFinish: () => {
                    loading.value = false
                    cartDetails = usePage().props.cartDetails;
                },
            }
        )
    }
</script>