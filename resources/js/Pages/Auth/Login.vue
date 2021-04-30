<template>
	<breeze-validation-errors class="mb-4" />

	<div v-if="status" class="mb-4 font-medium text-sm text-green-600">
		{{ status }}
	</div>

	<form class="form-signin" @submit.prevent="submit">
		<img class="mb-4" src="https://www.tickmill.eu/site/themes/tickmill/images/logos/tickmill-light.svg" alt="" width="250">
		<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
		<label for="inputEmail" class="sr-only">Email address</label>
		<breeze-input id="email" type="email" placeholder="Email" class="form-control" v-model="form.email" required autofocus autocomplete="username" />
		<label for="inputPassword" class="sr-only">Password</label>
		<breeze-input id="password" type="password" placeholder="Password" class="form-control" v-model="form.password" required autocomplete="current-password" />
		<div class="checkbox mb-3">
			<label>
			<breeze-checkbox name="remember" v-model:checked="form.remember" /> Remember me
			</label>
		</div>
		<breeze-button class="btn btn-lg btn-primary btn-block" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
		Log in
		</breeze-button>
	</form>


</template>

<script>
	import BreezeButton from '@/Components/Button'
	import BreezeGuestLayout from "@/Layouts/Guest"
	import BreezeInput from '@/Components/Input'
	import BreezeCheckbox from '@/Components/Checkbox'
	import BreezeLabel from '@/Components/Label'
	import BreezeValidationErrors from '@/Components/ValidationErrors'

	export default {
		layout: BreezeGuestLayout,

		components: {
			BreezeButton,
			BreezeInput,
			BreezeCheckbox,
			BreezeLabel,
			BreezeValidationErrors
		},

		props: {
			auth: Object,
			canResetPassword: Boolean,
			errors: Object,
			status: String,
		},

		data() {
			return {
				form: this.$inertia.form({
					email: '',
					password: '',
					remember: false
				})
			}
		},

		methods: {
			submit() {
				this.form
					.transform(data => ({
						... data,
						remember: this.form.remember ? 'on' : ''
					}))
					.post(this.route('login'), {
						onFinish: () => this.form.reset('password'),
					})
			}
		}
	}
</script>
