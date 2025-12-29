export function useCurrency() {
    const format = (amount, currency = 'USD') => {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency,
        }).format(amount)
    }

    return { format }
}
