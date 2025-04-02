<template>
    <div class="mb-4 text-sm text-gray-600">
        Укажите свой адрес электронной почты, на него будет отправлена ссылка для смены пароля.
    </div>

    <form @submit.prevent="submit">

        <div class="grid grid-cols-1 gap-4">

            <v-input
                id="email"
                type="email"
                v-model="form.email"
                label="Адрес электронной почты (e-mail)"
                :placeholder="'Введите свой e-mail'"
                :autocomplete="'username'"
                :autofocus="true"
                :error="validationErrors['email']">
                <template #prefix>
                    <UserIcon class="h-6" />
                </template>
            </v-input>

            <div class="flex items-center justify-end mt-4">
                <router-link :to="{ name: 'login', query: { email: form.email }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Вход в систему
                </router-link>
                <v-button type="submit" :color="'dark'" class="ml-4" :disabled="form.processing">
                    Восстановить доступ
                </v-button>
            </div>

        </div>

    </form>
</template>
<script>
import VInput from "@/components/v-Input.vue"
import VButton from "@/components/v-Button.vue"
import { UserIcon } from "@heroicons/vue/24/outline"
import {mapActions} from "vuex"

export default {
    components: {
        VInput,
        VButton,
        UserIcon},
    data(){
        return {
            form: {
                email: "",
                processing: false
            },
            validationErrors: {},
        }
    },
    props: {
        email: {
            type: String
        }
    },
    mounted() {
        this.form.email = this.$props.email
    },
    methods: {
        ...mapActions({
            userForgotPassword: 'auth/userForgotPassword',
            setAlert: 'alerts/setAlert'
        }),
        submit() {
            this.form.processing = true
            this.validationErrors = {}

            this.userForgotPassword(this.form)
                .then(({data}) => {
                    this.setAlert({type: 'info', message: data.message})
                })
                .catch(({response}) => {
                    if (response.status === 422) {
                        this.validationErrors = response.data.errors
                    } else {
                        this.setAlert({type: 'danger', message: response.data.message})
                    }
                })
                .finally(() => {
                    this.form.processing = false
                })
        },
    }
}
</script>
