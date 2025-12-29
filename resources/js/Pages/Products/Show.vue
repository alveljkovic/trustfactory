<template>
  <div>
        <Head :title="'Product - ' + product.name" />

        <AuthenticatedLayout :cart-details="usePage().props.cartDetails">
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    {{ product.name }}
                </h2>
            </template>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white rounded shadow p-6">
                        <div>
                            <h1 class="text-2xl font-bold mb-4">{{ product.name }}</h1>
                            <p class="text-gray-700 mb-2">Price: {{ format(product.price) }}</p>

                            <div class="flex items-center mb-4">
                                <label for="quantity" class="mr-2 font-semibold">Quantity:</label>
                                <input
                                    id="quantity"
                                    type="number"
                                    v-model.number="quantity"
                                    min="1"
                                    :max="product.stock_quantity"
                                    class="border rounded px-2 py-1 w-20"
                                />
                            </div>

                            <button
                                @click="addToCart"
                                :disabled="quantity < 1 || quantity > product.stock_quantity"
                                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 disabled:opacity-50"
                            >
                                Add to Cart
                            </button>

                            <ToastMessage v-if="toast" :message="toast.message" :type="toast.type" />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import { Link, router, usePage, Head } from '@inertiajs/vue3'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import ToastMessage from '@/Components/Partials/ToastMessage.vue';
    import { useCurrency } from '@/Global/currencyFormat'

    const product = usePage().props.product
    const { format } = useCurrency()
    let cartDetails = usePage().props.cartDetails;
    let quantity = ref(1)
    let message = ref('')
    let loading = ref(false)
    let toast = ref(null)

    const addToCart = async () => {
        loading.value = true

        router.post(
            route('cart.store'),
            {
                product_id: product.id,
                quantity: quantity.value,
            },
            {
                preserveScroll: true,

                onSuccess: () => {
                    loading.value = false
                    quantity.value = 1

                    toast.value = { message: 'Product added to cart successfully', type: 'success' }
                    setTimeout(() => toast.value = null, 3000)
                },

                onError: (errors) => {
                    loading.value = false

                    Object.entries(errors).forEach(([key, message]) => {
                        toast.value = { message: message, type: 'error' }
                        setTimeout(() => toast.value = null, 3000)
                    })
                },

                onFinish: () => {
                    loading.value = false
                    cartDetails = usePage().props.cartDetails;
                },
            }
        )
    }
</script>