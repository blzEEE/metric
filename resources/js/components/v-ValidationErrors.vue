<template>
    <div v-if="hasErrors" class="border-l-4 rounded-md px-4 py-2 mb-4 bg-red-100 text-red-900 border-red-500">
        <div class="font-medium">Ой! При заполнении формы есть ошибки:</div>

        <ul class="mt-2 list-disc list-inside text-sm">
            <li v-for="(error, key) in errors" :key="key">{{ error[0] }}</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        errors: {
            type: Object
        }
    },
    computed: {
        hasErrors() {
            return Object.keys(this.$props.errors).length > 0
        }
    }
}
</script>
