<template>
    <div v-if="alerts" class="fixed bottom-0 right-0 mr-1 w-1/3 z-50">
        <v-alert
            v-for="alert in alerts"
            :key="alert.id"
            v-bind="alert"
            @remove="removeAlert"
        />
    </div>
</template>

<script>
import VAlert from "@/components/v-Alert.vue";
import {mapActions, mapState} from "vuex";

export default {
    components: {
        VAlert
    },
    computed: mapState('alerts', ['alerts']),
    methods: {
        ...mapActions({
            removeAlert: 'alerts/removeAlert'
        }),
    },
};
</script>
