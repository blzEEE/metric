<template>
    <div v-if="links" class="flex items-center py-4">
        <button v-for="(link, key) in links"
            type="button"
            :key="key"
            @click="paginate(link.url)"
            class="px-4 py-3 mb-1 ml-1 text-sm leading-4 border rounded"
            :class="[
              link.active ?
                'text-white bg-indigo-500/75 font-semibold hover:bg-indigo-500' :
                link.url == null ?
                    'text-gray-400 bg-gray-50 cursor-default' :
                    'hover:bg-white hover:border-indigo-500/75 hover:text-indigo-500',
            ]"
            v-html="link.label"
        />
    </div>
</template>

<script>
export default {
    props: {
        links: {
            type: Object,
        },
    },
    methods: {
        paginate(url) {
            if (url) {
                let params = (new URL(url)).searchParams
                let page = params.get('page')

                this.$emit('paginate', {page: page})
            }
        },
    },
    computed: {

    }
};
</script>
