import numbro from 'numbro';
import numbroLanguages from 'numbro/dist/languages.min';
Object.values(numbroLanguages).forEach(l => numbro.registerLanguage(l));

export default {
    mounted() {
        if (Nova.config.locale) {
            numbro.setLanguage(Nova.config.locale.replace('_', '-'))
        }
    },
    computed: {
        formattedValue() {
            console.log({
                value: this.value,
                isNull: this.isNullValue,
                format: this.format,
                prefix: this.prefix,
                numbro: numbro(this.value),
                final: this.prefix + numbro(this.value).format(this.format)

            });

            if (!this.isNullValue) {
                return this.prefix + numbro(new String(this.value)).format(this.format)
            }

            return ''
        },

        isNullValue() {
            return this.value == null
        },

        value() {
            return this.field.value
        },

        prefix() {
            return '$'
        },

        format() {
            return '(0,000.00)';
        },

        colorClass() {
            return this.field.color
        },
    }
}
