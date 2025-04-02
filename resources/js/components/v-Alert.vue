<template>

    <div class="flex justify-between mb-2 border-l-4 rounded px-4 py-3" :class="wrapperColor" role="alert">

        <div class="flex items-center">
            <svg class="fill-current h-6 mr-4"  :class="svgColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path v-if="type === 'info'" d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />

                <path v-if="type === 'warning'" d="M19.6,15.4L12,2.3c-0.4-0.7-1.2-1.2-2-1.2c-0.8,0-1.6,0.4-2,1.2L0.4,15.4C0,16.1,0,17,0.4,17.7s1.2,1.2,2,1.2h15.2 c0.8,0,1.6-0.4,2-1.2C20,17,20,16.1,19.6,15.4z M18.6,17.1c-0.2,0.4-0.6,0.6-1,0.6H2.4c-0.4,0-0.8-0.2-1-0.6s-0.2-0.8,0-1.2L9,2.9 c0.2-0.4,0.6-0.6,1-0.6c0.4,0,0.8,0.2,1,0.6L18.6,16C18.8,16.3,18.8,16.8,18.6,17.1z"/>
                <rect v-if="type === 'warning'" x="9.4" y="6.9" width="1.2" height="5.8"/>
                <path v-if="type === 'warning'" d="M10,13.9c-0.4,0-0.8,0.3-0.8,0.8c0,0.4,0.3,0.8,0.8,0.8c0.4,0,0.8-0.3,0.8-0.8C10.8,14.2,10.4,13.9,10,13.9z"/>

                <path v-if="type === 'success'" d="M19.5,2.7c-0.3-0.3-0.8-0.3-1.1,0l-9,9L6,8.2c-0.3-0.3-0.8-0.3-1.1,0C4.6,8.5,4.6,9,4.9,9.3l3.8,4.1 c0.1,0.2,0.3,0.2,0.5,0.2l0,0c0.2,0,0.4-0.1,0.5-0.2l9.6-9.6C19.7,3.5,19.7,3,19.5,2.7z"/>
                <path v-if="type === 'success'" d="M19.3,9.2c-0.4,0-0.8,0.3-0.8,0.8c0,4.7-3.8,8.5-8.5,8.5S1.5,14.7,1.5,10S5.3,1.5,10,1.5c0.4,0,0.8-0.3,0.8-0.8 S10.4,0,10,0C4.5,0,0,4.5,0,10s4.5,10,10,10s10-4.5,10-10C20,9.6,19.7,9.2,19.3,9.2z"/>

                <path v-if="type === 'danger'" d="M17 16a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4.01V4a1 1 0 0 1 1-1 1 1 0 0 1 1 1v6h1V2a1 1 0 0 1 1-1 1 1 0 0 1 1 1v8h1V1a1 1 0 1 1 2 0v9h1V2a1 1 0 0 1 1-1 1 1 0 0 1 1 1v13h1V9a1 1 0 0 1 1-1h1v8z"/>
            </svg>
        </div>

        <div class="break-words flex-auto">
            <p class="text-sm">
                {{message}}
            </p>
        </div>

        <div class="flex items-start">
            <div class="cursor-pointer" @click="$emit('remove', id)">
                <svg class="fill-current h-4 w-4 ml-4" :class="svgColor + ' hover:' + wrapperColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z" />
                </svg>
            </div>
        </div>

    </div>

</template>

<script>
export default {
    data() {
        return {
            timeout: null
        }
    },
    props: {
        id: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true,
            validator: (value) => ['info', 'warning', 'success', 'danger'].indexOf(value) !== -1,
        },
        message: {
            type: String,
            required: true
        }
    },
    created() {
        this.timeout = setTimeout(() => {
            this.$emit('remove', this.$props.id)
        }, 10000)
    },
    beforeDestroy() {
        clearTimeout(this.timeout)
    },
    computed: {
        shade() {
            switch (this.type) {
                case 'info':
                    return 'indigo'
                case 'warning':
                    return 'amber'
                case 'success':
                    return 'lime'
                case 'danger':
                    return 'orange'
                default:
                    return 'indigo'
            }
        },
        wrapperColor() {
            return `bg-${this.shade}-100 text-${this.shade}-900 border-${this.shade}-500`
        },
        svgColor() {
            return `text-${this.shade}-500`
        },
    },
}
</script>
