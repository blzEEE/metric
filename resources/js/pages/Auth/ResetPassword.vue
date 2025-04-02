<template>
    <div class="mb-4 text-sm text-gray-600">
        Придумайте и введите новый пароль в оба поля ниже.
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
                :disabled="true"
                :error="validationErrors['email']">
                <template #prefix>
                    <UserIcon class="h-6" />
                </template>
            </v-input>

            <v-input
                id="password"
                :type="showingPassword ? 'text' : 'password'"
                v-model="form.password"
                @update:modelValue="showingPassword = (form.password == '' ? false : showingPassword)"
                label="Новый пароль"
                :placeholder="'Придумайте новый пароль'"
                :error="validationErrors['password']">
                <template #prefix>
                    <LockClosedIcon class="h-6" />
                </template>
                <template #suffix>
                    <span v-if="form.password" @click="showingPassword = !showingPassword" class="cursor-pointer" :title="(showingPassword ? 'Скрыть' : 'Показать') + ' пароль'">
                        <EyeIcon v-if="showingPassword" class="h-6" />
                        <EyeSlashIcon v-if="!showingPassword" class="h-6" />
                    </span>
                </template>
            </v-input>

            <v-input
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                label="Подтверждение пароля"
                :placeholder="'Повторите введенный пароль'"
                :disabled="showingPassword"
                :error="validationErrors['password_confirmation']">
                <template #prefix>
                    <LockClosedIcon class="h-6" />
                </template>
            </v-input>

            <div class="flex items-center justify-end mt-4">
                <router-link :to="{ name: 'login', query: { email: form.email }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Вход в систему
                </router-link>
                <v-button
                    type="submit"
                    :color="'dark'"
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Изменить пароль
                </v-button>
            </div>

        </div>

    </form>
</template>
<script>
import { UserIcon, LockClosedIcon, EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/outline"
import VInput from "@/components/v-Input.vue";
import VButton from "@/components/v-Button.vue";
import {mapActions} from "vuex";

export default {
    components: {
        VInput,
        VButton,
        UserIcon,
        LockClosedIcon,
        EyeIcon,
        EyeSlashIcon
    },
    data(){
        return {
            form: {
                email: "",
                password: "",
                password_confirmation: "",
                token: ""
            },
            showingPassword: false,
            processing: false,
            validationErrors: {},
        }
    },
    props: {
        email: {
            type: String
        },
        token: {
            type: String
        },
    },
    mounted() {
        this.form.email = this.$props.email
        this.form.token = this.$props.token
    },
    methods:{
        ...mapActions({
            userResetPassword: 'auth/userResetPassword',
            setAlert: 'alerts/setAlert'
        }),
        submit() {
            this.form.processing = true
            this.validationErrors = {}

            let {email, password, password_confirmation, token} = this.form

            if (this.showingPassword) {
                password_confirmation = password
            }

            this.userResetPassword({email, password, password_confirmation, token})
                .then(({data}) => {
                    this.setAlert({type: 'success', message: data.message})
                    this.$router.push({ name: 'login', query: { email: email }})
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
