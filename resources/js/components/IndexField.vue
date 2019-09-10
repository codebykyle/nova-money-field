<template>
    <span class="money font-semibold" :class="colorClass">
        {{ formattedValue }}
    </span>
</template>

<script>
    import CurrencyFieldMixin from './mixin';

    export default {
        props: ['resourceName', 'field'],
        mixins: [CurrencyFieldMixin],
    }
</script>
