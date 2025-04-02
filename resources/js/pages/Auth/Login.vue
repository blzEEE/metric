<template>

    <form @submit.prevent="submit">

        <div class="grid grid-cols-1 gap-4 mt-2">

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

            <v-input
                id="password"
                :type="showingPassword ? 'text' : 'password'"
                v-model="form.password"
                @update:modelValue="showingPassword = (form.password == '' ? false : showingPassword)"
                label="Пароль"
                :placeholder="'Введите пароль'"
                :autocomplete="'current-password'"
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

            <div class="block">
                <v-checkbox name="remember" v-model:checked="form.remember">
                    Запомнить меня
                </v-checkbox>
            </div>

            <div class="flex items-center justify-end">
                <router-link :to="{ name: 'forgot-password', query: { email: form.email }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Забыли пароль?
                </router-link>

                <v-button
                    type="submit"
                    :color="'dark'"
                    class="ml-4"
                    :class="{ 'opacity-25': processing }"
                    :disabled="processing">
                    Войти
                </v-button>
            </div>

        </div> <!--grid-->

    </form>

</template>


<script>
import { mapActions } from 'vuex'
import { UserIcon, LockClosedIcon, EyeIcon, EyeSlashIcon } from "@heroicons/vue/24/outline"
import VInput from "@/components/v-Input.vue"
import VCheckbox from "@/components/v-Checkbox.vue"
import VButton from "@/components/v-Button.vue"

export default {
    name: "login",
    components: {
        VInput,
        VCheckbox,
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
                remember: false
            },
            showingPassword: false,
            processing: false,
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
    methods:{
        ...mapActions({
            userLogin: 'auth/userLogin',
            userLoad: 'auth/userLoad',
            setAlert: 'alerts/setAlert'
        }),
        submit() {
            this.form.processing = true
            this.validationErrors = {}

            this.userLogin(this.form)
                .then(() => {
                    this.userLoad()
                        .then(() => {
                            this.$router.push({name: 'my-metrics'})
                        })
                        .catch(({response}) => {
                            this.setAlert({type: 'danger', message: response.data.message})
                        })
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
