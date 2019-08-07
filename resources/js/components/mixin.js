export default {
    computed: {
        formattedValue() {
            if (this.field.value === undefined || this.field.value === null) {
                return '-';
            }

            return this.field.value.toLocaleString(this.field.locale, {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        },

        colorClass() {
            return this.field.color
        }
    }
}
